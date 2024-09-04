<!DOCTYPE html>
<html>

<head>
    <title>Courses</title>
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

    // Check if the course form has been submitted
    if (isset($_POST['submit_course'])) {
        // Get the form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $department_id = $_POST['department_id'];

        // Insert the new course into the database
        $sql = "INSERT INTO courses (course_name, course_description, course_price, department_id) VALUES ('$name', '$description', '$price','$department_id')";
        if (mysqli_query($conn, $sql)) {
            // If the course was successfully added, redirect to the courses page
            header("Location: courses.php");
            exit;
        } else {
            // If an error occurred, display an error message
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>
    <div class="main">
        <h1>All Applications</h1>
        <label>Filter by faculty</label>
        <br>
        <hr>
        <select id="faculty-dropdown" onchange="filterByFaculty()" class="semester-dropdown">
            <option value="all">All Faculties</option>

            <?php
            // Retrieve existing faculties from the database
            $sql = "SELECT * FROM faculties";
            $result = mysqli_query($conn, $sql);

            // Loop through the result set and display each faculty as an option in the dropdown
            while ($row = mysqli_fetch_assoc($result)) {

                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
        </select>
        <br>
        <hr>
        <table id="student-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Faculty</th>
                    <th>Department</th>
                    <th>Course Name</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve existing courses from the database
                $sql = "SELECT a.*,s.*, e.*, c.*, d.name AS department, f.name AS faculty
                FROM applications a
                INNER JOIN enrollments e ON a.enrollments_id = e.enrollment_id
                INNER JOIN courses c ON e.course_id = c.course_id
                INNER JOIN departments d ON c.department_id = d.id
                INNER JOIN faculties f ON d.faculty_id = f.id
                INNER JOIN students s ON a.student_id = s.student_id
                ";
                $result = mysqli_query($conn, $sql);

                // Loop through the result set and display each course as a table row
                while ($row = mysqli_fetch_assoc($result)) {
                    // course_id, course_name, course_description, course_price, department_id
                    echo '<tr>';
                    echo '<td>' . $row['student_id'] . '</td>';
                    echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
                    echo '<td>' . $row['faculty'] . '</td>';
                    echo '<td>' . $row['department'] . '</td>';
                    echo '<td>' . $row['course_name'] . '</td>';
                    echo '<td>' . $row['enrollment_date'] . '</td>';
                    echo '<td>' . $row['status'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function filterByFaculty() {
            var selectedFaculty = document.getElementById("faculty-dropdown").value;
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
    </script>

</body>

</html>