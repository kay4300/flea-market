<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

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
        return [
            'item_id' => 1,            // Seederで上書き予定
            'user_id' => 1,            // Seederで上書き予定
            'body' => $this->faker->sentence,
            //
        ];
    }
}
