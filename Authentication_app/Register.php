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
            <a class="btn btn-light me-2" href="login.php">Login</a>
                <a class="btn btn-outline-light" href="Register.php">Register</a>
             </div>
        </div>
    </nav>

  
    <!-- Registration Form -->
    <div class="card auth-card" id="register-form">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Register</h4>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input name="username" type="text" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="your@email.com" required>
                </div>
                <div class="mb-3 position-relative">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="reg-password" required>
                    <span class="password-toggle" onclick="togglePassword('reg-password')">👁️</span>
                    <div class="form-text">At least 8 characters with numbers</div>
                </div>
                <div class="mb-3 position-relative">
                    <label class="form-label">Confirm Password</label>
                    <input name="confirm_password" type="password" class="form-control" id="reg-confirm" required>
                    <span class="password-toggle" onclick="togglePassword('reg-confirm')">👁️</span>
                </div>
                <button type="submit" name="register_btn" class="btn btn-primary w-100">Register</button>
                <div class="text-center mt-3">
                    Already have an account? <a href="login.php" onclick="showForm('login')">Login</a>
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
        // function login() {
        //     showForm('dashboard');
        // }

        // // Simulate logout
        // function logout() {
        //     showForm('login');
        // }

        // Show dashboard (for demo purposes)
        // function showDashboard() {
        //     showForm('dashboard');
        // }

        // Toggle password visibility
        // function togglePassword(inputId) {
        //     const input = document.getElementById(inputId);
        //     input.type = input.type === 'password' ? 'text' : 'password';
        // }

        // Demo: Make login button work
        // document.querySelector('#login-form form').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     login();
        // });

        // Initialize - show login form first
        showForm('register');
    </script>
</body>
</html>
<?php 
include 'connection.php';

if(isset($_POST['register_btn']))
{
 $name = $_POST['username'];
 $email = $_POST['email'];
 $check_email_query =  "select * from users where email = '$email'";
 $email_response = mysqli_query($con,$check_email_query);
 $password = $_POST['password'];
 $confirm_password = $_POST['confirm_password'];
  if(mysqli_num_rows($email_response) > 0){
    echo "<script> alert('This email already exits please try different email!');
    window.location.href= 'Register.php';
    </script>";
    exit();
  }
  else{
    if($password !== $confirm_password)
    {
       echo "<script> alert('check your password and try again!')
         window.location.href= 'Register.php'
       </script>";
       exit();
    }
    else{
        $query = "insert into users(username,email,password) values('$name','$email','$password') ";
        $response = mysqli_query($con,$query);
        echo "<script> alert('Registered succesfully');
        window.location.href= 'login.php'
        </script>";
    }
  }
 

}
?>