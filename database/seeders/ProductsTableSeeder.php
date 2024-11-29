<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('products')->insert([
            'name' => 'Adidas Samba OG Cloud White Core Black',
            'image_url' => 'https://d5ibtax54de3q.cloudfront.net/eyJidWNrZXQiOiJraWNrYXZlbnVlLWFzc2V0cyIsImtleSI6InByb2R1Y3RzLzM3NDMvZGE3MzdhZTYzYTMwMzUxN2VhZWQyMTgyMzBlYjYwMTMucG5nIiwiZWRpdHMiOnsicmVzaXplIjp7IndpZHRoIjoxNDAwfX19',
            'price' => 1380000,
            'stock' => 50,
            'category_id' => 1,
            'brand_id' => 1
        ]);

        DB::table('products')->insert([
            'name' => 'Never Too Lavish Jersey',
            'image_url' => 'https://d5ibtax54de3q.cloudfront.net/eyJidWNrZXQiOiJraWNrYXZlbnVlLWFzc2V0cyIsImtleSI6InByb2R1Y3RzLzcxMjMwLzFmZjExZjYzZmFhM2IwOWYyNTE1ZmM2NTc1MWMyOTE2LnBuZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6MTQwMH19fQ==',
            'price' => 249500,
            'stock' => 20,
            'category_id' => 2,
            'brand_id' => 2
        ]);

    }
}
