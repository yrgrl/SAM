<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <!-- <link rel="stylesheet" href="../../css/admin.css" /> -->
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

        .semester-dropdown {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .semester-dropdown option {
            padding: 8px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (!$_SESSION['role']) {

        header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
    }

    include("adminnav.php");
    include("../../php/conn.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sem = mysqli_real_escape_string($conn, $_POST['semester']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);

        // Check if the year is empty
        if (empty($year)) {
            $year = 2023; // Assign the default value 2023
        }

        $sql = "SELECT * FROM accepted_students WHERE semester = '$sem' AND year = $year";
        $results = mysqli_query($conn, $sql);
    } else {
        $sql = "SELECT * FROM accepted_students";
        $results = mysqli_query($conn, $sql);
    }
    $enrollments = array();


    // Check if any rows were returned
    if (mysqli_num_rows($results) > 0) {
        // Loop through the rows and add them to the enrollments array
        while ($row = mysqli_fetch_assoc($results)) {
            $enrollments[] = $row;
        }
    }
    ?>
    <!-- main content -->
    <div class="main">
        <h1>Sessions</h1>
        <p>Filter options</p>
        <form action="" method="POST">
            <select class="semester-dropdown" name="semester">
                <option value="jan-april">January to April</option>
                <option value="may-aug">May-August</option>
                <option value="sept-dec">September-December</option>
            </select>
            <input type="text" id="year-input" class="semester-dropdown" name="year" placeholder="Enter a year -- 2023">
            <button type="submit" class="semester-dropdown" style="color:aliceblue; background-color:blue;">Filter</button>
        </form>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Studen ID</th>
                    <th>Student Name</th>
                    <th>Level of study</th>
                    <th>Student type </th>
                    <th>Mode</th>
                    <th>Program Id</th>
                    <th>Program Name</th>
                    <th>Semester</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop through the enrollments and display each row -->
                <?php
                if (mysqli_num_rows($results) == 0) {
                    echo "<td colspan='9'>No records</td>";
                } else {


                    // 
                ?>
                    <?php foreach ($enrollments as $enrollment) : ?>
                        <tr>
                            <!-- student_id, student_name, level_of_study, student_type, study_mode, course_id, course_name, semester, year -->
                            <td><?= $enrollment['student_id'] ?></td>
                            <td><?= $enrollment['student_name'] ?></td>
                            <td><?= $enrollment['level_of_study'] ?></td>

                            <td> <?php
                                    if ($enrollment['student_type'] == "gov") {
                                        echo ("Government Sponsered");
                                    } else {
                                        echo ("Self-Sponsored");
                                    } ?>
                            </td>
                            <td>
                                <?php
                                if ($enrollment['study_mode'] == "full-time") {
                                    echo ("Full Time");
                                } else {
                                    echo ("Part Time");
                                } ?>
                            </td>
                            <td><?= $enrollment['course_id'] ?></td>
                            <td><?= $enrollment['course_name'] ?></td>
                            <td><?= $enrollment['semester'] ?></td>
                            <td><?= $enrollment['year'] ?></td>
                        </tr>
                <?php endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>