<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'User',
            'created_at'       =>Carbon::now(),
            'updated_at'       =>Carbon::now()
            
        ]);

        Role::create([
            'name' => 'Employee',
            'created_at'       =>Carbon::now(),
            'updated_at'       =>Carbon::now()
           
        ]);

        Role::create([
            'name' => 'Admin Staff',
            'created_at'       =>Carbon::now(),
            'updated_at'       =>Carbon::now()
           
        ]);
    }
}
