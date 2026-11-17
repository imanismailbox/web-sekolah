<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PkkmYear;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PkkmYearPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PkkmYear');
    }

    public function view(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('View:PkkmYear');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PkkmYear');
    }

    public function update(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('Update:PkkmYear');
    }

    public function delete(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('Delete:PkkmYear');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PkkmYear');
    }

    public function restore(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('Restore:PkkmYear');
    }

    public function forceDelete(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('ForceDelete:PkkmYear');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PkkmYear');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PkkmYear');
    }

    public function replicate(AuthUser $authUser, PkkmYear $pkkmYear): bool
    {
        return $authUser->can('Replicate:PkkmYear');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PkkmYear');
    }
}
