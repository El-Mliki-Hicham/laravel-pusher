<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MakeModelWithRequest extends Command
{
    protected $signature = 'make:generate-all {name} {columns}';

    protected $description = 'Create a model and its corresponding request file';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }
    public function handle()
    {
        $nameArg = $this->argument('name');
        $columnsArg = $this->argument('columns');
        $name = ucfirst($nameArg);
        $lcName = strtolower($nameArg);
        $culomnsAndkeys = explode(',', $columnsArg);

        $valueArray = array();
        $columns = array();
        foreach ($culomnsAndkeys as $culomn) {
            $result = explode(':', $culomn);
            $columns[] = $result[0];
            $typeAndCaract = explode('.', $result[1]);
            $types[] = $typeAndCaract[0];
            $caract[] = array_slice($typeAndCaract, 1);
            // $this->info($caract[0][0]);

        }
        //Generate the model
        Artisan::call('make:model-customized', [
            'name' => $name,
        ]);

        // Generate the request file
        Artisan::call('make:request-customized', [
            'name' => $name,
            'columns' =>  $columns,
            'caract' => $caract,
        ]);

        // Generate the controller
        Artisan::call('make:controller-customized', [
            'name' => $name,
            'columns' => $columns,
        ]);

        // Generate the migration
        Artisan::call('make:migration-customized', [
            'name' => $name,
            'columns' =>  $columns,
            'types' => $types,
            'caract' => $caract,
        ]);

        // Generate the factory
        Artisan::call('make:factory-customized', [
            'name' => $name,
            'columns' =>  $columns,
            'types' => $types
        ]);

        // Generate the seeder
        Artisan::call('make:seeder-customized', [
            'name' => $name,
        ]);

        // Generate the view
        Artisan::call('make:view-customize', [
            'name' => strtolower($name),
            'columns' => $columns,
        ]);
        Artisan::call('make:api-generate', [
            'name' => $nameArg,
            'columns' => $columnsArg,
        ]);

        // Specify the folder name and file name
        $folderNameFr = "lang/fr/models";
        $folderNameEn = "lang/en/models";
        $folderNameAr = "lang/ar/models";
        $fileName = $lcName . ".php";

        // Create the file inside the folder
        $columnsInContent = "";
        foreach ($columns as  $column) {
            $columnsInContent .=   "'$column'=>'$column'" . ",\n";
        }
        $columnsInContent .=   "'$name'=>'$name'" . ",\n";

        File::put($folderNameFr . '/' . $fileName, "<?php\n\nreturn [" . $columnsInContent . "];");
        File::put($folderNameEn . '/' . $fileName, "<?php\n\nreturn [" . $columnsInContent . "];");
        File::put($folderNameAr . '/' . $fileName, "<?php\n\nreturn [" . $columnsInContent . "];");

        //  // Generate the routes
        $sidebaresPath = base_path('lang/fr/sidebar.php');
        $sidebaresPathEn = base_path('lang/en/sidebar.php');
        $sidebaresPathAr = base_path('lang/ar/sidebar.php');
        $sidebareContents = $this->filesystem->get($sidebaresPath);
        $sidebareContentsEn = $this->filesystem->get($sidebaresPathEn);
        $sidebareContentsAn = $this->filesystem->get($sidebaresPathAr);

        $sidebareDefinition = '"' . $lcName . '"' . ' => "' . $lcName . '",' . PHP_EOL . '#addHere';  // Corrected the variable and added a newline

        // Replace #addHere with $sidebareDefinition in the contents
        $sidebareContents = str_replace('#addHere', $sidebareDefinition, $sidebareContents);
        $sidebareContentsEn = str_replace('#addHere', $sidebareDefinition, $sidebareContentsEn);
        $sidebareContentsAn = str_replace('#addHere', $sidebareDefinition, $sidebareContentsAn);

        // Write the modified contents back to the sidebar file
        $this->filesystem->put($sidebaresPath, $sidebareContents);
        $this->filesystem->put($sidebaresPathAr, $sidebareContentsAn);
        $this->filesystem->put($sidebaresPathEn, $sidebareContentsEn);

        $sidebarBlade = resource_path('views/layouts/sidebar.blade.php');
        $sidebarBladeContents = File::get($sidebarBlade);

        $lcTitleWithLg = "
        <li class=''><a class='' href='{{route('$lcName.index')}}' aria-expanded='false'>
        <i class='fas fa-home'></i>
        <span class='nav-text'>{{ strtolower(__('sidebar.$lcName')) }}</span>
    </a>
</li>
        " . PHP_EOL . '<!--sidebareHere-->';



        $sidebareContents = str_replace('<!--sidebareHere-->', $lcTitleWithLg, $sidebarBladeContents);
        File::put($sidebarBlade, $sidebareContents);
        // end sidebar

        $this->generateRoutes($name, $lcName);

        $this->info('Model,routes,request file, controller, migration,factory,view created successfully!');
    }
    protected function generateRoutes($name, $lcName)
    {
        $routesPath = base_path('routes/web.php');
        $routeContents = $this->filesystem->get($routesPath);

        // Generate the route definition
        $routeDefinition = '// ' . $name . ' Routes
        Route::resource(' . "'" . $lcName . "'" . ',' . "'" . 'App\Http\Controllers\\' . $name . 'Controller' . "'" . ');';

        // Append the route definition to the routes file
        $routeContents .= $routeDefinition;

        // Write the updated contents back to the routes file
        $this->filesystem->put($routesPath, $routeContents);
    }
}
