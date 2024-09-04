<?php session_start(); ?>
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
  include("adminnav.php");
  include("../../php/conn.php");
  if (!$_SESSION['role']) {
    // echo "<script>alert('You are not authorized to view this page')</script>";   
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
  }

  $sql = "SELECT * FROM applications";
  $result = mysqli_query($conn, $sql);
  ?>
  <!-- main content -->
  <div class="main">
    <h1>Active Application</h1>
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
      <table>
        <tr>
          <th>Application ID</th>

          <th>Student Name</th>
          <th>Course Name</th>
          <th>Date of Application</th>
          <th>Level of Study</th>
          <th>Student Type</th>
          <th>Study Mode</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) {
          $enrollid = $row['enrollments_id'];
          $sqlEnroll = "SELECT enrollments.*, CONCAT(students.first_name, ' ', COALESCE(students.middle_name, ''), ' ', students.last_name) AS studentName, courses.course_name 
          FROM enrollments INNER JOIN students ON enrollments.student_id = students.student_id INNER JOIN courses ON enrollments.course_id = courses.course_id where enrollment_id= '$enrollid'";
          $results = mysqli_query($conn, $sqlEnroll);
          $enrollment = mysqli_fetch_assoc($results); ?>
          <tr>
            <td><?php echo $row['application_id']; ?></td>
            <td><?php echo $enrollment['studentName']; ?></td>
            <td><?php echo $enrollment['course_name']; ?></td>
            <td><?php echo $enrollment['enrollment_date']; ?></td>
            <td><?php echo $row['level_of_study']; ?></td>
            <td><?php echo $row['student_type']; ?></td>
            <td><?php echo $row['study_mode']; ?></td>
          </tr>
        <?php } ?>
      </table>
    <?php
    } else {
      echo "No records found.";
    }
    ?>
  </div>
</body>

</html>