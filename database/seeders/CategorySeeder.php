<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'name'      => 'Science',
                'slug_name' => 'science',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'      => 'Action',
                'slug_name' => 'action',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'      => 'Comic Book',
                'slug_name' => 'comic-book',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ];

        Category::truncate();
        Category::insert($category);
    }
}
