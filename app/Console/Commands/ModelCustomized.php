<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class ModelCustomized extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-customized {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model and its relationship';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        $ucTitle = ucfirst($name);
        $lcTitle = strtolower($name);
        
        // index file

        $customModelPath = app_path('Models/Customs/CustomModel.php');
        $ModelPath = app_path('Models/' . $ucTitle . '.php');

        // Read the contents of the custom template file
        $customTemplateContents = File::get($customModelPath);

        // Create the directory for the view if it doesn't exist
        File::ensureDirectoryExists(dirname($ModelPath));      

        $customTemplateContents = str_replace('<!--uc_name-->', $ucTitle, $customTemplateContents);

        // Write the modified custom template contents to the view file
        File::put($ModelPath, $customTemplateContents);

        $this->info('Model created successfully!');

    }
}
