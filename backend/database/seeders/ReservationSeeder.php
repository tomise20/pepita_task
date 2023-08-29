<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data1 = new Reservation();
        $data1->name = 'test 1';
        $data1->start_date = '2023-09-08';
        $data1->start_time = '8:00';
        $data1->end_time = '10:00';
        $data1->repeate = 'NEVER';
        $data1->save();

        $data2 = new Reservation();
        $data2->name = 'test 2';
        $data2->start_date = '2023-01-01';
        $data2->start_time = '10:00';
        $data2->end_time = '12:00';
        $data2->repeate = 'EVENWEEKS';
        $data2->repeate_day = 'MONDAY';
        $data2->save();

        $data3 = new Reservation();
        $data3->name = 'test 3';
        $data3->start_date = '2023-01-01';
        $data3->start_time = '8:00';
        $data3->end_time = '10:00';
        $data3->repeate = 'ODDWEEKS';
        $data3->repeate_day = 'WEDNESDAY';
        $data3->save();

        $data4 = new Reservation();
        $data4->name = 'test 4';
        $data4->start_date = '2023-01-01';
        $data4->start_time = '10:00';
        $data4->end_time = '16:00';
        $data4->repeate = 'EVERYWEEK';
        $data4->repeate_day = 'FRIDAY';
        $data4->save();

        $data5 = new Reservation();
        $data5->name = 'test 5';
        $data5->start_date = '2023-06-01';
        $data5->end_date = '2023-11-30';
        $data5->start_time = '16:00';
        $data5->end_time = '20:00';
        $data5->repeate = 'EVERYWEEK';
        $data5->repeate_day = 'THURSDAY';
        $data5->save();
    }
}
