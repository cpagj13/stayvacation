<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingUploadTest extends TestCase
{
    use RefreshDatabase;
    public function test_png_upload_with_unknown_mime_type_is_accepted(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->withSession([
            'booking.step1' => [
                'guest_name' => 'Jane Doe',
                'check_in' => '2026-08-01',
                'check_out' => '2026-08-03',
                'room_id' => 1,
            ],
        ]);

        $file = UploadedFile::fake()->create('payment.png', 100, 'application/octet-stream');

        $response = $this->post(route('booking.step2.store'), [
            'proof' => $file,
        ]);

        $response->assertRedirect(route('booking.step3'));
        $response->assertSessionHasNoErrors();
    }

    public function test_proof_file_can_be_served_via_proof_route(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');
        Storage::disk('public')->put('proofs/test-proof.png', 'fake-image-content');

        $this->actingAs($user);

        $response = $this->get(route('booking.proof', ['path' => 'proofs/test-proof.png']));

        $response->assertOk();
        $response->assertHeader('content-disposition', 'inline; filename="test-proof.png"');
    }

    public function test_booking_step_view_marks_booked_dates_in_the_picker(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('booking.step1'));

        $response->assertOk();
        $response->assertSee('is-pending-booking');
    }

    public function test_booking_with_overlapping_dates_is_rejected(): void
    {
        $user = User::factory()->create();
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'standard',
            'price' => 1000,
            'capacity' => 2,
            'description' => 'Test room',
        ]);

        Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'guest_name' => 'Existing Guest',
            'guests' => 2,
            'check_in' => '2026-07-15',
            'check_out' => '2026-07-16',
            'rooms_count' => 1,
            'total_price' => 1000,
            'proof_path' => 'proofs/test.png',
            'status' => 'confirmed',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('booking.step1.store'), [
            'guest_name' => 'New Guest',
            'check_in' => '2026-07-15',
            'check_out' => '2026-07-16',
            'room_id' => $room->id,
            'guests' => 1,
            'rooms_count' => 1,
            'payment_method' => 'gcash',
        ]);

        $response->assertSessionHasErrors('check_in');
    }
}
