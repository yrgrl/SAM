<?php
session_start();
include('conn.php');
$user = $_SESSION['user'];
$sql = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
VALUES ('Logout','$user',CURDATE(), CURTIME(),'User logout','-','-')";
mysqli_query($conn, $sql);

session_destroy();
// header('location:index.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Logout Page</title>
    <link rel="stylesheet" href="../css/Login.css" />
    <style>
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

        h1,
        h3 {
            text-align: center;
        }

        p {
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
        <?php if (isset($_GET['success_message'])): ?>
            var success_message = "<?php echo $_GET['success_message']; ?>";
            alert(success_message);
        <?php endif; ?>
    </script>
</head>

<body>
    <?php
    // session_start();
    if (isset($_SESSION['user'])) {
        header("Location: ../index.php");
    }
    if (isset($errors) && !empty($errors)) { ?>
        <div style="color: red">
            <?php foreach ($errors as $error) { ?>
                <p>
                    <?php echo $error; ?>
                </p>
            <?php }
    } ?>
    </div>

    <div class="login-box">
        <h1>CUEA Online Admission</h1>
        <div style="text-align: center">
            <img src="../imgs/logo.png" style="display: block; margin: 0 auto" />
        </div>
        <br>
        <br>
        <br>
        <h3>You have been logged out</h3>
        <p><a href="../pages/login.php">Login</a></p>
    </div>
    <!-- validation javascript -->

</body>

</html>