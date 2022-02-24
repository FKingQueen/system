<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Patrick Borja',
            'muni_address'=>'Currimao',
            'role_id'=>'1',
            'email'=>'p@gmail.com',
            'password'=>Hash::make('12345')
        ]); 

        User::create([
            'name'=>'Hisiah Nidoy',
            'muni_address'=>'Batac',
            'role_id'=>'2',
            'email'=>'h@gmail.com',
            'password'=>Hash::make('12345')
        ]); 

    }
}
