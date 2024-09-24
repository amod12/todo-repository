<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Todo List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 42rem;
            margin: 1rem;
        }
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        .card-content {
            padding: 1.5rem;
        }
        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        .input-group {
            display: flex;
            margin-bottom: 1rem;
        }
        .input {
            flex-grow: 1;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            margin-right: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
        }
        .btn-destructive {
            background-color: #ef4444;
            color: white;
        }
        .todo-list {
            list-style-type: none;
            padding: 0;
        }
        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            background-color: #f9fafb;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }
        .todo-item label {
            margin-left: 0.5rem;
        }
        .todo-item.completed label {
            text-decoration: line-through;
            color: #6b7280;
        }
        .icon {
            width: 1rem;
            height: 1rem;
        }
        .dialog {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .dialog-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 0.5rem;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Your Todo List</h1>

        </div>
        <div class="card-content">
            <div class="input-group">
                <input type="text" class="input" id="todo-title" placeholder="Add a new todo">
                <input type="hidden" class="input" id="todo-user_id" value="{{auth()->user()->id}}">
                <button class="btn btn-primary" id="add-todo-button">
                    <i class="fas fa-plus icon"></i> Add Todo
                </button>
            </div>
            
            <ul class="todo-list">
                @foreach($todos as $todo)
                    <li class="todo-item">
                        <div>
                            <input type="checkbox" id="todo-{{ $todo->id }}" 
                                   {{ $todo->status ? 'checked' : '' }} 
                                   onchange="updateStatus({{ $todo->id }}, this.checked)">
                            <label for="todo-{{ $todo->id }}">{{ $todo->title }}</label>
                        </div>
                        <div>
                            <button class="btn btn-outline" onclick="openDialog('todo-{{ $todo->id }}')">
                                <i class="fas fa-pencil-alt icon"></i>
                            </button>
                            <button class="btn btn-destructive" onclick="deleteTodo({{ $todo->id }})">
                                <i class="fas fa-trash icon"></i>
                            </button>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="card-footer">
            <p class="text-sm text-gray-500">1 of 3 tasks completed</p>
        </div>
    </div>
    <div id="editDialog" class="dialog">
        <div class="dialog-content">
            <span class="close" onclick="closeDialog()">&times;</span>
            <h2>Edit Todo</h2>
            <label for="edit-todo">Todo Title</label>
            <input type="text" id="edit-todo" class="input" style="width: 100%; margin-top: 10px;">
            <input type="hidden" id="edit-todo-id">  <!-- Hidden input to store the todoId -->
            <button class="btn btn-primary" style="margin-top: 10px;" onclick="editTodo()">Save changes</button>
        </div>
    </div>
    

    <script>
        function openDialog(todoId) {
    document.getElementById('editDialog').style.display = 'block';
    document.getElementById('edit-todo').value = document.querySelector(`label[for="${todoId}"]`).textContent;
    document.getElementById('edit-todo-id').value = todoId;  // Store the todoId in the hidden input
}


        function closeDialog() {
            document.getElementById('editDialog').style.display = 'none';
        }

        function editTodo() {
    var title = document.getElementById('edit-todo').value;
    var todoId = document.getElementById('edit-todo-id').value;  // Get the todoId

    // Now you can make your AJAX request to update the todo
    $.ajax({
        url: `/todos/${todoId}`,  // URL to update the Todo
        type: 'PUT',  // Use PUT method to update data
        data: {
            title: title,
            _token: '{{ csrf_token() }}'  // Include the CSRF token for security
        },
        success: function(response) {
            // Handle success, e.g., refresh the todo list or notify the user
            console.log('Todo updated successfully!');
            closeDialog();  // Close the dialog after saving
        },
        error: function(xhr) {
            // Handle errors
            console.error('Error updating todo:', xhr.responseText);
        }
    });
}



    </script>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#add-todo-button').click(function() {
            let title = $('#todo-title').val();
            let user_id = $('#todo-user_id').val();

            // Validate input before sending request
            if (title.trim() === '') {
                alert('Please enter a todo title.');
                return;
            }
            $.ajax({
                url: '/todos',
                type: 'POST',
                data: {
                    title: title,
                    user_id:user_id,
                    _token: '{{ csrf_token() }}'  
                },
                success: function(response) {                    
                    alert('Todo added: sucessfully');
                    $('#todo-title').val('');
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
    
    function updateStatus(todoId, isChecked) {
        $.ajax({
            url: `/todo/update-status/${todoId}`,
            type: 'POST',
            data: {
                status: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert('Status updated successfully.');
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + xhr.responseText);
            }
        });
    }

    function deleteTodo(todoId) {
        if (confirm('Are you sure you want to delete this todo?')) {
            $.ajax({
                url: `/todos/${todoId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                // success: function(response) {
                //     if (response.success) {
                //         alert('Todo deleted successfully!');
                //         // Remove the todo item from the DOM
                //         $(`#todo-${todoId}`).closest('.todo-item').remove();
                //     }
                // },
                // error: function(xhr, status, error) {
                //     alert('An error occurred: ' + error);
                // }
            });
        }
    }

</script>
