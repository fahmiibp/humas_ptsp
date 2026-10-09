<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KontenMedsos;
use Illuminate\Auth\Access\HandlesAuthorization;

class KontenMedsosPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KontenMedsos');
    }

    public function view(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('View:KontenMedsos');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KontenMedsos');
    }

    public function update(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('Update:KontenMedsos');
    }

    public function delete(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('Delete:KontenMedsos');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KontenMedsos');
    }

    public function restore(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('Restore:KontenMedsos');
    }

    public function forceDelete(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('ForceDelete:KontenMedsos');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KontenMedsos');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KontenMedsos');
    }

    public function replicate(AuthUser $authUser, KontenMedsos $kontenMedsos): bool
    {
        return $authUser->can('Replicate:KontenMedsos');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KontenMedsos');
    }

}