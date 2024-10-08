<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Todo App</title>
    <style>
        /* Existing CSS styles remain unchanged */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 0.5rem;
            color: #555;
        }
        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        button {
            padding: 0.75rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            opacity: 0.5; /* Initially disabled */
            pointer-events: none; /* Prevent click */
        }
        button.enabled {
            opacity: 1; /* Fully visible when enabled */
            pointer-events: auto; /* Allow click */
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function checkPasswordMatch() {
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const submitButton = document.querySelector('button[type="submit"]');
            const errorMessage = document.getElementById('error-message');

            if (newPassword === confirmPassword && newPassword.length > 0) {
                submitButton.classList.add('enabled');
                errorMessage.textContent = ''; // Clear any previous error messages
            } else {
                submitButton.classList.remove('enabled');
                errorMessage.textContent = 'Passwords do not match.'; // Set error message
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <h3>Code has been sent to your email pls check</h3>
        <form action="{{ route('password.change') }}" method="POST">
            @csrf
            <label for="email">Code</label>
            <input type="number" id="code" name="code" required autocomplete="code">
            @if (session('error'))
                <div class="alert alert-danger" style="color: white; background-color: red; padding: 10px; border-radius: 5px;">
                    {{ session('error') }}
                </div>
            @endif          
            @if (session('success'))
                <div class="alert alert-success" style="color: white; background-color: green; padding: 10px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif           
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" required autocomplete="new-password" oninput="checkPasswordMatch()">
            
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required autocomplete="new-password" oninput="checkPasswordMatch()">
            
            <div class="error-message" id="error-message"></div> <!-- Error message container -->
            
            <button type="submit">Reset Password</button>
        </form>
        <div class="login-link">
            Remember your password? <a href="/login">Login here</a>
        </div>
    </div>
</body>
</html>
