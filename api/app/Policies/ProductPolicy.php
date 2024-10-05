<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {

        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): Response
    {
        return access($user, 'view user')
            ? Response::allow()
            : Response::deny(__('You do not have permission to view this :resource.', [
                'resource' => __('Product')
            ]));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return access($user, 'create user')
            ? Response::allow()
            : Response::deny(__('You do not have permission to create a :resource.', [
                'resource' => __('Product')
            ]));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): Response
    {
        return access($user, 'update user')
            ? Response::allow()
            : Response::deny(__('You do not have permission to update this :resource.', [
                'resource' => __('Product')
            ]));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): Response
    {
        return access($user, 'delete user')
            ? Response::allow()
            : Response::deny(__('You do not have permission to delete this :resource.', [
                'resource' => __('Product')
            ]));
    }
}
