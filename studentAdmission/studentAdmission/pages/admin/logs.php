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

    $sql = "SELECT * FROM logs";
    $results = mysqli_query($conn, $sql);
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
        <h1>User logs</h1>
        <table>
            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>Action</th>
                    <th>Action Category</th>
                    <th>Action Table</th>
                    <th>User Name</th>
                    <th>User Role</th>
                    <th>Time</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop through the enrollments and display each row -->
                <?php
                if (mysqli_num_rows($results) == 0) {
                    echo "<td>No records</td>";
                } else {


                ?>
                    <?php foreach ($enrollments as $enrollment) : ?>
                        <tr>
                            <td><?= $enrollment['id'] ?></td>
                            <td><?= $enrollment['actions'] ?></td>
                            <td><?= $enrollment['category'] ?></td>
                            <td><?= $enrollment['actiontable'] ?></td>
                            <td>
                                <?php
                                if ($enrollment['user_role'] == "student") {
                                    $user = $enrollment['actionby'];
                                    $sqluser = "SELECT CONCAT(students.first_name, ' ', COALESCE(students.middle_name, ''), ' ', students.last_name) AS studentName FROM students where student_id = $user";
                                    $userNameResult = mysqli_query($conn, $sqluser);
                                    if ($userNameResult) {
                                        $userName = mysqli_fetch_assoc($userNameResult);
                                        echo ($userName['studentName']);
                                    } else {
                                        echo "Error retrieving student name.";
                                    }
                                } else if ($enrollment['user_role'] == "admin") {
                                    $user = $enrollment['actionby'];
                                    $sqluser = "SELECT CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS staffName FROM staff where staff_id = $user";
                                    $userNameResult = mysqli_query($conn, $sqluser);
                                    if ($userNameResult) {
                                        $userName = mysqli_fetch_assoc($userNameResult);
                                        echo ($userName['staffName']);
                                    } else {
                                        echo "Error retrieving staff name.";
                                    }
                                } else {
                                    echo ($enrollment['user_role']);
                                }
                                ?>
                            </td>
                            <td><?= $enrollment['user_role'] ?></td>
                            <td><?= $enrollment['actiontime'] ?></td>
                            <td><?= $enrollment['actiondate'] ?></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>