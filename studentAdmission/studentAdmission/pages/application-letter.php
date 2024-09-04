<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}



include('../php/conn.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Application Letter</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/application.css">
    <style>
        body {
            background-color: #0b0544;
            /* color:#fff; */
        }

        form {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        .form-row {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #0b0544;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .columns-container {
            display: flex;
            flex-wrap: wrap;
        }

        .column {
            flex: 1;
            margin: 2px;
            /* margin: 0 10px; */
        }

        /* Style for the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: white;
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
    </style>
</head>

<body>
    <?php
    $id = $_SESSION['user'];
    $sqlUser = "SELECT * FROM students WHERE student_id='$id'";
    $results = mysqli_query($conn, $sqlUser);
    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);
        $userName = $row['first_name'];
    }
    ?>
    <div class="topnav">
        <a href="../php/logout.php">Logout</a>
        <div class="dropdown">
            <button class="dropbtn">
                <?= $userName; ?>
            </button>
            <div class="dropdown-content">
                <a href="../pages/resetpass.php">Change Password</a>
            </div>
        </div>
    </div>
    <?php
    $user = "SELECT * FROM students WHERE student_id ='$id'";
    $results = mysqli_query($conn, $user);
    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
    }
    $applications = "SELECT * from applications where student_id='$id'";
    $appli = mysqli_query($conn, $applications);
    mysqli_num_rows($appli);
    $myApplication = mysqli_fetch_assoc($appli);

    $enroll = "SELECT enrollments.*, courses.* FROM enrollments JOIN courses ON enrollments.course_id = courses.course_id WHERE enrollments.student_id = '$id'";
    $enrolls = mysqli_query($conn, $enroll);
    if (mysqli_num_rows($enrolls) == 1) {
        $enrollment = mysqli_fetch_assoc($enrolls);
    }

    ?>

    <div class="container">
        <h1>CUEA Online Admission</h1>
        <div style="text-align: center;">
            <img src="../imgs/logo.png" style="display: block; margin: 0
                    auto;">
        </div>
        <div class="page-content">
            <h1>Admission Letter</h1>
            <p>Dear
                <?= $firstName; ?>
                <?= $lastName; ?>
            </p>
            <p>We are pleased to inform you that you have been admitted into our institution for the <strong>
                    <?= $myApplication['level_of_study'] ?>
                </strong> program in <strong>
                    <?= $enrollment['course_name'] ?>
                </strong>. Your classes will begin on <strong>1st June 2023</strong>. Please ensure that you are present
                and punctual for all your classes.</p>
            <p>Program: <strong>
                    <?= $enrollment['course_name'] ?>
                </strong> </p>
            <p>Student ID: <strong>
                    <?= $id ?>
                </strong></p>
            <p>Tuition: <strong>KSH
                    <?= $enrollment['course_price'] ?>
                </strong></p>
            <p>Please note that payment is due by <strong>1st June 2023</strong> to secure your enrollment.
                If you have any questions or concerns about your financial aid package, please contact our financial aid
                office.</p>
            <p>We encourage you to take advantage of the many resources available to you as a student, including our
                academic advising services,
                career center, and student organizations. Our campus is also home to a variety of cultural and athletic
                events,
                so be sure to check out our calendar of events for opportunities to get involved and connect with your
                fellow students.</p>
            <p>Your enrollment details are as follows:</p>
            <p>Best regards,</p>
            <p>The Admission Team</p>
        </div>
        <button onclick="window.print()">Print</button>
</body>

</html>