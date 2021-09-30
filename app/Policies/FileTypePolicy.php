<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FileType;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fileType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list filetypes');
    }

    /**
     * Determine whether the fileType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function view(User $user, FileType $model)
    {
        return $user->hasPermissionTo('view filetypes');
    }

    /**
     * Determine whether the fileType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create filetypes');
    }

    /**
     * Determine whether the fileType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function update(User $user, FileType $model)
    {
        return $user->hasPermissionTo('update filetypes');
    }

    /**
     * Determine whether the fileType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function delete(User $user, FileType $model)
    {
        return $user->hasPermissionTo('delete filetypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete filetypes');
    }

    /**
     * Determine whether the fileType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function restore(User $user, FileType $model)
    {
        return false;
    }

    /**
     * Determine whether the fileType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FileType  $model
     * @return mixed
     */
    public function forceDelete(User $user, FileType $model)
    {
        return false;
    }
}
