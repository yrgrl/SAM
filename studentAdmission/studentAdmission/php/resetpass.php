<?php
session_start();
include('conn.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $role = $_SESSION['role'];
    if ($role == 'web-user') {
        $sql = "UPDATE staff
        SET password ='$hashed_password'
        WHERE email = '$email';";
    } elseif (!$role) {
        $sql = "UPDATE students
            SET password ='$hashed_password'
            WHERE email = '$email';";
    }
    mysqli_query($conn, $sql);
    $user = $_SESSION['user'];

    // mysqli_stmt_close($stmt);

    if (mysqli_affected_rows($conn) > 0) {

        $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Reset Password','$user',CURDATE(), CURTIME(),'forgot password','students','student')";
        mysqli_query($conn, $sqllogs);
        $error_message = "Password updated successfully";
        echo ("<script>alert($error_message)</script>");
        if ($role) {
            header("Location: ../pages/admin/admin.php");

        } elseif (!$role) {
            header("Location: ../pages/login.php");
        }
    } else {
        $error_message = "Error updating password: " . mysqli_error($conn);
        header("Location: ../pages/login.php?success_message=" . urlencode($error_message));
    }
} else {
    echo ('404, error: page soesnt not exhist');
}