<?php session_start();
if (!$_SESSION['role']) {
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
} ?>
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

        .add-btn:hover,
        .view-btn:hover {
            background-color: #004c6d;
        }

        .course-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .course-form label {
            display: block;
            margin-bottom: 5px;
        }

        .course-form input[type='text'],
        .course-form input[type='number'],
        .course-form select,
        .course-form textarea {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .course-form input[type='submit'] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .course-form input[type='submit']:hover {
            background-color: #3e8e41;
        }

        .add-course-form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .add-course-form label {
            display: block;
            margin-bottom: 5px;
        }

        .add-course-form input[type='text'],
        .add-course-form input[type='number'],
        .add-course-form select {
            width: 60%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit_course input[type='submit'] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit_course input[type='submit']:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <?php

    include("adminnav.php");
    include("../../php/conn.php");



    // Check if the course form has been submitted
    if (isset($_POST['submit_course'])) {
        // Get the form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $department_id = $_POST['department_id'];
        $user = $_SESSION['user'];

        // Insert the new course into the database
        $sql = "INSERT INTO courses (course_name, course_description, course_price, department_id) VALUES ('$name', '$description', '$price','$department_id')";
        if (mysqli_query($conn, $sql)) {
            $sqllogs = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
                VALUES ('Add new program','$user',CURDATE(), CURTIME(),'add courses','courses','admin')";
            mysqli_query($conn, $sqllogs);
            // If the course was successfully added, redirect to the courses page
            echo "<script>alert('Course added suceessfully.')</script>";
            // exit;
        } else {
            // If an error occurred, display an error message
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>
    <div class="main">

        <h1>Add Program</h1>
        <form method="post" action="courses.php" class="add-course-form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required><br>

            <label for="department_id">Department:</label>
            <select name="department_id" id="department_id" required>
                <option value="">Select a department</option>
                <?php
                // Query the departments from the database
                $sql = "SELECT * FROM departments";
                $result = mysqli_query($conn, $sql);

                // Loop through the departments and create an option for each one
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select><br>
            <input type="submit" class="submit_course" name="submit_course" value="Add Course">
        </form>
        <table>
            <?php
            //show delete success and error message
            if (isset($_GET['success_message'])) {
                $success_message = $_GET['success_message'];
                echo "<div class='success-message'>$success_message</div>";
            } elseif (isset($_GET['error_message'])) {
                $error_message = $_GET['error_message'];
                echo "<div class='error-message'>$error_message</div>";
            }
            ?>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve existing courses from the database
                $sql = "SELECT courses.*, departments.name AS department_name
                FROM courses
                JOIN departments ON courses.department_id = departments.id;
                ";
                $result = mysqli_query($conn, $sql);

                // Loop through the result set and display each course as a table row
                while ($row = mysqli_fetch_assoc($result)) {
                    // course_id, course_name, course_description, course_price, department_id
                    echo '<tr>';
                    echo '<td>' . $row['course_id'] . '</td>';
                    echo '<td>' . $row['course_name'] . '</td>';
                    echo '<td>' . $row['course_description'] . '</td>';
                    echo '<td>' . $row['course_price'] . '</td>';
                    echo '<td>' . $row['department_name'] . '</td>';
                ?>
                    <td>
                        <a href="./action/delete.php?course_id=<?= $row["course_id"] ?>" class="delete-btn" style="background-color: red; color:white;">Delete</a>
                    </td>
                <?php
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>