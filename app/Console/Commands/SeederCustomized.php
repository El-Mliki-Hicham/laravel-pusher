<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class SeederCustomized extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:seeder-customized {name}';

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
        $name = $this->argument('name');
        $customSeedPath = base_path('database/seeders/Customs/CustomSeeder.php');
        $seedPath = base_path('database/seeders/' . ucfirst($name) . 'Seeder.php');
        // Read the contents of the custom Request file
        $customSeedContents = File::get($customSeedPath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($seedPath));
        $callFactory = ucfirst($name)."::factory(10)->create();
        ";
        $import = 'use App\Models\\'.ucfirst($name).'
                ;';

        $customSeedContents = str_replace('#importhere', $import, $customSeedContents);
        $customSeedContents = str_replace('#factoryhere', $callFactory, $customSeedContents);
        $customSeedContents = str_replace('<!--uc_name-->', ucfirst($name), $customSeedContents);


        // Write the modified custom Request contents to the view file
        File::put($seedPath, $customSeedContents);

        $dbSeederPath = base_path('database/seeders/DatabaseSeeder.php');
        // Read the contents of the custom Request file
        $dbSeederContents = File::get($dbSeederPath);

        // Create the directory for the view if it doesn't exist
        $callSeeder="";
        $import = "";
        $import .= 'use App\Models\\'.ucfirst($name).'
                ;';
        $callSeeder .= '$this->call('.ucfirst($name).'Seeder::class);
        #callseederhere
        ';

        $customFactoryContents = str_replace('#importhere', $import, $dbSeederContents);
        $dbSeederContents = str_replace('#callseederhere', $callSeeder, $dbSeederContents);
        //$dbSeederContents = str_replace('<!--uc_name-->', ucfirst($name), $customSeedContents);


        // Write the modified custom Request contents to the view file
        File::put($dbSeederPath, $dbSeederContents);


        $this->info('Factory created successfully!');

    }
}
