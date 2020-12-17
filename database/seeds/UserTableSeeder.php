<?php

use Illuminate\Database\Seeder; 
use App\Model\Todo;
use App\Model\User;

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
            //create profile
            $user->todo()->save(factory(Todo::class)->make([
                "title" => "Get a new role before Dec 2021",
                "description" => "Apply for role to develop my existing skills and improved more on it"
            ]));
        });
    }
}
