<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); // コメント投稿者も既存ユーザー
        $items = Item::all();

        foreach ($items as $item) {
            Comment::factory()->count(3)->create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
        //
    }
}
