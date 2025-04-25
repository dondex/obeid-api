<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample departments
        $departments = [
            ['name' => 'Cardiology'],
            ['name' => 'Neurology'],
            ['name' => 'Pediatrics'],
            ['name' => 'Orthopedics'],
            ['name' => 'Dermatology'],
            ['name' => 'Gastroenterology'],
            ['name' => 'Oncology'],
            ['name' => 'Radiology'],
            ['name' => 'Psychiatry'],
            ['name' => 'Anesthesiology'],
            ['name' => 'Emergency Medicine'],
            ['name' => 'Internal Medicine'],
            ['name' => 'Family Medicine'],
            ['name' => 'Ophthalmology'],
            ['name' => 'ENT (Ear, Nose, Throat)'],
            ['name' => 'Urology'],
            ['name' => 'Endocrinology'],
            ['name' => 'Rheumatology'],
            ['name' => 'Infectious Diseases'],
            ['name' => 'Nephrology'],
            ['name' => 'Pulmonology'],
        ];

        // Insert departments into the database
        Department::insert($departments);
    }
}