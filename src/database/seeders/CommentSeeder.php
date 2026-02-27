<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Faker\Factory as FakerFactory;


class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create('ja_JP');

        $users = User::all(); 
        $items = Item::all();

        // 良い評価
        $sampleComments = [
            "とても使いやすく満足しています。",
            "品質が良く、価格以上の価値があると思います。",
            "デザインも良く、長く使えそうです。",
            "期待以上の性能でした。",
            "購入して正解でした。",
            "思っていたより使いにくかったです。",
            "デザインは良いですが機能が不十分でした。",
            "少し期待外れでした。",
        
        ];

        $combinations = [];

        // 全てのアイテムとユーザーの組み合わせを作成
        foreach ($items as $item) {
            foreach ($users as $user) {
                $combinations[] = ['item_id' => $item->id, 'user_id' => $user->id];
            }
        }

        // ランダム化
        shuffle($combinations);

        // 作成件数は必要な数だけ
        foreach (array_slice($combinations, 0, 50) as $data) {
            Comment::factory()->create([
                'item_id' => $data['item_id'],
                'user_id' => $data['user_id'],
                'body' => $faker->randomElement($sampleComments),
            ]);
        }
    }
}

