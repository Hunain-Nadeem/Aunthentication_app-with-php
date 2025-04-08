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
    

    <!-- Forgot Password Form -->
    <div class="card auth-card" id="forgot-form">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Reset Password</h4> 
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="your@email.com" required>
                </div>
                <button name="btn_reset" type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                <div class="text-center mt-3">
                    Remembered your password? <a href="login.php" onclick="showForm('login')">Login</a>
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

        // Show dashboard (for demo purposes)
        function showDashboard() {
            showForm('dashboard');
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Demo: Make login button work
        document.querySelector('#login-form form').addEventListener('submit', function(e) {
            e.preventDefault();
            login();
        });

        // Initialize - show login form first
        showForm('login');
    </script>
</body>
</html>
<?php 
include "connection.php";
if(isset($_POST['btn_reset']))
{
    $email = $_POST['email'];
    $check_mail = "select * from users where email = '$email'; ";
    $response = mysqli_query($con,$check_mail);
    if(mysqli_num_rows($response) < 0 ){
       
    }
    else{
        echo "<script> alert('please enter a valid email Address!! ') </script>";
    }
    }


?>