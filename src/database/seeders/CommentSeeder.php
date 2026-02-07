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

        $user = User::first(); // コメント投稿者も既存ユーザー
        $items = Item::all();

        // 良い評価
        $goodComments = [
            "とても使いやすく満足しています。",
            "品質が良く、価格以上の価値があると思います。",
            "デザインも良く、長く使えそうです。",
            "期待以上の性能でした。",
            "購入して正解でした。",
        ];

        // 悪い評価
        $badComments = [
            "思っていたより使いにくかったです。",
            "価格の割に品質がいまいちでした。",
            "少し期待外れでした。",
            "改善の余地があると思います。",
            "もう少し工夫してほしいです。",
        ];

        $users = User::all(); // すべてのユーザーを取得

        foreach ($items as $item) {
            // itemごとに良いコメントの確率を決める
            // 例: IDが偶数なら良い評価80%、奇数なら60%
            $goodChance = $item->id % 2 === 0 ? 80 : 60;

            Comment::factory()->count(3)->make()->each(function ($comment) use ($item, $users, $faker, $goodComments, $badComments, $goodChance) {
                    $comment->user_id = $users->random()->id;
                    $comment->item_id = $item->id;
                    $comment->body = $this->makeReviewComment(
                    $item->name,
                    $goodComments,
                    $badComments,
                    $faker,
                    $goodChance // <- 確率を渡す
                );
                    $comment->save();
            });
        }
        //
    }
    private function makeReviewComment($itemName, $goodComments, $badComments, $faker, $goodChance)
    {
        // 70%で良い評価
        if ($faker->boolean($goodChance)) {
            $comment = $faker->randomElement($goodComments);
        } else {
            $comment = $faker->randomElement($badComments);
        }

        return "「{$itemName}」についての評価です。{$comment}";
    }
}
