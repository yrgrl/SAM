<?php
session_start();
if (!$_SESSION['role']) {
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
}
include("adminnav.php");
include("../../php/conn.php");

// Check if any rows were returned
// if (mysqli_num_rows($results) > 0) {
//     // Loop through the rows and add them to the enrollments array
//     while ($row = mysqli_fetch_assoc($results)) {
//         $enrollments[] = $row;
//     }
// }
?>
<!DOCTYPE html>
<html>

<head>
    <title> Admin - Admitted students</title>
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

        .add-btn,
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

        .level-dropdown {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .level-dropdown option {
            padding: 8px;
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sem = mysqli_real_escape_string($conn, $_POST['faculty']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);

        // Check if the year is empty
        if (empty($year)) {
            $year = 2023; // Assign the default value 2023
        }

        $sql = "SELECT a.*, f.*, c.*, d.* FROM accepted_students a 
        JOIN courses c ON c.course_id = a.course_id
        JOIN departments d ON d.id = c.department_id
        JOIN faculties f ON f.id = d.faculty_id
        WHERE a.course_id = '$sem' AND a.year = $year";

        $result = mysqli_query($conn, $sql);

        // $result = mysqli_query($conn, $sql);
    } else {
        $sql = "SELECT a.*, f.*, c.*, d.* FROM accepted_students a 
        JOIN courses c ON c.course_id = a.course_id
        JOIN departments d ON d.id = c.department_id
        JOIN faculties f ON f.id = d.faculty_id;";
        $result = mysqli_query($conn, $sql);
    }
    ?>

    <div class="main">
        <h1>Admissions per program and year</h1>
        <br>
        <p>Filter options</p>
        <form action="" method="POST">
            <select class="semester-dropdown" name="faculty">
                <?php
                $faculty = "SELECT * FROM courses;";
                $faculties = mysqli_query($conn, $faculty);
                foreach ($faculties as $faculty) {
                    //
                ?> <option value="<?= $faculty['course_id'] ?>"><?= $faculty['course_name'] ?></option>

                <?php
                }

                ?>

                <option value="may-aug">May-August</option>
                <option value="sept-dec">September-December</option>
            </select>
            <input type="text" id="year-input" class="semester-dropdown" name="year" placeholder="Enter a year -- 2023">
            <button type="submit" class="semester-dropdown" style="color:aliceblue; background-color:blue;">Filter</button>
        </form>
        <hr>
        <table id="student-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Level</th>
                    <th>Program</th>
                    <th>Semester</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve existing courses from the database
                if (mysqli_num_rows($result) == 0) {
                    echo '<tr>';
                    echo '<td colspan="6" style="text-align:center;">No data</td>';
                    echo '</tr>';
                } else {

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['student_id'] . '</td>';
                        echo '<td>' . $row['student_name'] . '</td>';
                        echo '<td>' . $row['level_of_study'] . '</td>';
                        echo '<td>' . $row['course_name'] . '</td>';
                        echo '<td>' . $row['semester'] . '</td>';
                        echo '<td>' . $row['year'] . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
    <script>
        function filterByLevel() {
            var selectedFaculty = document.getElementById("level-dropdown").value;
            var tableRows = document.querySelectorAll("#student-table tbody tr");

            tableRows.forEach(function(row) {
                var facultyCell = row.querySelector("td:nth-child(3)");
                var facultyName = facultyCell.textContent.trim();

                if (selectedFaculty === "all" || facultyName === selectedFaculty) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function filterByYear() {
            var selectedYear = document.getElementById("year").value;
            var tableRows = document.querySelectorAll("#student-table tbody tr");
            tableRows.forEach(function(row) {
                var facultyCell = row.querySelector("td:nth-child(5)");
                var dataYear = facultyCell.textContent.trim();

                if (dataYear === selectedYear) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>