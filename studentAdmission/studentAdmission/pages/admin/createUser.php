<?php session_start();
include('../../php/conn.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <!-- <link rel="stylesheet" href="../css/Register.css"> -->
    <style>
        body {
            background-color: #0b0544;
            font-family: Arial, sans-serif;
        }

        .registration-box {
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
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid;
            margin-bottom: 20px;
        }

        /* // */

        input[type="submit"] {
            background-color: #0b0544;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        body {
            background-color: #0b0544;
            font-family: Arial, sans-serif;
        }

        .registration-box {
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
        input[type="email"],
        input[type="number"],
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
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>

</head>

<body>
    <?php

    if (isset($_POST['submit'])) {
        $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
        $middle_name = mysqli_real_escape_string($conn, $_POST['middleName']);
        $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $role = "web-user";

        if (empty($errors)) {
            // Check if the email address already exists in the database
            $email_check_sql = "SELECT * FROM staff WHERE email = '$email'";
            $result = mysqli_query($conn, $email_check_sql);
            if (mysqli_num_rows($result) > 0) {
                // Display an error message if the email address already exists
                $errors[] = "Email address already exists";
            } else {
                // Hash the password before storing it in the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Create a new record in the students table with the user's data
                $sql = "INSERT INTO staff (first_name, middle_name, last_name, email, password, role) VALUES ('$first_name', '$middle_name', '$last_name', '$email', '$hashed_password','$role')";
                if (mysqli_query($conn, $sql)) {
                    // Store the user's data in the session
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['middle_name'] = $middle_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    $staff = "SELECT staff_id FROM staff WHERE email ='$email'";
                    $staffID = mysqli_query($conn, $staff);
                    $staff_ID = mysqli_fetch_assoc($staffID);
                    $user = $staff_ID['staff_id'];
                    // Close the database connection
                    $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                    VALUES ('Add new staff user','$user',CURDATE(), CURTIME(),'add user','staff','admin')";
                    mysqli_query($conn, $sqllogs);
                    mysqli_close($conn);
                    // Redirect to the success page
                    $success_message = "You have successfully registered. Please login with your credentials.";
                    header("Location: ./adminlogin.php?success_message=" . urlencode($success_message));
                    exit();
                } else {
                    // Display an error message if the query fails
                    $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
    ?>
    <div class="registration-box">
        <h1>CUEA Online Admission</h1>
        <div style="text-align: center;">
            <img src="../../imgs/logo.png" style="display: block; margin: 0 auto;">
        </div>
        <!--   -->
        <h1>Staff Register</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateRegister();" method="POST">
            <label for="fname">First Name:</label>
            <input type="text" id="first_name" name="firstName">
            <label for="middleName">Middle Name:</label>
            <input type="text" id="middle_name" name="middleName">
            <label for="lastName">Last Name:</label>
            <input type="text" id="last_name" name="lastName">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
            <label for="phone">Phone:</label>
            <input type="number" id="phone" name="phone">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm-password">
            <input type="submit" name="submit" value="Register">
            <p>Already have an account <a href="./adminlogin.php">Login</a></p>
        </form>
    </div>
    <script>
        function validateRegister() {
            var firstName = document.getElementById("first_name").value;
            var lastName = document.getElementById("last_name").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (firstName == "") {
                alert("Please enter your first name");
                return false;
            }
            if (lastName == "") {
                alert("Last name cannot be blank");
                return false;
            }
            if (email == "") {
                alert("Please enter your email");
                return false;
            }
            if (phone == "") {
                alert("Please enter your phone number");
                return false;
            }
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (password == "") {
                alert("Please enter your password");
                return false;
            }
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            // Check if password has a number, an uppercase letter, and a symbol
            var passwordPattern =
                /^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/;

            if (!passwordPattern.test(password)) {
                alert(
                    "Password must have at least one number, one uppercase letter, and one symbol."
                );
                return false;
            }
        }
    </script>
</body>

</html>