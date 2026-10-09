<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Warta;
use Illuminate\Auth\Access\HandlesAuthorization;

class WartaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Warta');
    }

    public function view(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('View:Warta');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Warta');
    }

    public function update(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('Update:Warta');
    }

    public function delete(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('Delete:Warta');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Warta');
    }

    public function restore(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('Restore:Warta');
    }

    public function forceDelete(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('ForceDelete:Warta');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Warta');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Warta');
    }

    public function replicate(AuthUser $authUser, Warta $warta): bool
    {
        return $authUser->can('Replicate:Warta');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Warta');
    }

}