<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use Faker\Factory as FakerFactory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create('ja_JP');

        return [
            'item_id' => 1,            // Seederで上書き予定
            'user_id' => 1,            // Seederで上書き予定
            'body' => $this->faker->realText(100),
            //
        ];
    }
}
