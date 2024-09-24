<h1>Edit Todo</h1>
<form action="{{ route('todos.update', $todo->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $todo->title }}">
    <input type="checkbox" name="completed" {{ $todo->completed ? 'checked' : '' }}> Completed
    <button type="submit">Update</button>
</form>
