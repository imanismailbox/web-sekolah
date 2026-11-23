<?php

namespace Tests\Feature\Public;

use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_complaint_form_page_is_accessible(): void
    {
        $this->get(route('complaints.create'))
            ->assertOk()
            ->assertSee('Aduan &amp; Saran', false)
            ->assertSee('Email / No. HP')
            ->assertSee('Kirim Aduan');
    }

    public function test_visitor_can_submit_complaint_with_contact(): void
    {
        $response = $this->post(route('complaints.store'), [
            'name' => 'Ahmad Fauzi',
            'contact' => '081234567890',
            'message' => 'Mohon perbaikan penerangan di area parkir madrasah.',
        ]);

        $response
            ->assertRedirect(route('complaints.create'))
            ->assertSessionHas('status');

        $complaint = Complaint::query()->sole();

        $this->assertSame('Ahmad Fauzi', $complaint->name);
        $this->assertSame('081234567890', $complaint->contact);
        $this->assertSame('Mohon perbaikan penerangan di area parkir madrasah.', $complaint->message);
        $this->assertNull($complaint->read_at);
    }

    public function test_visitor_can_submit_complaint_without_optional_contact(): void
    {
        $this->post(route('complaints.store'), [
            'name' => 'Siti Aminah',
            'contact' => '',
            'message' => 'Pelayanan tata usaha sudah sangat ramah, terima kasih.',
        ])
            ->assertRedirect(route('complaints.create'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('complaints', [
            'name' => 'Siti Aminah',
            'contact' => null,
            'message' => 'Pelayanan tata usaha sudah sangat ramah, terima kasih.',
        ]);
    }

    public function test_complaint_submission_requires_name_and_message(): void
    {
        $this->from(route('complaints.create'))
            ->post(route('complaints.store'), [
                'name' => '',
                'contact' => 'user@example.com',
                'message' => '',
            ])
            ->assertRedirect(route('complaints.create'))
            ->assertSessionHasErrors(['name', 'message']);

        $this->assertDatabaseCount('complaints', 0);
    }

    public function test_complaint_submission_rejects_oversized_inputs(): void
    {
        $this->post(route('complaints.store'), [
            'name' => str_repeat('a', 151),
            'contact' => str_repeat('b', 151),
            'message' => str_repeat('c', 5001),
        ])->assertSessionHasErrors(['name', 'contact', 'message']);

        $this->assertDatabaseCount('complaints', 0);
    }

    public function test_complaint_page_is_included_in_sitemap(): void
    {
        $this->get(route('sitemap'))
            ->assertOk()
            ->assertSee(route('complaints.create'), false);
    }
}
