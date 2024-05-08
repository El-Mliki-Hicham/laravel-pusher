<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FactoryCustomized extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:factory-customized {name} {columns} {types}';

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
        $columns = $this->argument('columns');
        $types = $this->argument('types');
        $customFactoryPath = base_path('database/factories/Customs/CustomFactory.php');
        $factoryPath = base_path('database/factories/' . ucfirst($name) . 'Factory.php');

        // Read the contents of the custom Request file
        $customFactoryContents = File::get($customFactoryPath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($factoryPath));

        $factory = "";
        $import = "";
        for ($i=0;$i<count($columns);$i++){
//            $factory .= "\"$columns[$i]\"".' => $this->faker->sentence,
//            ';
            $possibilities = ["string"=>"word","text"=>"paragraph","integer"=>"numberBetween(1, 100)","biginteger"=>"randomNumber(9)",
                "decimal"=>"randomFloat(2, 10, 100)","double"=>"randomFloat(2, 10, 100)","float"=>"randomFloat(2, 10, 100)",
                "boolean"=>"boolean","date"=>"date","dateTime"=>"dateTime","timestamp"=>"dateTime","time"=>"time","json"=>"json"];
            if ($types[$i]=="unsignedBigInteger"){
                $factory .= "\"$columns[$i]\"".' => '.ucfirst(explode('_', $columns[$i])[0]).'::inRandomOrder()->first()->id,
            ';
                $import .= 'use App\Models\\'.ucfirst($name).'
                ;';
            }
            else{
                $factory .= "\"$columns[$i]\"".' => $this->faker->'.$possibilities[$types[$i]].',
            ';
            }
        }
        $customFactoryContents = str_replace('#importhere', $import, $customFactoryContents);
        $customFactoryContents = str_replace('#factoryhere', $factory, $customFactoryContents);
        $customFactoryContents = str_replace('<!--uc_name-->', ucfirst($name), $customFactoryContents);


        // Write the modified custom Request contents to the view file
        File::put($factoryPath, $customFactoryContents);

        $this->info('Factory created successfully!');
    }
}
