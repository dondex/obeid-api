<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\DoctorSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    

         // Call the DepartmentSeeder first
         $this->call(DepartmentSeeder::class);

         // Then call the DoctorSeeder
         $this->call(DoctorSeeder::class);
    }
}
