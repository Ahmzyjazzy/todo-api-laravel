<?php

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create()->each(function ($user) {
            //create todo
            $title = "Get a new role before Dec 2021";
            $slug = Str::slug($title, '_');

            $user->todos()->save(factory(Todo::class)->make([
                "title" => $title,
                "description" => "Apply for role to develop my existing skills and improved more on it",
                "slug" => $slug,
            ]));
        });
    }
}
