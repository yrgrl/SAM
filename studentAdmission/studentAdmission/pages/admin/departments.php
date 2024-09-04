<?php
session_start();
if (!$_SESSION['role']) {
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>Departments</title>
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

        .department-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .department-form label {
            display: block;
            margin-bottom: 5px;
        }

        .department-form input[type='text'],
        .department-form select,
        .department-form textarea {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .department-form input[type='submit'] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .department-form input[type='submit']:hover {
            background-color: #3e8e41;
        }

        .add-department-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .add-department-form label {
            display: block;
            margin-bottom: 5px;
        }

        .add-department-form input[type='text'],
        .add-department-form select {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <?php

    include("adminnav.php");
    include("../../php/conn.php");

    // Check if the department form has been submitted
    if (isset($_POST['submit_department'])) {
        // Get the form data
        $name = $_POST['name'];
        $faculty_id = $_POST['faculty_id'];

        // Insert the new department into the database
        $sql = "INSERT INTO departments (name, faculty_id) VALUES ('$name', '$faculty_id')";
        if (mysqli_query($conn, $sql)) {
            echo "New department added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Select all departments with their respective faculties from the database
    $sql = "SELECT departments.id, departments.name, faculties.name AS faculty_name FROM departments INNER JOIN faculties ON departments.faculty_id = faculties.id";
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="main">
        <h1>Departments</h1>
        <?php

        // Select all faculties from the faculties table for dropdown menu
        $sql_faculty = "SELECT * FROM faculties";
        $result_faculty = mysqli_query($conn, $sql_faculty);

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            // Get the form data
            $name = $_POST['name'];
            $faculty_id = $_POST['faculty'];

            // Insert the new department into the database
            $sql = "INSERT INTO departments (name, faculty_id) VALUES ('$name', '$faculty_id')";
            if (mysqli_query($conn, $sql)) {
                $user = $_SESSION['user'];
                $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Created department $name','$user',CURDATE(), CURTIME(),'create','departments','admin')";
                mysqli_query($conn, $sqllogs);
                echo "$name department added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Select all departments and their corresponding faculties from the departments and faculties tables
        $sql = "SELECT departments.id, departments.name, faculties.name as faculty_name FROM departments JOIN faculties ON departments.faculty_id = faculties.id";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="add-department-form">
            <h2>Add Department</h2>
            <form method='post'>
                <label for='name'>Name:</label>
                <input type='text' name='name' id='name'>
                <label for='faculty'>Faculty:</label>
                <select name='faculty' id='faculty'>
                    <?php
                    // Loop through each row in the faculties result set and display it as an option in the dropdown menu
                    if (mysqli_num_rows($result_faculty) > 0) {
                        while ($row = mysqli_fetch_assoc($result_faculty)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No faculties found.</option>";
                    }
                    ?>
                </select>
                <br>
                <input type='submit' name='submit' value='Add Department'>
            </form>
        </div>
        <div class="department-list">
            <h2>Department List</h2>
            <?php
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Faculty</th></tr>";

            // Loop through each row in the departments result set and display it in a table row
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["faculty_name"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No departments found.</td></tr>";
            }
            echo "</table>";

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>

</html>