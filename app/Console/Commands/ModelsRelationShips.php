<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ModelsRelationShips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:relationship {relation} {Model1} {Model2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model relationships';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $relation = strtolower($this->argument('relation'));
        $model1 = strtolower($this->argument('Model1'));
        $model2 = strtolower($this->argument('Model2'));

        $model1Path = app_path('Models/'.$model1.'.php');
        $model1Contents = $this->filesystem->get($model1Path);

        $model2Path = app_path('Models/'.$model2.'.php');
        $model2Contents = $this->filesystem->get($model2Path);



        if($relation == "onetomany"){
            $hasMany = '# Relation type : '.$relation.' , between '.$model1.' and '.$model2.'
             public function '.$model2.'s(){
                return $this->hasMany('.ucfirst($model2).'::class,"'.$model1.'_id");
            }
            
            #relationships_here
            ';

            $belongsTo = '# Relation type : '.$relation.' , between '.$model1.' and '.$model2.'
             public function '.$model1.'(){
                return $this->belongsToMany('.ucfirst($model1).'::class,"'.$model1.'_id");
            }
            
            #relationships_here
            ';

            $model1Contents = str_replace('#relationships_here', $hasMany, $model1Contents);
            $model2Contents = str_replace('#relationships_here', $belongsTo, $model2Contents);

        }elseif($relation == "manytomany"){
            $hasMany1 = '# Relation type : '.$relation.' , between '.$model1.' and '.$model2.'
             public function '.$model2.'s(){
                return $this->belongsToMany('.ucfirst($model2).'::class,"'.$model1.'_'.$model2.'s","'.$model1.'_id","'.$model2.'_id");
            }
            
            #relationships_here
            ';

            $hasMany2 = '# Relation type : '.$relation.' , between '.$model1.' and '.$model2.'
            public function '.$model1.'s(){
               return $this->belongsToMany('.ucfirst($model1).'::class,"'.$model1.'_'.$model2.'s","'.$model2.'_id","'.$model1.'_id");
           }
           
           #relationships_here
           ';

           $model1Contents = str_replace('#relationships_here', $hasMany1, $model1Contents);
           $model2Contents = str_replace('#relationships_here', $hasMany2, $model2Contents);
            
        }
        
                    $this->filesystem->put($model1Path, $model1Contents);
                    $this->filesystem->put($model2Path, $model2Contents);
        

    }
}
