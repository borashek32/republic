<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'user_id'        => $this->faker->randomElement(User::pluck('id')->toArray()),
            'postable_type'  => $this->faker->randomElement([
                'App\Models\Tree',
                'App\Models\Grass',
                'App\Models\Flower'
            ]),
            'postable_id'    => random_int(1, 10),
            'title'          => $this->faker->words(2, true),
            'description'    => $this->faker->words(100, true),
            'visability'     => $this->faker->randomElement(['1', '0'])
        ];
    }
}
