<?php

namespace Database\Seeders;

use App\Models\ClientTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTimeSeeder extends Seeder
{
    const DAYS = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < count(self::DAYS); $i++) { 
            $day = new ClientTime();
            $day->day = self::DAYS[$i];
            $day->start_time = '8:00';
            $day->end_time = '22:00';
            $day->save();
        }
    }
}
