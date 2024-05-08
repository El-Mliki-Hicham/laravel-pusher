<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RequestCustomized extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:request-customized {name} {columns} {caract}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration with customize fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $columns = $this->argument('columns');
        $caract = $this->argument('caract');
        $customRequestsPath = app_path('Http/Requests/Customs/CustomRequest.php');
        $RequestsPath = app_path('Http/Requests/' . ucfirst($name) . 'Request.php');

        // Read the contents of the custom Request file
        $customRequestContents = File::get($customRequestsPath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($RequestsPath));

        $rules = "";
        $messages = "";
        for ($i = 0; $i < count($columns); $i++) {
            $rule = "";
            $rule .= "\"$columns[$i]\"".' =>"';
            for($j =0;$j<count($caract[$i]) ;$j++){
                if ($j!=count($caract[$i])-1){
                    $rule .= $caract[$i][$j].'|';
                }
                else{
                    $rule .= $caract[$i][$j].'"';
                }
            }
            $rules .= $rule.',
            ';
        }
        // => 'required|string|unique:services,name',
        $customRequestContents = str_replace('#ruleshere', $rules, $customRequestContents);
        $customRequestContents = str_replace('<!--uc_name-->', ucfirst($name), $customRequestContents);


        // Write the modified custom Request contents to the view file
        File::put($RequestsPath, $customRequestContents);

        $this->info('Model created successfully!');

    }
}
