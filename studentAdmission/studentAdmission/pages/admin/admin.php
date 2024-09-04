<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin Panel</title>
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

    .card-container {
      display: flex;
      flex-wrap: wrap;
    }

    .card {
      width: calc(33.33% - 30px);
      margin: 10px;
      padding: 20px;
      box-sizing: border-box;
      background-color: #f2f2f2;
      border-radius: 10px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
    }

    .card h2 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 16px;
    }
  </style>
</head>

<body>
  <?php
  include("adminnav.php");
  include("../../php/conn.php");

  if (!$_SESSION['role']) {
    header("Location: ../../index.php?");
  }
  $sql = "SELECT COUNT(*) AS rejected_students_count
  FROM enrollments
  WHERE approved_status = 'Declined'";
  $results = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($results); // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //
  $accp = "SELECT COUNT(*) AS accepted_students_count
  FROM enrollments
  WHERE approved_status = 'Approved'";
  $resul = mysqli_query($conn, $accp);
  $accepted = mysqli_fetch_assoc($resul);  // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //all students
  $allstudents = "SELECT COUNT(*) AS all_students
  FROM enrollments where approved_status = 'Pending' ";
  $students = mysqli_query($conn, $allstudents);
  $all_students = mysqli_fetch_assoc($students);  // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //all stuff
  $allstaff = "SELECT COUNT(*) AS all_staff
  FROM staff";
  $staff = mysqli_query($conn, $allstaff);
  $allstaff = mysqli_fetch_assoc($staff);  // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //all courses
  $coursesCount = "SELECT COUNT(*) AS all_courses
  FROM courses";
  $allcourses = mysqli_query($conn, $coursesCount);
  $courses = mysqli_fetch_assoc($allcourses);  // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //all application
  $application = "SELECT COUNT(*) AS all_application
  FROM applications";
  $applications = mysqli_query($conn, $application);
  $appAll = mysqli_fetch_assoc($applications);  // mysqli_fetch_assoc is used to fetch a result row as an associative array
  //all application pending approval
  $pending = "SELECT COUNT(*) AS all_pending
  FROM enrollments
  WHERE approved_status = 'Pending'";
  $appPending = mysqli_query($conn, $pending);
  $appPendings = mysqli_fetch_assoc($appPending);
  ///
  $departments = "SELECT COUNT(*) AS all_departments
  FROM departments";
  $depart = mysqli_query($conn, $departments);
  $department = mysqli_fetch_assoc($depart);
  // count faculties 
  $fac = "SELECT COUNT(*) AS faculties
  FROM faculties";
  $facs = mysqli_query($conn, $fac);
  $faculties = mysqli_fetch_assoc($facs);
  // count enrolments 
  $enrollments = "SELECT COUNT(*) AS all_enrolments
  FROM enrollments";
  $enroll = mysqli_query($conn, $enrollments);
  $enrollments = mysqli_fetch_assoc($enroll);
  // count applications 
  $applications = "SELECT COUNT(*) AS all_applications
  FROM applications";
  $appli = mysqli_query($conn, $applications);
  $applications = mysqli_fetch_assoc($appli);
  //process application
  $processApplication = "SELECT COUNT(*) AS process
  FROM applications where status ='Pending' ";
  $appliProcess = mysqli_query($conn, $processApplication);
  $Pendingappli = mysqli_fetch_assoc($appliProcess);
  //approved application
  $approvedApplication = "SELECT COUNT(*) AS approved
  FROM applications where status ='Approved' ";
  $ApprovedApp = mysqli_query($conn, $approvedApplication);
  $approvedApp = mysqli_fetch_assoc($ApprovedApp);
  //rejected application
  $declinedApplication = "SELECT COUNT(*) AS declined
  FROM applications where status ='Rejected' or status ='Declined' ";
  $DeclineApp = mysqli_query($conn, $declinedApplication);
  $declindApp = mysqli_fetch_assoc($DeclineApp);



  ?>
  <div class="main">
    <h1>Summary</h1>
    <h4>Enrollments</h4>
    <div class="card-container">
      <!-- all enrolments  -->
      <div class="card">
        <h2>All Enrolments </h2>
        <h1><?= $enrollments['all_enrolments']; ?></h1>
      </div>
      <div class="card">
        <h2>Process </h2>
        <h1><?= $all_students['all_students']; ?></h1>
      </div>
      <div class="card">
        <h2>Approved </h2>
        <h1><?= $accepted['accepted_students_count']; ?></h1>
      </div>
      <div class="card">
        <h2>Rejected </h2>
        <h1><?= $row['rejected_students_count']; ?></h1>
      </div>

    </div>
    <h4>Applications</h4>
    <div class="card-container">
      <!-- all aplications  -->
      <div class="card">
        <h2>All applications</h2>
        <!-- change this after adding approvals in application db -->
        <h1><?= $applications['all_applications']; ?></h1>
      </div>
      <div class="card">
        <h2>Process </h2>
        <!-- change this after adding approvals in application db -->
        <h1><?= $Pendingappli['process']; ?></h1>
      </div>
      <div class="card">
        <h2>Approved </h2>
        <!-- add approved counter here  -->
        <h1><?= $approvedApp['approved']; ?></h1>
      </div>
      <div class="card">
        <h2>Rejected </h2>
        <!-- add rejected applictaion counter here  -->
        <h1><?= $declindApp['declined']; ?></h1>
      </div>
    </div>
    <h4>Faculties</h4>
    <div class="card-container">
      <a href="faculties.php" class="card" style="text-decoration: none;">
        <h2>All Faculties</h2>
        <h1><?= $faculties['faculties']; ?></h1>
      </a>
    </div>
    <h4>Members</h4>
    <div class="card-container">
      <a href="staff.php" class="card" style="text-decoration: none;">
        <h2>Board members</h2>
        <h1><?= $allstaff['all_staff']; ?></h1>
      </a>
    </div>
  </div>
</body>

</html>