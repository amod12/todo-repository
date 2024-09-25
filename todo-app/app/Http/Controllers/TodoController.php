<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\TodoRepositoryInterface;

class TodoController extends Controller
{
    protected $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index()
    {
        $todos = $this->todoRepository->getAll();
        $completedCount = $todos->where('status', 1)->count();
        $totalCount = $todos->count();
        return view('todos.index', compact('todos', 'completedCount', 'totalCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $this->todoRepository->create($data);
        return redirect()->back()->with('success', 'Todo created!');
    }

    public function edit(Request $request, $id)
    {
        // $todo = $this->todoRepository->getById($id);
        // return view('todos.edit', compact('todo'));
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $this->todoRepository->update($id, $data);
        return redirect()->back()->with('success', 'Todo edited!');

    }

// policies
public function update(Request $request, $id)
{
    $todoId = $id;
    $numericId = Str::replace('todo-', '', $todoId);

    $todo = Todo::findOrFail($numericId);

    // Authorize the action using the policy
    $this->authorize('update', $todo);

    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $todo->title = $request->title;
    $todo->save();

    return response()->json(['success' => true]);
}

public function destroy($id)
{
    $todo = Todo::findOrFail($id);

    // Authorize the action using the policy
    $this->authorize('delete', $todo);

    $todo->delete();

    return response()->json(['success' => true]);
}


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
    
        $this->todoRepository->updateStatus($id, $request->status);
    
        return response()->json(['success' => true]);
    }

}
