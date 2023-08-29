<?php

namespace Tests\Feature;

use Database\Seeders\ClientTimeSeeder;
use Database\Seeders\ReservationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_end_time_is_greater_then_start(): void
    {
        $response = $this->post('/api/reservations', [
            'name' => 'test jhone',
            'startDate' => '2023-09-01',
            'startTime' => '10:00',
            'endTime' => '08:00',
            'repeate' => 'NEVER'
        ]);

        $response->assertJsonValidationErrorFor('endTime');
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function test_revervation_is_out_of_client_time(): void
    {
        $this->seed();

        $response = $this->post('/api/reservations', [
            'name' => 'test jhone',
            'startDate' => '2023-09-01',
            'startTime' => '06:00',
            'endTime' => '12:00',
            'repeate' => 'NEVER'
        ]);

        $response->assertExactJson(['errors' => 'A megadott időpont nem ügyfélfogadási időben van!', 'isSuccess' => false]);
    }

    public function test_the_date_is_reserved(): void
    {
        $this->seed();

        $response = $this->post('/api/reservations', [
            'name' => 'test jhone',
            'startDate' => '2023-08-02',
            'startTime' => '09:00',
            'endTime' => '10:00',
            'repeate' => 'NEVER'
        ]);

        $response->assertExactJson(['errors' => 'A megadott időpontra már van foglalás!', 'isSuccess' => false]);
        $response->assertStatus(400);
    }

    public function test_success_reservation(): void
    {
        $this->seed();

        $response = $this->post('/api/reservations', [
            'name' => 'success jhone',
            'startDate' => '2023-08-05',
            'startTime' => '09:00',
            'endTime' => '10:00',
            'repeate' => 'NEVER'
        ]);

        $response->assertExactJson(['body' => 'Az időpont sikeresen lefoglalva!', 'isSuccess' => true]);
        $response->assertStatus(200);
    }
}
