<?php

use Illuminate\Database\Seeder;
use App\Post;
class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Post::truncate();
        Post::create([
            "title"=>"test"
        ]);
        Post::create([
            "title"=>"test2"
        ]);
        Post::create([
            "title"=>"test3"
        ]);

    }
}
