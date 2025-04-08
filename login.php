<?php 
session_start();

include 'connection.php';
if(isset($_POST['btn_login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "select * from users where email = '$email' and password = '$password' ";
    $response = mysqli_query($con,$query);
    if(mysqli_num_rows($response) > 0 )
    { 
        $user =  mysqli_fetch_assoc($response);
        $_SESSION['username'] = $user['username'];
        $_SESSION['useremail'] = $user['email'];
        $_SESSION['password'] = $user['password'];

        echo 
        "<script>
       alert('login sucessfull');
        window.location.href= 'dashboard.php';
     </script>";
   

    }
    else{
        echo "<script>
        window.location.href= '';
       alert('cannot login');
       </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-card {
            max-width: 400px;
            margin: 50px auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .hidden {
            display: none;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">AuthSystem</a>
            <div id="auth-buttons">
                <button class="btn btn-light me-2" onclick="showForm('login')">Login</button>
                <button class="btn btn-outline-light" onclick="showForm('register')">Register</button>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="card auth-card" id="login-form">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Login</h4>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="your@email.com" required>
                </div>
                <div class="mb-3 position-relative">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="login-password" required>
                    <span class="password-toggle" onclick="togglePassword('login-password')">👁️</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="forgot_password.php" onclick="showForm('forgot')">Forgot password?</a>
                </div>
                <button name="btn_login" type="submit" class="btn btn-primary w-100">Login</button>
                <div class="text-center mt-3">
                    Don't have an account? <a href="#" onclick="showForm('register')">Register</a>
                </div>
            </form>
        </div>
    </div>

   
   
   
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle between forms
        function showForm(formName) {
            document.querySelectorAll('.auth-card, #dashboard').forEach(el => {
                el.classList.add('hidden');
            });
            document.getElementById(formName + '-form').classList.remove('hidden');
            
            // Hide auth buttons in nav when showing dashboard
            if(formName === 'dashboard') {
                document.getElementById('auth-buttons').classList.add('hidden');
            } else {
                document.getElementById('auth-buttons').classList.remove('hidden');
            }
        }

        // Simulate login (for UI demo only)
        function login() {
            showForm('dashboard');
        }

        // Simulate logout
        function logout() {
            showForm('login');
        }

      

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }


        // Initialize - show login form first
        showForm('login');
    </script>
</body>
</html>