<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Complaints\ComplaintResource;
use App\Filament\Resources\Complaints\Pages\ListComplaints;
use App\Filament\Resources\Complaints\Pages\ViewComplaint;
use App\Models\Complaint;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ComplaintResourceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($this->admin);
    }

    public function test_admin_can_list_and_filter_complaints_by_read_status(): void
    {
        $unread = Complaint::factory()->create(['name' => 'Pengirim Baru']);
        $read = Complaint::factory()->read()->create(['name' => 'Pengirim Lama']);

        Livewire::test(ListComplaints::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$unread, $read])
            ->filterTable('read_at', false)
            ->assertCanSeeTableRecords([$unread])
            ->assertCanNotSeeTableRecords([$read])
            ->filterTable('read_at', true)
            ->assertCanSeeTableRecords([$read])
            ->assertCanNotSeeTableRecords([$unread]);
    }

    public function test_viewing_complaint_marks_it_as_read_and_can_toggle_unread(): void
    {
        $complaint = Complaint::factory()->create();

        $this->assertFalse($complaint->isRead());

        Livewire::test(ViewComplaint::class, ['record' => $complaint->getRouteKey()])
            ->assertOk()
            ->callAction('toggleRead');

        $this->assertFalse($complaint->fresh()->isRead());

        Livewire::test(ViewComplaint::class, ['record' => $complaint->getRouteKey()])
            ->assertOk();

        $this->assertTrue($complaint->fresh()->isRead());
    }

    public function test_admin_can_toggle_read_status_and_delete_from_table(): void
    {
        $complaint = Complaint::factory()->create();

        Livewire::test(ListComplaints::class)
            ->callTableAction('toggleRead', $complaint);

        $this->assertTrue($complaint->fresh()->isRead());

        Livewire::test(ListComplaints::class)
            ->callTableAction(DeleteAction::class, $complaint);

        $this->assertModelMissing($complaint);
    }

    public function test_navigation_badge_reflects_unread_count(): void
    {
        $this->assertNull(ComplaintResource::getNavigationBadge());

        Complaint::factory()->count(2)->create();
        Complaint::factory()->read()->create();

        $this->assertSame('2', ComplaintResource::getNavigationBadge());
    }
}
