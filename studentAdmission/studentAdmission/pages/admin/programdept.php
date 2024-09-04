<?php
// all programs per department
session_start();
include('../../php/conn.php');

if (!$_SESSION['role']) {
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Courses</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

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

        .topnav .user-profile {
            float: right;
            margin-right: 10px;
            margin-left: 10px;
        }

        .topnav .logout {
            float: right;
            margin-right: 5px;

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dept_id = mysqli_real_escape_string($conn, $_POST['dept_id']);
        $sql = "SELECT courses.*, departments.name AS department_name FROM courses 
        JOIN departments ON courses.department_id = departments.id 
        WHERE courses.department_id =$dept_id";
        $result = mysqli_query($conn, $sql);
    } else {
        $sql = "SELECT courses.*, departments.name AS department_name
        FROM courses JOIN departments ON courses.department_id = departments.id";
        $result = mysqli_query($conn, $sql);
    }
    ?>
    <div class="main">

        <h1>Programs per department</h1>
        <form action="" method="POST">
            <label>Filter by department</label>
            <select class="semester-dropdown" name="dept_id">
                <?php
                $sqlprograns = "SELECT id, name FROM departments";
                $departs = mysqli_query($conn, $sqlprograns);

                if (mysqli_num_rows($departs) > 0) {
                    while ($row = mysqli_fetch_assoc($departs)) {
                        $depart = $row['name'];
                        $d_id = $row['id'];
                        echo "<option value=\"$d_id\">$depart</option>";
                    }
                } else {
                    echo "<option value=\"\">No programs found</option>";
                }
                ?>
            </select>

            <!-- <input type="text" id="year-input" class="semester-dropdown" name="year" placeholder="Enter a year"> -->
            <button type="submit" class="semester-dropdown"
                style="color:aliceblue; background-color:blue;">Filter</button>
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
                    <th>Program ID</th>
                    <th>Program Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Department</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve existing courses from the database
                

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
                    <?php
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>