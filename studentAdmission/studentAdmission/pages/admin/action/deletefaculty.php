<?php
session_start();

include("../../../php/conn.php");
$id = $_GET['id'];
$user = $_SESSION['user'];
$sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
VALUES ('Delete program id','$user',CURDATE(), CURTIME(),'delete','courses','admin')";
mysqli_query($conn, $sqllogs);
// echo $course_id;
// you have to delete all course and departments from this 
// $sql = "DELETE FROM faculties WHERE id = $id";

// if (mysqli_query($conn, $sql)) {
//     $success_message = "Record with ID $id deleted successfully.";
//     header("Location: ../faculties.php?success_message=" . urlencode($success_message));
//     exit();
// } else {
//     $error_message = "Delete error: " . mysqli_error($conn);
//     header("Location: ../faculties.php?error_message=" . urlencode($error_message));
//     exit();
// }
