<?php
// Start a session to store the user's data
session_start();
include('conn.php');

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middleName']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($errors)) {
        // Check if the email address already exists in the database
        $email_check_sql = "SELECT * FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $email_check_sql);
        if (mysqli_num_rows($result) > 0) {
            // Display an error message if the email address already exists
            $errors[] = "Email address already exists";
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create a new record in the students table with the user's data
            $sql = "INSERT INTO students (first_name, middle_name, last_name, email, password) VALUES ('$first_name', '$middle_name', '$last_name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $sql)) {
                // Store the user's data in the session
                $_SESSION['first_name'] = $first_name;
                $_SESSION['middle_name'] = $middle_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['email'] = $email;

                //fetch student details and save logs
                $student = "SELECT student_id FROM students WHERE email ='$email'";
                $studentid = mysqli_query($conn, $student);
                $student_id = mysqli_fetch_assoc($studentid);
                $user = $student_id['student_id'];
                //save logs
                $sql = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Registration','$user',CURDATE(), CURTIME(),'registrations','students','student')";
                mysqli_query($conn, $sql);
                // Close the database connection
                mysqli_close($conn);
                // Redirect to the success page
                $success_message = "You have successfully registered. Please login with your credentials.";
                header("Location: ../pages/login.php?success_message=" . urlencode($success_message));
                exit();
            } else {
                // Display an error message if the query fails
                $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
} else {
    echo ("<p>Am sorry but you are lost. You are not supposed to see this page.<p>");
}
?>
<!-- Display any errors -->
<?php if (!empty($errors)) { ?>
    <div class="error">
        <?php foreach ($errors as $error) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
    </div>
<?php } ?>