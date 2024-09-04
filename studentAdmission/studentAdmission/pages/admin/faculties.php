<?php
// PHP code for session and authorization check
session_start();
if (!$_SESSION['role']) {
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>Faculties</title>
    <link rel="stylesheet" href="../../css/admin.css" />
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

        /* CSS styles for the table and expansion */
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

        .department-row {
            display: none;
            background-color: #f9f9f9;
        }

        .department-row td {
            padding-left: 40px;
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

        .faculty-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .faculty-form label {
            display: block;
            margin-bottom: 5px;
        }

        .faculty-form input[type='text'],
        .faculty-form textarea {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .faculty-form input[type='submit'] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .faculty-form input[type='submit']:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <?php
    include("adminnav.php");
    include("../../php/conn.php");

    // Function to sanitize input data
    function sanitize($data)
    {
        global $conn;
        $data = trim($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }

    // Add new faculty to the database
    if (isset($_POST['submit'])) {
        $name = sanitize($_POST['name']);
        $description = sanitize($_POST['description']);
        $insertSql = "INSERT INTO faculties (name, description) VALUES ('$name', '$description')";
        $insertResult = mysqli_query($conn, $insertSql);

        if ($insertResult) {
            $user = $_SESSION['user'];
            $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
            VALUES ('Created department $name','$user',CURDATE(), CURTIME(),'create faculty description: $description','faculties','admin')";
            mysqli_query($conn, $sqllogs);
            echo "<script>alert('Faculty added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add faculty');</script>";
        }
    }

    // Fetch faculties from the database
    $facultiesSql = "SELECT * FROM faculties";
    $facultiesResult = mysqli_query($conn, $facultiesSql);
    $faculties = mysqli_fetch_all($facultiesResult, MYSQLI_ASSOC);

    // Fetch departments for each faculty
    $departmentsSql = "SELECT * FROM departments";
    $departmentsResult = mysqli_query($conn, $departmentsSql);
    $departments = mysqli_fetch_all($departmentsResult, MYSQLI_ASSOC);

    // Fetch programs for each department
    $programsSql = "SELECT * FROM courses";
    $programsResult = mysqli_query($conn, $programsSql);
    $programs = mysqli_fetch_all($programsResult, MYSQLI_ASSOC);
    ?>

    <div class="main">
        <h1>Faculties</h1>

        <!-- Form code for adding a new faculty -->
        <form method='post' class='faculty-form'>
            <label for='name'>Name:</label>
            <input type='text' name='name' id='name'>
            <label for='description'>Description:</label>
            <textarea name='description' id='description'></textarea>
            <br>
            <input type='submit' name='submit' value='Add Faculty'>
        </form>
        <br>

        <table id="facultyTable">
            <p>Click on the table row to expand </p>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>

            <?php
            // Loop through faculties
            foreach ($faculties as $faculty) {
                echo "<tr class='faculty-row' data-faculty-id='" . $faculty["id"] . "'>";
                echo "<td>" . $faculty["id"] . "</td>";
                echo "<td>" . $faculty["name"] . "</td>";
                echo "<td>" . $faculty["description"] . "</td>";
                echo "<td>";
                echo "<a href='./action/deletefaculty.php?id=" . $faculty["id"] . "' class='delete-btn' style='background-color: red; color:white;'>Delete</a>";
                echo "</td>";
                echo "</tr>";

                // Loop through departments for the current faculty
                // foreach ($departments as $department) {
                //     if ($department["faculty_id"] == $faculty["id"]) {
                //         echo "<tr class='department-row' data-faculty-id='" . $faculty["id"] . "'>";
                //         echo "<td></td>"; // Empty cell for indentation
                //         echo "<td>" . $department["name"] . "</td>";
                //         echo "<td>" . $department["name"] . "</td>";
                //         echo "<td></td>"; // Empty cell for action column
                //         echo "</tr>";
                //     }
                // }
                foreach ($departments as $department) {
                    if ($department["faculty_id"] == $faculty["id"]) {
                        echo "<tr class='department-row' data-faculty-id='" . $faculty["id"] . "'>";
                        echo "<td></td>"; // Empty cell for indentation
                        echo "<td><a href='./sub/coursesperdept.php?dept_id=" . $department["id"] . "'>" . $department["name"] . "</a></td>";
                        echo "<td>" . $department["name"] . "</td>";
                        echo "<td></td>"; // Empty cell for action column
                        echo "</tr>";
                    }
                }
            }

            // Check if no faculties found
            if (empty($faculties)) {
                echo "<tr><td colspan='4'>No faculties found.</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>

        </table>

    </div>

    <script>
        // JavaScript code to toggle visibility of department rows when a faculty row is clicked
        document.addEventListener('DOMContentLoaded', function() {
            var facultyRows = document.querySelectorAll('.faculty-row');

            facultyRows.forEach(function(row) {
                row.addEventListener('click', function() {
                    var facultyId = row.getAttribute('data-faculty-id');
                    var departmentRows = document.querySelectorAll('.department-row[data-faculty-id="' + facultyId + '"]');

                    departmentRows.forEach(function(departmentRow) {
                        departmentRow.style.display = (departmentRow.style.display === 'none') ? 'table-row' : 'none';
                    });
                });
            });

            var departmentRows = document.querySelectorAll('.department-row');

            departmentRows.forEach(function(row) {
                row.addEventListener('click', function() {
                    var departmentId = row.getAttribute('data-depart-id');
                    var programRows = document.querySelectorAll('.program-row[data-depart-id="' + departmentId + '"]');

                    programRows.forEach(function(programRow) {
                        programRow.style.display = (programRow.style.display === "none") ? 'table-row' : 'none';
                    });
                });
            });
        });
    </script>
</body>

</html>