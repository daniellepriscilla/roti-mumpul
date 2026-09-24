<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $legi = Category::where('slug', 'seri-legi')->firstOrFail();
        $gurih = Category::where('slug', 'seri-gurih')->firstOrFail();
        $kering = Category::where('slug', 'seri-kering')->firstOrFail();

        $products = [
            [
                'category_id' => $legi->id,
                'name' => 'Buttercream',
                'description' => 'Roti empuk khas Mumpul dengan isian buttercream yang melimpah.',
                'price' => 28000,
                'is_best_seller' => true,
                'image' => 'images/products/butter-cream.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Coklat',
                'description' => 'Roti empuk khas Mumpul dengan isian coklat lumer yang melimpah.',
                'price' => 33000,
                'is_best_seller' => false,
                'image' => 'images/products/coklat.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Keju',
                'description' => 'Roti empuk khas Mumpul dengan isian buttercream dan parutan keju yang melimpah.',
                'price' => 33000,
                'is_best_seller' => false,
                'image' => 'images/products/keju.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Mix (Buttercream, Coklat, Keju)',
                'description' => 'Roti empuk khas Mumpul dengan isian buttercream, coklat lumer, dan parutan keju yang melimpah.',
                'price' => 35000,
                'is_best_seller' => true,
                'image' => 'images/products/mix.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Nutella',
                'description' => 'Roti empuk khas Mumpul dengan isian coklat Nutella yang melimpah.',
                'price' => 50000,
                'is_best_seller' => false,
                'image' => 'images/products/nutella.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Mocca',
                'description' => 'Roti empuk khas Mumpul dengan isian selai Mocca buatan resep terbaik yang melimpah.',
                'price' => 33000,
                'is_best_seller' => false,
                'image' => 'images/products/mocca.jpg',
            ],
            [
                'category_id' => $legi->id,
                'name' => 'Pistachio',
                'description' => 'Roti empuk khas Mumpul dengan isian selai Pistachio asli yang melimpah.',
                'price' => 50000,
                'is_best_seller' => false,
                'image' => 'images/products/pistachio.jpg',
            ],

            [
                'category_id' => $gurih->id,
                'name' => 'Abon',
                'description' => 'Roti lembut berlapis abon sapi melimpah dengan sentuhan olesan saus gurih.',
                'price' => 40000,
                'is_best_seller' => true,
                'image' => 'images/products/abon.jpg',
            ],
            [
                'category_id' => $gurih->id,
                'name' => 'Smokedbeef',
                'description' => 'Roti gurih dengan olahan daging sapi (smoked beef) resep spesial beraroma rempah pilihan.',
                'price' => 40000,
                'is_best_seller' => false,
                'image' => 'images/products/smoked-beef.jpg',
            ],
            [
                'category_id' => $gurih->id,
                'name' => 'Tuna Mayo',
                'description' => 'Roti gurih dengan olahan daging tuna dengan mayonaise resep spesial pilihan.',
                'price' => 50000,
                'is_best_seller' => false,
                'image' => 'images/products/tuna-mayo.jpg',
            ],

            [
                'category_id' => $kering->id,
                'name' => 'Bagelen Original',
                'description' => 'Roti bagelen kering renyah bertabur butter yang wangi.',
                'price' => 30000,
                'is_best_seller' => true,
                'image' => 'images/products/bagelen.jpg',
            ],
            [
                'category_id' => $kering->id,
                'name' => 'Bagelen Mocca',
                'description' => 'Roti bagelen kering renyah bertabur butter dan mocca yang wangi.',
                'price' => 30000,
                'is_best_seller' => false,
                'image' => 'images/products/bagelen.jpg',
            ],
            [
                'category_id' => $kering->id,
                'name' => 'Bagelen Keju',
                'description' => 'Roti bagelen kering renyah bertabur butter dan keju yang wangi melimpah.',
                'price' => 35000,
                'is_best_seller' => false,
                'image' => 'images/products/bagelen.jpg',
            ],
            [
                'category_id' => $kering->id,
                'name' => 'Bagelen Garlic Butter',
                'description' => 'Roti bagelen kering renyah bertabur garlic butter melimpah yang wangi.',
                'price' => 35000,
                'is_best_seller' => false,
                'image' => 'images/products/bagelen.jpg',
            ],
        ];

        foreach ($products as $item) {
            $slug = Str::slug($item['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, ['slug' => $slug])
            );
        }
    }
}
