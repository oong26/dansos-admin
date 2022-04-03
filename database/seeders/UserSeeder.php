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
        $newAdmin->name = 'Officer';
        $newAdmin->email = 'officer@mail.com';
        $newAdmin->password = \Hash::make('password');
        $newAdmin->role = 'Officer';
        $newAdmin->save();

        $newAdmin = new User;
        $newAdmin->name = 'Pimpinan';
        $newAdmin->email = 'pimpinan@mail.com';
        $newAdmin->password = \Hash::make('password');
        $newAdmin->role = 'Pimpinan';
        $newAdmin->save();
        
        $newAdmin = new User;
        $newAdmin->name = 'Dinas Provinsi';
        $newAdmin->email = 'provinsi@mail.com';
        $newAdmin->password = \Hash::make('password');
        $newAdmin->role = 'Dinas Provinsi';
        $newAdmin->save();
    }
}
