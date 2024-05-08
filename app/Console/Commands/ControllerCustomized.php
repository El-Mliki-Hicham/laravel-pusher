<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ControllerCustomized extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller-customized {name} {columns}';

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
        $argement = $this->argument("name");
        $lcName = strtolower($argement);
        $ucName = ucfirst($argement);
        $columnsArg = $this->argument('columns');
        $columns =  $columnsArg;
        $lcNamewithLang = 'ucfirst(__("models/'.$lcName.'.'.$lcName.'"))';
        // Controller file
        $customControllerPath = app_path('Http/Controllers/Customs/CustomController.php');
        $controllerPath = app_path('Http/Controllers/' . $ucName . 'Controller.php');

        // Read the contents of the custom template file
        $customControllerContents = File::get($customControllerPath);

        // Generate the custom controller file
        $store = " ";
        $relation = " ";
        $relation_var = " ";
        $import_relation = " ";
        foreach ($columns as $column) {
            $store .= "$".$lcName."->".$column."=\$request->".$column.";\n" ;

            if (substr($column, -3) === "_id"){
                $culomnNamel = explode('_id',$column);
                $relation .= "$".$culomnNamel[0]."=".ucfirst($culomnNamel[0])."::all();\n " ;
                $relation_var .= ",'$culomnNamel[0]'";                 
                $import_relation .= "use App\Models\\".ucfirst($culomnNamel[0]) .";\n ";                 
               
              
            }
        }

        $customControllerContents = str_replace('<!--relation_var-->', $relation_var, $customControllerContents);
        $customControllerContents = str_replace('//relation_import', $import_relation, $customControllerContents);
        $customControllerContents = str_replace('<!--uc_name-->', $ucName, $customControllerContents);
        $customControllerContents = str_replace('<!--lc_names-->', $lcName, $customControllerContents);
        $customControllerContents = str_replace('<!--relation-->', $relation, $customControllerContents);
        $customControllerContents = str_replace('<!--lc_names_lng-->', $lcNamewithLang, $customControllerContents);
        $customControllerContents = str_replace('<!--columns_store-->', $store, $customControllerContents);
        $update = $store;
        $customControllerContents = str_replace('<!--columns_update-->', $update, $customControllerContents);


        File::put($controllerPath, $customControllerContents);
        $this->info('Custom controller generated successfully!');
    }
}
