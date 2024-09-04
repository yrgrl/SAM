<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
    <style>
        /* Set font family and size */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        /* Style the container */
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
        }

        /* Style the form */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Style the input fields */
        input[type="password"] {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="email"] {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Style the submit button */
        button[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Hover effect for the submit button */
        button[type="submit"]:hover {
            background-color: #0062cc;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <h1>Change Password</h1>
        <form action='../php/resetpass.php' onsubmit="return validateForm();" method="POST">
            <label for="old-password">Email Address</label>
            <input type="email" id="email" name="email" required>
            <!-- <label for="old-password">Old Password</label>
            <input type="password" id="old-password" name="old-password" required> -->
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="password" required>
            <label for="confirm-new-password">Confirm New Password</label>
            <input type="password" id="confirm-new-password" name="confirm-new-password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("new-password").value;
            var confirmPassword = document.getElementById("confirm-new-password").value;
            if (email == "") {
                alert("Please enter your email");
                return false;
            }
            if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
                //checks if the length of the email is equal to zero/empty, does not contain the @ symbol and dot.
                alert("Please enter a valid email address.");
                return false;
            }
            if (password == "") {
                alert("Please enter a password.");
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

            function isPasswordValid(password) {
                if (!/\d/.test(password) || !/[A-Z]/.test(password) || !/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(password) || password.length < 8) {
                    alert("Password must have at least one number, one uppercase letter, and one symbol.");
                    return false;
                }
                return true;
            }
        }
    </script>
</body>

</html>