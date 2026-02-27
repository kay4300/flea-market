<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $user = User::first();
        Item::factory()->count(10)->create([
            'user_id' => User::first()->id

        ]);

        $items = [
            'タンブラー' => ['キッチン'],
            'グラス' => ['キッチン'],
            'ペン' => ['アクセサリー'],
            'ヘッドフォン' => ['家電', 'アクセサリー'],
            '一人用ソファ' => ['インテリア'],
            'カトラリーセット' => ['キッチン'],
            '食器' => ['キッチン'],
            'ショルダーバッグ' => ['ファッション', 'アクセサリー', 'レディース'],
            'ヘアドライヤー' => ['家電'],
            'ノートパソコン' => ['家電'],

        ];

        foreach ($items as $itemName => $categoryNames) {

            $item = Item::where('name', $itemName)->first();

            $categoryIds = Category::whereIn('name', $categoryNames)
                ->pluck('id');

            $item->categories()->sync($categoryIds);
        //
        }
    }    
}
