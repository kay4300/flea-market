<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;


class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $products = [
            'ノートパソコン' => [
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'description' => '高機能なノートパソコンで仕事にも学習にも最適です。',
                'brand' => 'Dell',
                'price_options' => [50000, 100000, 150000],
            ],
            'ショルダーバッグ' => [
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'description' => '毎日の通勤やお出かけに最適なショルダーバッグです。',
                'brand' => 'Coach',
                'price_options' => [10000, 20000, 30000],
            ],
            'タンブラー' => [
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'description' => 'お気に入りの飲み物を冷やして楽しむためのタンブラーです。',
                'brand' => 'Yeti',
                'price_options' => [2000, 3000, 5000],
            ],
            'ペン' => [
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS72Cx2SE3YRbiwb86BTCopKmrGlBO8XsielA&s',
                'description' => '書き心地の良いペンで、丁寧な字を書くことができます。',
                'brand' => 'Parker',
                'price_options' => [5000, 10000, 15000],
            ],
            'ヘッドフォン' => [
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeYnEG443swOk3yZraIPdDDe61TcNirpEN3g&s',
                'description' => '高音質で快適な音楽体験を提供するヘッドフォンです。',
                'brand' => 'Sony',
                'price_options' => [5000, 10000, 15000],
            ],
            'グラス' => [
                'image' => 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTXn935N8gCrh670d0Dd4rC1fzEjIikY3X8V90yWOIfNtDBmykcPqiQwzbdHZhnPokHSU2jxHNmJsEhIk770oARDqMeXhClLqV1AHu6XxRBrwF-JIR4-BxtOlUH',
                'description' => '洗練されたデザインで、日常に彩りを加えるグラスです。',
                'brand' => 'Baccarat',
                'price_options' => [1000, 2000, 3000],
            ],
            '食器' => [
                'image' => 'https://www.eizawa.com/wp-content/uploads/2023/12/meissen_onion.jpg',
                'description' => '洗練されたデザインで、日常に彩りを加える食器です。',
                'brand' => 'Meissen',
                'price_options' => [2000, 3000, 4000],
            ],
            '一人用ソファ' => [
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSt1Yg9tSJrGd-RdqZQmaC9yoUKQdaZ3EPiGQ&s',
                'description' => '一人で快適に過ごせるソファです。',
                'brand' => 'IKEA',
                'price_options' => [3000, 5000, 10000],
            ],
            'カトラリーセット' => [
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTy7OALs8-weNzLVwlQWS3nSFo24kYvnPfzg&s',
                'description' => '高品質なカトラリーで、食事の質を向上させます。',
                'brand' => '',
                'price_options' => [1000, 1500, 3000],
            ],
        ];
        $name = $this->faker->randomElement(array_keys($products));

        return [
            'name' => $name, // 商品名
            'price' => $this->faker->randomElement($products[$name]['price_options']), // 価格
            'brand' => $products[$name]['brand'], // ブランド名
            'description' => $products[$name]['description'], // 商品説明
            'image' => $products[$name]['image'], // 画像URL
            'item_condition' => $this->faker->randomElement([
                '新品',
                '未使用に近い',
                '目立った傷や汚れなし',
                'やや傷や汚れあり',
            ]),
        ];
    }
    //
}
