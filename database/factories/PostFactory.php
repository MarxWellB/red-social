<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'titulo'=> $this->faker->sentence(3),
            'url'=> $this->faker->uuid().'.jpg',
            // para las urls de la foto 'imagen'=>$this->faker->uuid().'.jpg'
            //aqui va el foraneo para relacionar
            'user_id'=> $this->faker->randomElement([1,2,3,4,5,6,7])
        ];
    }
}
