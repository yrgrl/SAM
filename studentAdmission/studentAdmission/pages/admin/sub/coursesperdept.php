<?php session_start();
$dep_id = $_GET['dept_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../../css/admin.css" />
    <style>
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
    // session_start();
    if (!$_SESSION['role']) {

        header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
    }

    include("adminnav.php");
    include("../../../php/conn.php");
    $sql = "SELECT courses.*, departments.name AS department_name
    FROM courses JOIN departments ON courses.department_id = departments.id  where courses.department_id= $dep_id;";
    $results = mysqli_query($conn, $sql);
    $enrollments = array();
    $depsql = "SELECT departments.name AS department_name FROM departments where id= $dep_id";
    $deptData = mysqli_query($conn, $depsql);
    if (mysqli_num_rows($deptData) > 0) {
        // Loop through the rows and add them to the enrollments array
        while ($row = mysqli_fetch_assoc($deptData)) {

            $deptName  = $row['department_name'];
        }
    }
    // Check if any rows were returned
    if (mysqli_num_rows($results) > 0) {
        // Loop through the rows and add them to the enrollments array
        while ($row = mysqli_fetch_assoc($results)) {
            $enrollments[] = $row;
            $courseData = $enrollments[0];
            $deptName  = $courseData['department_name'];
        }
    }
    ?>
    <!-- main content -->
    <div class="main">
        <h1>Programs from <?= $deptName ?> Department</h1>
        <table>
            <thead>
                <tr>
                    <th>Program ID</th>
                    <th>Program Name</th>
                    <th>Description</th>
                    <th>Program price</th>
                    <th>Department</th>
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
                            <td><?= $enrollment['course_id'] ?></td>
                            <td><?= $enrollment['course_name'] ?></td>
                            <td><?= $enrollment['course_description'] ?></td>
                            <td><?= $enrollment['course_price'] ?></td>
                            <td><?= $enrollment['department_name'] ?></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>