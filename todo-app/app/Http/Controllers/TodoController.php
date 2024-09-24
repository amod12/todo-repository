<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepositoryInterface;
use Illuminate\Http\Request;

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
        return view('todos.index', compact('todos'));
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $this->todoRepository->update($id, $data);
        return redirect()->back()->with('success', 'Todo updated!');
    }

    public function destroy($id)
    {
        $this->todoRepository->delete($id);
        return redirect()->back()->with('success', 'Todo deleted!');
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
