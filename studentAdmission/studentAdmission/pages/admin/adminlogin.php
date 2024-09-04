<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Login Page</title>
    <!-- <link rel="stylesheet" href="../css/Login.css" /> -->
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* top navigation */
.topnav {
    background-color: #0b0544;
    overflow: hidden;
}

.topnav a {
    margin-top: 20px;
    margin-left: 250px;
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* add styles for user profile and logout button */
.topnav .user-profile {
    float: right;
    margin-right: 10px;
    margin-left: 10px;
}

.topnav .logout {
    float: right;
    margin-right: 5px;
    /* reduced from 20px */
}

.topnav .user-profile,
.topnav .logout {
    color: #f2f2f2;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
}

.topnav .user-profile:hover,
.topnav .logout:hover {
    background-color: #ddd;
    color: black;
}

/* side navigation */
.sidenav {
    margin-top: 30px;
    height: 100%;
    width: 250px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #0b0544;
    ;
    overflow-x: hidden;
    padding-top: 20px;
}

.sidenav a {
    margin-top: 30px;
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 20px;
    color: #f2f2f2;
    display: block;
}

.sidenav a:hover {
    background-color: #ddd;
    color: black;
}

/* main content */
.main {
    margin-left: 255px;   
    padding: 40px;
}
        body {
            background-color: #0b0544;
            font-family: Arial, sans-serif;
        }

        .login-box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin: 100px auto;
            padding: 20px;
            max-width: 600px;
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #0b0544;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            max-width: 60px;
        }

        input[type="submit"]:hover {

            background-color: #925a1b;
        }
    </style>
    <script>
        // Check if there's a success message in the URL and display it as a JavaScript alert
        <?php if (isset($_GET['success_message'])) : ?>
            var success_message = "<?php echo $_GET['success_message']; ?>";
            alert(success_message);
        <?php endif; ?>
    </script>
    <script>
        <?php if (isset($_GET['error_message'])) : ?>
            var success_message = "<?php echo $_GET['error_message']; ?>";
            alert(success_message);
        <?php endif; ?>
        <?php if (isset($_GET['success_message'])) : ?>
            var success_message = "<?php echo $_GET['success_message']; ?>";
            alert(success_message);
        <?php endif; ?>
    </script>
</head>

<body>
    <?php
    session_start();
    include('../../php/conn.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get input values
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if user exists
        $query = "SELECT * FROM staff WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // session_start();
                $_SESSION['user'] = $user['staff_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['first_name'];
                $_SESSION['role'] = $user['role'];
                $success_message = "Successful login";
                $user = $_SESSION['user'];
                $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Admin login','$user',CURDATE(), CURTIME(),'login','staff','admin')";
                mysqli_query($conn, $sqllogs);
                header('Location: ./admin.php?success_message=" . urlencode($success_message)');
                echo $_SESSION['role'];
                exit();
            } else {
                // $error_message = 'Invalid email or password';
                header("Location: ./adminlogin.php?error_message=" . urlencode("Invalid password"));
            }
        } else {
            // $error_message = 'Invalid emai';
            header("Location: ./adminlogin.php?error_message=" . urlencode("Invalid email "));
        }

        mysqli_close($conn);
    }
    ?>


    </div>

    <div class="login-box">
        <h1>CUEA Online Admission</h1>
        <div style="text-align: center">
            <img src="../../imgs/logo.png" style="display: block; margin: 0 auto" />
        </div>
        <h1>Admin Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateForm();" method="POST">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" />
            <span id="emailError" class="error"></span><br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" />
            <span id="usernameError" class="error"></span><br />
            <input type="submit" name="submit" value="submit" />
            <p>Student login <a href="../../pages/login.php">Student Login</a></p>
            <p>Create Account <a href="../admin/createUser.php">Register</a></p>
            <!-- <p>Forgot password <a href="../pages/resetpass.php">Reset</a></p> -->
        </form>
    </div>
    <!-- validation javascript -->
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email == "") {
                alert("Please enter your email");
                return false;
            }
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            if (password == "") {
                alert("Please enter a password.");
                return false;
            }
        }
    </script>
</body>

</html>