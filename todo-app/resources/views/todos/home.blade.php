<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Todo App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            margin-bottom: 2rem;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button-primary {
            background-color: #4CAF50;
            color: white;
        }
        .button-primary:hover {
            background-color: #45a049;
        }
        .button-secondary {
            background-color: #f1f1f1;
            color: #333;
        }
        .button-secondary:hover {
            background-color: #e7e7e7;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Todo App</h1>
        <p>Organize your tasks and boost your productivity with our simple and effective todo app.</p>
        <div class="button-container">
            <a href="/login" class="button button-primary">Login</a>
            <a href="/register" class="button button-secondary">Register</a>
        </div>
    </div>
</body>
</html>