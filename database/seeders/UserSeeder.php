<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newAdmin = new User;
        $newAdmin->name = 'Admin';
        $newAdmin->email = 'admin@mail.com';
        $newAdmin->password = \Hash::make('password');
        $newAdmin->save();
    }
}
