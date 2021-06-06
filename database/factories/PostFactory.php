<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
class PostFactory extends Factory
{
    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users=User::all();
        return [
            'title'=>$this->faker->sentence(),
            'body'=>$this->faker->paragraph(),
            'user_id'=>$this->faker->randomElement($users),
        ];
    }
}
