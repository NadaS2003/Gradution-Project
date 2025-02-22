<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class FirstAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     User::query()->create($this->adminData());
    }
    private function adminData(){
        return [
            'name'=>'admin.blade.php',
            'email'=>'admin.blade.php@gmail.com',
            'password'=>Hash::make('adminadmin'),
            'role'=>'admin.blade.php'
        ];
    }
}
