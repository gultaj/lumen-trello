<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call('UsersTableSeeder');

        factory(App\User::class, 5)->create();
        factory(App\User::class)->create(['name' => 'gultaj', 'email' => '1@tut.by']);

        Model::reguard();
    }
}
