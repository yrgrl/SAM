<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <!-- <link rel="stylesheet" href="../../../css/admin.css" /> -->
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

        /* Style for the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: #0b0544;
            position: fixed;
            margin-left: -10px;
            top: 0;
            width: 100%;
            border-radius: 10px;
        }

        /* Style for the links in the top navigation bar */
        .topnav a {
            float: right;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        /* Style for the active link in the top navigation bar */
        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        /* Style for the user profile dropdown in the top navigation bar */
        .topnav .dropdown {
            float: right;
            overflow: hidden;
        }

        /* Style for the user profile dropdown button in the top navigation bar */
        .topnav .dropdown .dropbtn {
            font-size: 17px;
            border: none;
            outline: none;
            color: black;
            padding: 14px 16px;
            background-color: inherit;
            margin: 0;
        }

        /* Style for the user profile dropdown content in the top navigation bar */
        .topnav .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
        }

        /* Style for the user profile dropdown links in the top navigation bar */
        .topnav .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        /* Style for the user profile dropdown links on hover in the top navigation bar */
        .topnav .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Show the user profile dropdown content when the user clicks on the dropdown button in the top navigation bar */
        .topnav .dropdown:hover .dropdown-content {
            display: block;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: left;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .approve-btn,
        .decline-btn,
        .view-btn {
            display: inline-block;
            padding: 6px 12px;
            background-color: #008cba;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
            margin-right: 8px;
        }

        .approve-btn:hover,
        .decline-btn:hover,
        .view-btn:hover {
            background-color: #004c6d;
        }

        textarea {
            width: 40%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.2s ease-in-out;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="topnav" style="color:black;">
        <div class="top_nav">
            <a href="../../resetpass.php" class="user-profile">User Profile</a>
            <a href="../../../php/logout.php" class="logout">Logout</a>
        </div>
    </div>
    <div class="sidenav">
        <div style="text-align: center">
            <img src="../../../imgs/logo.png" style="display: block; margin: 0 auto" />
        </div>
        <div class="side_nav">
            <a href="../admin.php">Home</a>
            <a href="../active.php">Enrollment</a>
            <a href="../application.php">Applications</a>
            <a href="../admin.php">Reports</a>
        </div>
    </div>
    <?php
    // session_start();
    include("../../../php/conn.php");
    $enrollment_id = $_GET['enrollment_id'];
    $sql = "SELECT enrollments.*, CONCAT(students.first_name, ' ', COALESCE(students.middle_name, ''), ' ', students.last_name) AS studentName, courses.course_name 
        FROM enrollments 
        INNER JOIN students ON enrollments.student_id = students.student_id 
        INNER JOIN courses ON enrollments.course_id = courses.course_id 
        WHERE enrollments.enrollment_id = '$enrollment_id'";
    $results = mysqli_query($conn, $sql);
    if (mysqli_num_rows($results) == 1) {
        $enrollment = mysqli_fetch_assoc($results);
        $studentId = $enrollment['student_id'];
    } else {
        echo "error";
    }
    // check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // get the enrollment ID and action from the form data
        $enrollment_id = filter_input(INPUT_POST, 'enrollment_id', FILTER_VALIDATE_INT);
        $action = mysqli_real_escape_string($conn, $_POST['status']);

        $approvedBy = $_SESSION['user'];
        $user = $_SESSION['user'];
        // echo( $approvedBy);
        $comments = mysqli_real_escape_string($conn, $_POST['comments']);

        if ($enrollment_id) {
            $updateEnrollmentSql = "UPDATE enrollments SET approved_status = '$action', approved_by = '$approvedBy', remarks = '$comments' WHERE enrollment_id = $enrollment_id";
            if (mysqli_query($conn, $updateEnrollmentSql)) {
                //   "<script>alert('Enrollment record updated successfully.')</script>";
                $getStudentIDSql = "SELECT student_id FROM enrollments WHERE enrollment_id= $enrollment_id ";
                $studentidResult = mysqli_query($conn, $getStudentIDSql);

                if (mysqli_num_rows($studentidResult) > 0) {
                    $studentidRow = mysqli_fetch_assoc($studentidResult);
                    $studentid = $studentidRow['student_id'];
                    $getProgressSql = "SELECT * FROM progress WHERE student_id = $studentid";
                    $progressResult = mysqli_query($conn, $getProgressSql);
                    if ($action == "Approved") {
                        $level = "application";
                        $level_points = 50;
                        $message = "Enrollment has been approved.";
                    } else {
                        $level = "declined";
                        $level_points = 0;
                        $message = "Enrollment has been declined.";
                    }
                    if (mysqli_num_rows($progressResult) > 0) {
                        $updateProgressSql = "UPDATE progress SET progress_level = '$level', progress_points = $level_points, message = '$message' WHERE student_id = $studentid";
                    } else {
                        $updateProgressSql = "INSERT INTO progress (student_id, progress_level, progress_points, message) VALUES ($studentid, '$level', $level_points, '$message')";
                    }
                    if (mysqli_query($conn, $updateProgressSql)) {
                        $error_message = "Progress saved successfully";
                        $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                        VALUES ('Approve enrollment','$user',CURDATE(), CURTIME(),'approve enrollments','enrollments','admin')";
                        mysqli_query($conn, $sqllogs);
                        header("Location: ../active.php?error_message=" . urlencode($error_message));
                    } else {
                        $error_message = 'Error updating progress record: " . mysqli_error($conn) . "';
                        header("Location: ../active.php?error_message=" . urlencode($error_message));
                    }
                } else {
                    $error_message = "No student selected')</script>";
                    header("Location: ../active.php?error_message=" . urlencode($error_message));
                }
            } else {
                $error_message = "Error updating enrollment record: ";
                header("Location: ../active.php?error_message=" . urlencode($error_message));
            }
        } else {
            $error_message = "Invalid enrollment ID";
            header("Location: ../active.php?error_message=" . urlencode($error_message));
        }
    }

    ?>

    <div class="main">
        <br>
        <br>
        <br>
        <br>
        <h1>Action on Enrollment</h1>
        <div class="card">
            <div class="card-header">
                Details
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <?= $enrollment['course_name'] ?>
                </h5>
                <p class="card-text">Student Name:
                    <?= $enrollment['studentName'] ?>
                </p>
                <p class="card-text">Enrollment Date:
                    <?= $enrollment['enrollment_date'] ?>
                </p>
                Accademic Details
                <table>
                    <thead>
                        <tr>
                            <th>Qualifications</th>
                            <th>Updated at</th>
                            <th>Institutions</th>
                            <th>Certificate No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qualiSql = "SELECT * from student_qualifications WHERE student_id = '$studentId'";
                        $result = mysqli_query($conn, $qualiSql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($enroll = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td>
                                        <?= $enroll['qualification'] ?>
                                    </td>
                                    <td>
                                        <?= $enroll['updated_at'] ?>
                                    </td>
                                    <td>
                                        <?= $enroll['institutions_attended'] ?>
                                    </td>
                                    <td>
                                        <?= $enroll['certificate_no'] ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo ("<tr><td colspan='4'>No records found</td></tr>");
                        }
                        ?>
                    </tbody>
                </table>
                <p class="card-text text-success">Status:
                    <?= $enrollment['approved_status'] ?>
                </p>
                <br>
                <br>
                <?php
                if ($enrollment['approved_status'] == "Pending") {
                    echo '<button class="approve-btn">Approve</button>';
                    echo ' <button class="decline-btn">Decline</button>';
                } ?>
                <br>
                <br>
                <form id="approval-form" method="POST" style="display:none">
                    <input type="hidden" name="enrollment_id" value="<?= $enrollment_id ?>">
                    <input type="hidden" name="approved_by" value="<?= $_SESSION['user'] ?>">
                    <input type="hidden" name="status" value="Approved">
                    <label for="email">Comments</label>
                    <br>
                    <br>
                    <textarea type="text" id="comments" name="comments"> </textarea>
                    <br>
                    <br>
                    <button class="approve-btn">Approve</button>
                </form>
                <form id="decline-form" method="POST" style="display:none">
                    <input type="hidden" name="enrollment_id" value="<?= $enrollment_id ?>">
                    <input type="hidden" name="approved_by" value="<?= $_SESSION['user'] ?>">
                    <input type="hidden" name="status" value="Rejected">
                    <label for="email">Comments</label>
                    <br>
                    <br>
                    <textarea type="text" id="comments" name="comments"> </textarea>
                    <br>
                    <br>
                    <button class="decline-btn">Decline</button>
                </form>
                <script>
                    const approveBtn = document.querySelector('.approve-btn');
                    const declineBtn = document.querySelector('.decline-btn');
                    const approvalForm = document.querySelector('#approval-form');
                    const declineForm = document.querySelector('#decline-form');

                    approveBtn.addEventListener('click', function() {
                        approvalForm.style.display = 'block';
                    });
                    declineBtn.addEventListener('click', function() {
                        declineForm.style.display = 'block';
                    });
                </script>


            </div>
        </div>
    </div>
</body>

</html>