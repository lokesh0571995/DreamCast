<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'             => 'Admin',
            'email'            => 'admin@gmail.com',
            'password'         => bcrypt('123456'),
            'phone'            => '7891565093',
            'role_id'          => '0',
            'created_at'       =>Carbon::now(),
            'updated_at'       =>Carbon::now()
        ]);
    }
}