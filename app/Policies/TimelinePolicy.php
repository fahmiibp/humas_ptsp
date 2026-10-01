<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Timeline;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimelinePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Timeline');
    }

    public function view(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('View:Timeline');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Timeline');
    }

    public function update(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('Update:Timeline');
    }

    public function delete(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('Delete:Timeline');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Timeline');
    }

    public function restore(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('Restore:Timeline');
    }

    public function forceDelete(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('ForceDelete:Timeline');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Timeline');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Timeline');
    }

    public function replicate(AuthUser $authUser, Timeline $timeline): bool
    {
        return $authUser->can('Replicate:Timeline');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Timeline');
    }

}