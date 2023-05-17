<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Str;

class SampleData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Создание пачки категорий
        DB::table('categories')->insert(['title' => 'Базы данных']);
        DB::table('categories')->insert(['title' => 'Сети']);
        DB::table('categories')->insert(['title' => 'Программирование']);

        #Создание пачки пользователей
        DB::table('users')->insert([
            'login' =>  \Illuminate\Support\Str::random(10),
            'firstname' => \Illuminate\Support\Str::random(10),
            'lastname' =>  \Illuminate\Support\Str::random(10),
            'email' => \Illuminate\Support\Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '+1 234 567 89 10'
        ]);
        DB::table('users')->insert([
            'login' =>  \Illuminate\Support\Str::random(10),
            'firstname' => \Illuminate\Support\Str::random(10),
            'lastname' =>  \Illuminate\Support\Str::random(10),
            'email' => \Illuminate\Support\Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '+1 234 567 89 11'
        ]);
        DB::table('users')->insert([
            'login' =>  "Admin",
            'firstname' => "Никита",
            'lastname' =>  "Илларионов",
            'email' => \Illuminate\Support\Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '+1 234 567 89 12'
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

//        Product::factory(55)->create();
        #Создание объявлений-заглушек
//        DB::table('products')->insert([
//           'title' => 'Заглушка первая',
//           'description' => "Описательная заглушка",
//           'short_description' => "Короткая заглушка",
//           'price' => 99.99,
//           'user_id' => 1,
//           'category_id' => 1
//        ]);
//        DB::table('products')->insert([
//            'title' => 'Заглушка вторая',
//            'short_description' => "Кратко",
//            'description' => "Еще короткая заглушка",
//            'price' => 66.66,
//            'user_id' => 2,
//            'category_id' => 2
//        ]);
    }
}
