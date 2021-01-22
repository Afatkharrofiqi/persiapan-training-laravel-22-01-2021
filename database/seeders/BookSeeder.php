<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            [
                'name'      => 'Laravel Programming',
                'slug'      => 'laravel-programming',
                'categories'=> [
                    'Programming',
                    'Science'
                ],
                'image'     => null,
                'created_by'=> '1',
                'updated_by'=> null,
            ]
        ];

        foreach($books as $index => $book) {
            DB::beginTransaction();
            try {
                //code...
                $bookModel = new Book();
                $bookModel->name = $book['name'];
                $bookModel->slug = Str::slug($book['name']);
                $bookModel->created_by = $book['created_by'];
                $bookModel->updated_by = $book['updated_by'];
                $bookModel->save();

                $categoriesId = [];
                foreach($book['categories'] as $category) {
                    $categoriesId[] = Category::firstOrCreate([
                        'name'      => $category
                    ],[
                        'slug_name' => Str::slug($category)
                    ])->id;
                }
                $bookModel->categories()->sync($categoriesId);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th->getMessage());
            }
        }
    }
}
