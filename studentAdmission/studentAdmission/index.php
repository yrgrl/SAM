<!DOCTYPE html> 
<!-- declares document type as HTML -->
<html> 
    <!-- marks the beginning of the HTML document -->

<head> 
    <!-- marks the beginning of the head section -->
    <title>Home page</title> 
    <!-- sets the title of the webpage to Home page -->

    <meta charset="UTF-8"> 
    <!-- specifies the character encoding for the document -->
    <!-- character encoding is a method of converting bytes into characters-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The meta viewport sets the viewport properties for responsive web design -->

    <link rel="stylesheet" href="./css/index.css">
    <style>
        /*CSS styles*/

        /* CSS styles for the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: white;
            position: fixed;
            margin-left: -10px;
            top: 0;
            width: 100%;
            border-radius: 10px;
        }

        /* CSS styles for the links in the top navigation bar */
        .topnav a {
            float: right;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        /* CSS styles for the active link in the top navigation bar */
        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        /* CSS styles for the dropdown menu in the top navigation bar */
        .topnav .dropdown {
            float: right;
            overflow: hidden;
        }

        /* CSS styles for the dropdown button in the top navigation bar */
        .topnav .dropdown .dropbtn {
            font-size: 17px;
            border: none;
            outline: none;
            color: black;
            padding: 14px 16px;
            background-color: inherit;
            margin: 0;
        }

        /* CSS styles for the dropdown content in the top navigation bar */
        .topnav .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
        }

        /* CSS styles for the links in the dropdown content */
        .topnav .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        /* CSS styles for the hover effect on links in the dropdown content */
        .topnav .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* CSS styles to display the dropdown content on hover */
        .topnav .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <script>
        // Check if there's a success message in the URL and display it as a JavaScript alert
        <?php if (isset($_GET['success_message'])): ?>
            var success_message = "<?php echo $_GET['success_message']; ?>";
            alert(success_message);
        <?php endif; ?>
    </script>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: pages/login.php');
        exit;
    }
    ;
    $id = $_SESSION['user'];

    include('./php/conn.php');

    $sql = "SELECT * FROM progress WHERE student_id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $level = $row['progress_level'];
        $level_points = $row['progress_points'];
        $message = $row['message'];
    } else {
        $level = "enroll";
        $level_points = 0;
    }
    $sqlUser = "SELECT * FROM students WHERE student_id='$id'";
    $results = mysqli_query($conn, $sqlUser);
    if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);
        $userName = $row['first_name'];
        // echo $userName;
    }

    ?>
    <script>
        <?php if (isset($_GET['error_message'])): ?>
            var success_message = "<?php echo $_GET['error_message']; ?>";
            alert(success_message);
        <?php endif; ?>
    </script>
    <div class="topnav">
        <a href="php/logout.php?user=<?= $id ?>">Logout</a>
        <div class="dropdown">
            <button class="dropbtn">
                <?php echo $userName; ?>
            </button>
            <div class="dropdown-content">
                <a href="./pages/resetpass.php">Change Password</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>CUEA Online Admission</h1>
        <div style="text-align: center;">
            <img src="./imgs/logo.png" style="display: block; margin: 0 auto;">
        </div>
        <div class="page-content" style="text-align: center;">
            <h3>Welcome
                <?php echo $userName; ?>
            </h3>
            <h5>Your progress</h5>
            <div class="progress">
                <div class="bar" id="progress-bar"></div>
            </div>
            <div class="percentage" id="percentage"></div>
        </div>
        <?php
        if ($level === "enroll") {
            ?>
            <div style="align-content:center; margin-top: 50px;">
                <button class="btn-action" onclick="window.location.href='./pages/enroll.php'"
                    style="text-align: center;">Proceed to Enroll</button>
            </div>
            <?php
        } else if ($level === "application") {
            ?>
                <div style="align-content:center; margin-top: 50px; text-align: center;">
                    <p>
                    <?= $message ?>
                    </p>
                    <button class="btn-action" onclick="window.location.href='./pages/application.php'">Proceed to
                        Application</button>
                </div>
                <?php
        } else if ($level === "Final") {
            //check if student is available in the acceted student list to download admission letter
            $sql = "SELECT * FROM accepted_students WHERE student_id= '$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                ?>
                        <div style="align-content:center; margin-top: 50px; text-align: center;">
                            <p>
                            <?= $message ?>
                            </p>
                            <button class="btn-action" onclick="window.location.href='./pages/application-letter.php'">Proceed to
                                Download application letter</button>
                        </div>
                        <?php
            }
            ?>
                <div style="align-content:center; margin-top: 50px; text-align: center;">
                    <p>
                    <?= $message ?>
                    </p>
                </div>

                <?php
        } else if ($level === "declined") {
            ?>
                        <div style="align-content:center; margin-top: 50px; text-align: center;">
                            <p>
                            <?= $message ?>
                            </p>
                            <button class="btn-action">Your application has been rejected, try again next time</button>
                        </div>
                        <?php
        } else {
            ?>
                        <div style="align-content:center; margin-top: 50px; text-align: center;">
                            You have an exhisting enrollment awaiting approval, please be patient.
                            <button class="btn-action">Pending Approval</button>
                        </div>

                        <?php
        }
        ?>

    </div>
    <script>
        let progress = <?php echo $level_points; ?>; // Assign the value of the PHP variable '$level_points' to the JavaScript variable 'progress'.
        let progressBar = document.getElementById("progress-bar"); // Retrieve the HTML element with the id "progress-bar" and assign it to the JavaScript variable 'progressBar'.
        let percentage = document.getElementById("percentage"); // Retrieve the HTML element with the id "percentage" and assign it to the JavaScript variable 'percentage'.

        progressBar.style.width = progress + "%"; //adjusts visual with of the bar by setting the CSS 'width' property of the 'progressBar' element to the value of 'progress' followed by the "%" symbol.
        percentage.innerHTML = progress + "%"; //updates the displayed 'progress percentage' on the webpage.
    </script>
</body>

</html>