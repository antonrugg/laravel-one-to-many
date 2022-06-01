<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [];

        foreach($categories as $category){
            $new_category_object = new Category();
            $new_category_object->name = $category;
            $new_category_object->slug = Str::slug($category);
            $new_category_object->save();
        }
    }
}
