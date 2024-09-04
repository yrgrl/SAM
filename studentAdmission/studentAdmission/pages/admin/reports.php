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
  </style>
</head>

<body>
  <?php
  include("adminnav.php");
  session_start();
  if (!$_SESSION['role']) {
    // echo "<script>alert('You are not authorized to view this page')</script>";   
    header("Location: ../../index.php?error_message=" . urlencode("You are not authorized to view this page"));
  }
  ?>

  <!-- main content -->
  <div class="main">
    <h1>System Reports</h1>
    <p>
      Summary
    </p>
  </div>
</body>

</html>