<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Departments;
use App\Models\Post;
use App\Models\SubCategories;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        User::create([
            'name' => 'Farhan Dwi Septian',
            'username' => 'farhandwi',
            'email' => 'fkang788@gmail.com',
            'password' => bcrypt('12345')
        ]);

        // User::create([
        //     'name' => 'Doddy Ferdiansyah',
        //     'email' => 'doddy@gmail.com',
        //     'password' => bcrypt('12345')
        // ]);

        User::factory(3)->create();

        Category::create([
            'name' => 'Competition',
            'slug' => 'competition'
        ]);

        Category::create([
            'name' => 'Event',
            'slug' => 'event'
        ]);

        SubCategories::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);

        SubCategories::create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);

        SubCategories::create([
            'name' => 'Personal Life',
            'slug' => 'personal-life'
        ]);

        Post::factory(20)->create();

        Departments::create([
            "name" => "Internal",
            "slug" => "internal",
        ]);

        Departments::create([
            "name" => "Eksternal",
            "slug" => "eksternal",
        ]);

        Departments::create([
            "name" => "Pendidikan IT",
            "slug" => "pendidikan-it",
        ]);

        Departments::create([
            "name" => "Publikasi dan Dokumentasi",
            "slug" => "publikasi-dokumentasi",
        ]);

        // Post::create([
        //     'title' => 'Judul Pertama',
        //     'slug' => 'judul-pertama',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex ullam tempore delectus beatae similique amet eligendi at perferendis, quidem, quod est consequatur! Temporibus perferendis et doloribus illum minima cumque velit. Quibusdam nemo doloribus aut minus sunt aliquam excepturi ut, dignissimos cumque adipisci unde fugit at quis quia rerum quaerat sit ullam provident accusantium expedita ratione? Vero, maiores? Optio similique autem quas vitae accusantium totam consectetur possimus veritatis ducimus labore molestiae voluptatibus, aliquid cum doloremque. Sit tempore praesentium esse eaque nesciunt ipsum sed accusamus unde rem, tenetur, dolores pariatur.',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);

        // Post::create([
        //     'title' => 'Judul Ke Dua',
        //     'slug' => 'judul-ke-dua',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex ullam tempore delectus beatae similique amet eligendi at perferendis, quidem, quod est consequatur! Temporibus perferendis et doloribus illum minima cumque velit. Quibusdam nemo doloribus aut minus sunt aliquam excepturi ut, dignissimos cumque adipisci unde fugit at quis quia rerum quaerat sit ullam provident accusantium expedita ratione? Vero, maiores? Optio similique autem quas vitae accusantium totam consectetur possimus veritatis ducimus labore molestiae voluptatibus, aliquid cum doloremque. Sit tempore praesentium esse eaque nesciunt ipsum sed accusamus unde rem, tenetur, dolores pariatur.',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);

        // Post::create([
        //     'title' => 'Judul Ke Tiga',
        //     'slug' => 'judul-ke-tiga',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex ullam tempore delectus beatae similique amet eligendi at perferendis, quidem, quod est consequatur! Temporibus perferendis et doloribus illum minima cumque velit. Quibusdam nemo doloribus aut minus sunt aliquam excepturi ut, dignissimos cumque adipisci unde fugit at quis quia rerum quaerat sit ullam provident accusantium expedita ratione? Vero, maiores? Optio similique autem quas vitae accusantium totam consectetur possimus veritatis ducimus labore molestiae voluptatibus, aliquid cum doloremque. Sit tempore praesentium esse eaque nesciunt ipsum sed accusamus unde rem, tenetur, dolores pariatur.',
        //     'category_id' => 2,
        //     'user_id' => 1
        // ]);

        // Post::create([
        //     'title' => 'Judul Ke Empat',
        //     'slug' => 'judul-ke-empat',
        //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius maiores quam tenetur rerum nihil corporis quisquam odio in, laudantium rem ex ullam tempore delectus beatae similique amet eligendi at perferendis, quidem, quod est consequatur! Temporibus perferendis et doloribus illum minima cumque velit. Quibusdam nemo doloribus aut minus sunt aliquam excepturi ut, dignissimos cumque adipisci unde fugit at quis quia rerum quaerat sit ullam provident accusantium expedita ratione? Vero, maiores? Optio similique autem quas vitae accusantium totam consectetur possimus veritatis ducimus labore molestiae voluptatibus, aliquid cum doloremque. Sit tempore praesentium esse eaque nesciunt ipsum sed accusamus unde rem, tenetur, dolores pariatur.',
        //     'category_id' => 2,
        //     'user_id' => 2
        // ]);

    }
}
