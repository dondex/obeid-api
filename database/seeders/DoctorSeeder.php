<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample doctors
        $doctors = [
            ['name' => 'Dr. John Smith', 'department_id' => 1, 'doctor_image' => 'john_smith.jpg', 'available_time_slot' => 'Mon-Fri 9am-5pm'],
            ['name' => 'Dr. Jane Doe', 'department_id' => 2, 'doctor_image' => 'jane_doe.jpg', 'available_time_slot' => 'Mon-Fri 10am-4pm'],
            ['name' => 'Dr. Emily Johnson', 'department_id' => 3, 'doctor_image' => 'emily_johnson.jpg', 'available_time_slot' => 'Mon-Fri 8am-3pm'],
            ['name' => 'Dr. Michael Brown', 'department_id' => 4, 'doctor_image' => 'michael_brown.jpg', 'available_time_slot' => 'Mon-Fri 11am-6pm'],
            ['name' => 'Dr. Sarah Davis', 'department_id' => 5, 'doctor_image' => 'sarah_davis.jpg', 'available_time_slot' => 'Mon-Fri 9am-5pm'],
            ['name' => 'Dr. David Wilson', 'department_id' => 6, 'doctor_image' => 'david_wilson.jpg', 'available_time_slot' => 'Mon-Fri 10am-4pm'],
            ['name' => 'Dr. Laura Martinez', 'department_id' => 7, 'doctor_image' => 'laura_martinez.jpg', 'available_time_slot' => 'Mon-Fri 8am-3pm'],
            ['name' => 'Dr. James Taylor', 'department_id' => 8, 'doctor_image' => 'james_taylor.jpg', 'available_time_slot' => 'Mon-Fri 11am-6pm'],
            ['name' => 'Dr. Patricia Anderson', 'department_id' => 9, 'doctor_image' => 'patricia_anderson.jpg', 'available_time_slot' => 'Mon-Fri 9am-5pm'],
            ['name' => 'Dr. Robert Thomas', 'department_id' => 10, 'doctor_image' => 'robert_thomas.jpg', 'available_time_slot' => 'Mon-Fri 10am-4pm'],
            ['name' => 'Dr. Jennifer Jackson', 'department_id' => 11, 'doctor_image' => 'jennifer_jackson.jpg', 'available_time_slot' => 'Mon-Fri 8am-3pm'],
            ['name' => 'Dr. Charles White', 'department_id' => 12, 'doctor_image' => 'charles_white.jpg', 'available_time_slot' => 'Mon-Fri 11am-6pm'],
            ['name' => 'Dr. Elizabeth Harris', 'department_id' => 13, 'doctor_image' => 'elizabeth_harris.jpg', 'available_time_slot' => 'Mon-Fri 9am-5pm'],
            ['name' => 'Dr. Daniel Clark', 'department_id' => 14, 'doctor_image' => 'daniel_clark.jpg', 'available_time_slot' => 'Mon-Fri 10am-4pm'],
            ['name' => 'Dr. Nancy Lewis', 'department_id' => 15, 'doctor_image' => 'nancy_lewis.jpg', 'available_time_slot' => 'Mon-Fri 8am-3pm'],
            ['name' => 'Dr. Matthew Robinson', 'department_id' => 16, 'doctor_image' => 'matthew_robinson.jpg', 'available_time_slot' => 'Mon-Fri 11am-6pm'],
            ['name' => 'Dr. Angela Walker', 'department_id' => 17, 'doctor_image' => 'angela_walker.jpg', 'available_time_slot' => 'Mon-Fri 9am-5pm'],
            ['name' => 'Dr. Joshua Hall', 'department_id' => 18, 'doctor_image' => 'joshua_hall.jpg', 'available_time_slot' => 'Mon-Fri 10am-4pm'],
            ['name' => 'Dr. Sophia Allen', 'department_id' => 19, 'doctor_image' => 'sophia_allen.jpg', 'available_time_slot' => 'Mon-Fri 8am-3pm'],
            ['name' => 'Dr. Christopher Young', 'department_id' => 20, 'doctor_image' => 'christopher_young.jpg', 'available_time_slot' => 'Mon-Fri 11am-6pm'],
        ];

        // Insert doctors into the database
        Doctor::insert($doctors);
    }
}