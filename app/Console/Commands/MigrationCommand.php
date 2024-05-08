<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class MigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:migration-customized {name} {columns} {types} {caract}';

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
        $types = $this->argument('types');
        $caract = $this->argument('caract');
        $customMigration = base_path('database/migrations/Customs/customMigration.php');
        $migrationPath = base_path('database/migrations/'  . '_create_' . strtolower($name . "s") . '_table' . '.php');

        // Read the contents of the custom Migration file
        $customMigrationContents = File::get($customMigration);

        // Create the directory for the migration if it doesn't exist
        File::ensureDirectoryExists(dirname($migrationPath));
$champ = "";
$migrationCharacteristiques = ['unique','nullable'];
        for ($i = 0; $i < count($columns); $i++) {
                        $champ .= '$table->' . $types[$i] . '("' . $columns[$i] . '")'. ( ($caract[$i][0]=='unique'|| $caract[$i][0]=='nullable') ?  ('->' . $caract[$i][0] . '();') : ";" ) .'
                        ';
        if (substr($columns[$i], -3) === "_id"){
            $explode =  explode("_id",$columns[$i]);
            $champ .= '$table->foreign("' . $columns[$i] . '")->references("id")->on("'.$explode[0].'s")->onDelete("cascade");
            ';
        }
                    }

        
        $customMigrationContents = str_replace('#columns', $champ, $customMigrationContents);
                    $customMigrationContents = str_replace('<!--lc_name-->', strtolower($name."s"), $customMigrationContents);
                    // Write the custom template contents to the view file
                    File::put($migrationPath, $customMigrationContents);
    }
}
