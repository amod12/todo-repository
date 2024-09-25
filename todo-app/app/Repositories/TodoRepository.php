<?php
namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Support\Str;

class TodoRepository implements TodoRepositoryInterface
{
    public function getAll()
    {
        return Todo::where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
    }

    public function getById($id)
    {
        return Todo::where('user_id', auth()->id())->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        return Todo::create($data);
    }

    public function update($id, array $data)
    {
        $todoId = $id;
        $numericId = Str::replace('todo-', '', $todoId);

        $todo = $this->getById($numericId);
        $todo->update($data);
        return $todo;
    }

    public function delete($id)
    {
        $todo = $this->getById($id);
        $todo->delete();
    }

    public function updateStatus($id, bool $status)
    {
        $todo = $this->getById($id);
        $todo->status = $status; // Change 'completed' based on your original field
        $todo->save();
        return $todo;
    }

}
