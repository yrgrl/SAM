<?php
session_start();
include('conn.php');
if (isset($_POST['submit'])) {
    $qualification= mysqli_real_escape_string($conn, $_POST['qualification']);
    $course_id = mysqli_real_escape_string($conn, $_POST['program']);
    // $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $student_id = $_SESSION['user'];
    $level = 'enroll_pending';
    $level_points = 25;
    if (empty($errors)) {
        // check if student has exhisting enrollment.        
        $sql = "SELECT * FROM enrollments WHERE student_id = '$student_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Display an error message if the email address already exists            
            $success_message = "You have an active enrollment";
            header("Location: ../index.php?success_message=" . urlencode($success_message));
        } else {
            // Create a new record in the students table with the user's data
            $sql_enroll = "INSERT INTO enrollments (student_id, course_id) VALUES ('$student_id', '$course_id')";
            mysqli_query($conn, $sql_enroll);
            $sql_qualification = "INSERT INTO student_qualifications (student_id,qualification) VALUES ('$student_id', '$qualification')";
            mysqli_query($conn, $sql_qualification);
            $sql_progress = "INSERT INTO progress (student_id, progress_level, progress_points) VALUES ('$student_id','$level','$level_points')";
            if (mysqli_query($conn, $sql_progress)) {
                $sql = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Enroll','$student_id',CURDATE(), CURTIME(),'Enrollments','enrollments','student')";
                mysqli_query($conn, $sql);
                $success_message = "Enrolled Successfully, pending approval";
                header("Location: ../index.php?success_message=" . urlencode($success_message));
            }
            $errors[] = "Error: " . $sql_progress . "<br>" . mysqli_error($conn);
        }
    }
} else {
    echo ("<p>Am sorry but you are lost. You are not supposed to see this page.<p>");
}
?>
<?php if (!empty($errors)) { ?>
    <div class="error">
        <?php foreach ($errors as $error) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
    </div>
<?php } ?>