<?php
include("../../../php/conn.php");
session_start();
$course_id = $_GET['course_id'];
// echo $course_id;
$sql = "DELETE FROM courses WHERE course_id = $course_id";

if (mysqli_query($conn, $sql)) {
    $user = $_SESSION['user'];
    $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
    VALUES ('Delete program id $course_id','$user',CURDATE(), CURTIME(),'delete','courses','admin')";
    mysqli_query($conn, $sqllogs);
    $success_message = "Record with ID $course_id deleted successfully.";
    header("Location: ../courses.php?success_message=" . urlencode($success_message));
    exit();
} else {
    $error_message = "Delete error: " . mysqli_error($conn);
    header("Location: ../courses.php?error_message=" . urlencode($error_message));
    exit();
}
