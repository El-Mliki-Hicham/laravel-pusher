<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ApiGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-generate {name} {columns}';

    protected $description = 'generate apis for model';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    public function handle()
    {
        $nameArg = $this->argument('name');
        $ucName = ucfirst($this->argument('name'));
        $lcName = strtolower($this->argument('name'));
        $columnsArg = $this->argument('columns');
        $culomnsAndkeys = explode(',', $columnsArg);
        $valueArray = array();
        $columns = array();
        foreach($culomnsAndkeys as $culomn){
            $result = explode(':', $culomn);
            $columns[] = $result[0];
            $typeAndCaract = explode('.', $result[1]);
            $types[] = $typeAndCaract[0];
            $caract[] = array_slice($typeAndCaract, 1);
           // $this->info($caract[0][0]);
           
        }
        // Artisan::call('make:model-customized', [
        //     'name' => $nameArg,
        // ]);
        
        // Artisan::call('make:migration-customized', [
        //     'name' => $nameArg,
        //     'columns' =>  $columns,
        //     'types' => $types,
        //     'caract' => $caract,
        // ]);

        // Artisan::call('make:request-customized', [
        //     'name' => $nameArg,
        //     'columns' =>  $columns,
        //     'caract' => $caract,
        // ]);

        

        $customControllerPath = app_path('Http/Controllers/Api/Customs/CustomController.php');
        $controllerPath = app_path('Http/Controllers/Api/' . $ucName . 'ApiController.php');

        // Read the contents of the custom template file
        $customControllerContents = File::get($customControllerPath);

        // Generate the custom controller file
        $store = "";
        foreach ($columns as $column) {
            $store .= "$".$lcName."->".$column."=\$request->".$column.";\n" ;
        }


        $customControllerContents = str_replace('<!--uc_name-->', $ucName, $customControllerContents);
        $customControllerContents = str_replace('<!--lc_names-->', $lcName, $customControllerContents);
        $customControllerContents = str_replace('<!--columns_store-->', $store, $customControllerContents);
        $update = $store;
        $customControllerContents = str_replace('<!--columns_update-->', $update, $customControllerContents);


        File::put($controllerPath, $customControllerContents);

        $routesPath = base_path('routes/api.php');
        $routeContents = $this->filesystem->get($routesPath);

        // Generate the route definition
        $routeDefinition = '// ' . $ucName . ' Routes
        Route::resource('."'".$lcName."'".','."'".'App\Http\Controllers\\'.$ucName.'Controller'."'".');';

        // Append the route definition to the routes file
        $routeContents .= $routeDefinition;

        // Write the updated contents back to the routes file
        $this->filesystem->put($routesPath, $routeContents);




        $this->info('Custom controller generated successfully!');

    }
}
