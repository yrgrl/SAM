<!DOCTYPE html>
<html>

<head>
    <title>Log</title>
</head>

<body>
    <div class="topnav">
        <a href="logout.php">Logout</a>
        <div class="dropdown">
            <button class="dropbtn"><?php echo $_SESSION['username']; ?></button>
            <div class="dropdown-content">
                <a href="#">Profile</a>
            </div>
        </div>
    </div>
    <h1>Welcome to my website!</h1>
    <p>This is the homepage of my website.</p>
</body>

</html>