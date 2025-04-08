    <?php 
    session_start();
    include "connection.php";
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

        <?php

    if (isset($_SESSION['useremail']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
        $email = $_SESSION['useremail'];
        $username = $_SESSION['username'];
        $session_password = $_SESSION['password'];
       
        ?>

        <div class="container mt-5" id="dashboard">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Welcome, <span id="username-display"><?php echo $username ?></span>!</h5>
                    <form method="post">
                        <button class="btn btn-sm btn-outline-danger" name="logout">Logout</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        You're now logged in. This is a protected dashboard.
                    </div>
                    <div class="border p-3 rounded">
                        <h6>User Information</h6>
                        <p>Your email is: <strong><?php echo $email ; ?></strong></p>
                        <p>your password is <?php echo $session_password ;?> </p>
                        <p>Role: Member</p>
                        <button class="btn btn-sm btn-warning" onclick="showForm('change-password')">Change Password</button>
                    </div>
                </div>
            </div>
        </div>


    <!-- Change Password Form -->
    <div class="card auth-card hidden" id="change-password-form">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Change Password</h4>
                <form method="post">
                    <div class="mb-3 position-relative">
                        <label class="form-label">Current Password</label>
                        <input name="current_pass" type="password" class="form-control" id="current-password" required>
                        <span class="password-toggle" onclick="togglePassword('current-password')">👁️</span>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">New Password</label>
                        <input name="new_pass" type="password" class="form-control" id="new-password" required>
                        <span class="password-toggle" onclick="togglePassword('new-password')">👁️</span>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Confirm New Password</label>
                        <input name="confirm_new_pass" type="password" class="form-control" id="confirm-new-password" required>
                        <span class="password-toggle" onclick="togglePassword('confirm-new-password')">👁️</span>
                    </div>
                    <button name="update_pass" type="submit" class="btn btn-primary w-100">Update Password</button>
                    <button type="button" class="btn btn-outline-secondary w-100 mt-2" onclick="showDashboard()">Cancel</button>
                </form>
            </div>
        </div>



    <?php

    if(isset($_POST['update_pass'])) {    
        $current_password = $_POST['current_pass'];
        $new_password = $_POST['new_pass'];
        $_check_password = $_POST['confirm_new_pass'];

        if($new_password != $_check_password) {
            echo "<script>alert('Please check the password again');</script>";
        } else {
            $query = "SELECT password FROM users WHERE email = '$email'";
            $response = mysqli_query($con, $query);

            if(mysqli_num_rows($response) > 0) {
                $row = mysqli_fetch_assoc($response);

                if($current_password == $row['password']) {
                    $update_query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
                    
                    if(mysqli_query($con, $update_query)) {
                        $_SESSION['password'] = $new_password;
                        echo "<script>alert('Password updated successfully');
                        window.location.href='';
                        </script>";
                    } else {
                        echo "<script>alert('Error updating password');</script>";
                    }
                } else {
                    echo "<script>alert('Your current password is incorrect');</script>";
                }
            }
        }
    }

    if(isset($_POST['logout']))
    {
        session_destroy();
        session_unset();
        echo "<script> window.location.href='login.php'; </script>";
    }

    }
     else{
            echo "<script>window.location.href = 'login.php';</script>";
            exit(); // Stop executing the rest of the script
        }
    ?>


    
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
