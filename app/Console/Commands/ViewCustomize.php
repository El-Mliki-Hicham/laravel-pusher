<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ViewCustomize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view-customize {name} {columns}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        $ucTitle = ucfirst($name);
        $lcTitle = strtolower($name);
        $lcTitleWithLg = "{{ strtolower(__('models/$lcTitle.$lcTitle')) }}"; //with language syntax
        $ucTitleWithLg = "{{ ucfirst(__('models/$lcTitle.$lcTitle')) }}"; //with language syntax
        // index file
        $customTemplatePath = resource_path('views/customs/custom-index.blade.php');
        $viewPath = resource_path('views/' . strtolower($name) . '/index.blade.php');

        // Read the contents of the custom template file
        $customTemplateContents = File::get($customTemplatePath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($viewPath));

        // Replace the column placeholders in the custom template contents
        $columnsArg = $this->argument('columns');
        $columns = $columnsArg;

        $replacementCulomns = '';
        $replacementValue = '';

        foreach ($columns as $column) {

            if (substr($column, -3) === "_id"){
                $culomnNamel = explode('_id',$column);
                $replacementValue .= "<td>{{\$value->$culomnNamel[0]->id}}</td>\n";
            }else{
                $replacementValue .= "<td>{{\$value->$column}}</td>\n";
            }
            $replacementCulomns .= "<th>{{ucFirst(__('models/$lcTitle.$column'))}}</th>\n";
            
        }

        $customTemplateContents = str_replace('<!--columns-->', $replacementCulomns, $customTemplateContents);
        $customTemplateContents = str_replace('<!--value-->', $replacementValue, $customTemplateContents);

        $customTemplateContents = str_replace('<!--uc_title-->', $ucTitleWithLg, $customTemplateContents);
        $customTemplateContents = str_replace('<!--lc_title-->', $ucTitleWithLg, $customTemplateContents);
        $customTemplateContents = str_replace('<!--route-->', $lcTitle, $customTemplateContents);

        // Write the modified custom template contents to the view file
        File::put($viewPath, $customTemplateContents);

        ///////////////// create file ////////////////

        $customTemplatePath = resource_path('views/customs/custom-create.blade.php');
        $viewPath = resource_path('views/' . strtolower($name) . '/create.blade.php');

        // Read the contents of the custom template file
        $customTemplateContents = File::get($customTemplatePath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($viewPath));

        $columnsArg = $this->argument('columns');
        $columns =  $columnsArg;

        $replacementCulomns = '';
        $replacementValue = '';
        foreach ($columns as $column) {

            if (substr($column, -3) === "_id") {
                $culomnNamel = explode('_id', $column);
                // $culomnNamel[0]
                $replacementCulomns .= "
                    <div class='mb-3 row'>
                    <label class='col-lg-4 col-form-label' for='validationCustom01'>
                    {{ucFirst(__('models/$lcTitle.$column'))}}
                    </label>
                    <div class='col-lg-6'>
                     <select class='form-control select2' name='$column'>
              @foreach ($$culomnNamel[0] as ".'$value'." )
              <option {{ old('$column') == ".'$value'."->id ? 'selected' : '' }} value='{{  ".'$value'."->id  }}'>{{  ".'$value'."->id  }}</option>
                @endforeach
             </select>
                  <div class='invalid-feedback'>
                      </div>
                      </div>
                </div>
                ";
            } else {
                // $replacementCulomns .= "<th>".ucFirst($column)."</th>\n";
                $replacementCulomns .= "
                <div class='mb-3 row'>
                <label class='col-lg-4 col-form-label' for='validationCustom01'>
                {{ucFirst(__('models/$lcTitle.$column'))}}
                </label>
                <div class='col-lg-6'>
                    <input type='text' class='form-control' name='$column' id='validationCustom01' value='$column' placeholder='{{ucFirst(__('models/$lcTitle.$column'))}}' required=''>
                    <div class='invalid-feedback'>
                    </div>
                </div>
            </div>
            ";
            }
        }
        // foreach ($columns as $column) {

        //     // $replacementCulomns .= "<th>{{ucFirst(__('models/$lcTitle.$column'))}}</th>\n";
        // }


        $customTemplateContents = str_replace('<!--uc_title-->', $ucTitleWithLg, $customTemplateContents);
        $customTemplateContents = str_replace('<!--lc_title-->', $ucTitleWithLg, $customTemplateContents);

        $customTemplateContents = str_replace('<!-- inputs -->', $replacementCulomns, $customTemplateContents);
        $customTemplateContents = str_replace('<!--route-->', $lcTitle, $customTemplateContents);



        // Write the custom template contents to the view file
        File::put($viewPath, $customTemplateContents);

        //////////////////// edit file ///////////////////////
        $customTemplatePath = resource_path('views/customs/custom-edit.blade.php');
        $viewPath = resource_path('views/' . strtolower($name) . '/edit.blade.php');

        // Read the contents of the custom template file
        $customTemplateContents = File::get($customTemplatePath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($viewPath));

        $columnsArg = $this->argument('columns');
        $columns =  $columnsArg;

        $replacementCulomns = '';
        $replacementValue = '';

        foreach ($columns as $column) {

            if (substr($column, -3) === "_id") {
                $culomnNamel = explode('_id', $column);
                // $culomnNamel[0]
                $replacementCulomns .= "
                    <div class='mb-3 row'>
                    <label class='col-lg-4 col-form-label' for='validationCustom01'>
                    {{ucFirst(__('models/$lcTitle.$column'))}}
                    </label>
                    <div class='col-lg-6'>
                     <select class='form-control select2' name='$column'>
              @foreach ($$culomnNamel[0] as ".'$value'." )
              <option {{ $$lcTitle->$culomnNamel[0]->id == ".'$value'."->id ? 'selected' : '' }} value='{{  ".'$value'."->id  }}'>{{  ".'$value'."->id  }}</option>
                @endforeach
             </select>
                  <div class='invalid-feedback'>
                      </div>
                      </div>
                </div>
                ";
            } else {

            // $replacementCulomns .= "<th>".ucFirst($column)."</th>\n";
            $replacementCulomns .= "
                <div class='mb-3 row'>
                <label class='col-lg-4 col-form-label' for='validationCustom01'>
                {{ucFirst(__('models/$lcTitle.$column'))}}
                </label>
                <div class='col-lg-6'>
                    <input type='text' class='form-control'  value='{{\$$lcTitle->$column}}' name='$column' id='validationCustom01' placeholder='$column' required=''>
                    <div class='invalid-feedback'>
                    </div>
                </div>
            </div>
            ";
        }
        }

        $customTemplateContents = str_replace('<!--uc_title-->', $ucTitleWithLg, $customTemplateContents);
        $customTemplateContents = str_replace('<!--lc_title-->', $lcTitleWithLg, $customTemplateContents);

        $customTemplateContents = str_replace('<!-- inputs -->', $replacementCulomns, $customTemplateContents);
        $customTemplateContents = str_replace('<!--route-->', $lcTitle, $customTemplateContents);

        // Write the custom template contents to the view file
        File::put($viewPath, $customTemplateContents);


        /////////////////////////show file//////////////////////////////
        $customTemplatePath = resource_path('views/customs/custom-show.blade.php');
        $viewPath = resource_path('views/' . strtolower($name) . '/show.blade.php');

        // Read the contents of the custom template file
        $customTemplateContents = File::get($customTemplatePath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($viewPath));

        $columnsArg = $this->argument('columns');
        $columns =  $columnsArg;

        $customTemplateContents = File::get($customTemplatePath);
        $replacementCulomns = '';
        $replacementValue = '';

        foreach ($columns as $column) {

            // $replacementCulomns .= "<th>".ucFirst($column)."</th>\n";
            $replacementCulomns .= "

            <p> {{ucFirst(__('models/$lcTitle.$column'))}}: <span class='item'>{{\$$lcTitle->$column}}</span>
            </p>
            ";
        }

        $customTemplateContents = str_replace('<!--uc_title-->', $ucTitleWithLg, $customTemplateContents);
        $customTemplateContents = str_replace('<!--lc_title-->', $lcTitleWithLg, $customTemplateContents);

        $customTemplateContents = str_replace('<!--inputs-->', $replacementCulomns, $customTemplateContents);





        // Write the custom template contents to the view file
        File::put($viewPath, $customTemplateContents);
        ////////////////// end show /////////////
        foreach ($columns as $key) {
            # code...
            $this->info($key);
        };
        $this->info('views created successfully');
    }
}
