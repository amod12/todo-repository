<?php
namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the todo.
     */
    public function update(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id; 
    }

    /**
     * Determine whether the user can delete the todo.
     */
    public function delete(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }
}
