<?php

namespace Database\Factories;

#importhere

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\<!--uc_name-->;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class <!--uc_name-->Factory extends Factory
{

    protected $model = <!--uc_name-->::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            #factoryhere
        ];
    }
}
