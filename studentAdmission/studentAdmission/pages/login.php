<?php
//opening tag used to indicate the beginning of a PHP code in a PHP file.
session_start();
//function used to create a session or resume an existing session
//a session is what stores the data and all requests made by a user in a website
include('../php/conn.php');

if (isset($_SESSION['user'])) { 
  // checks if the $_SESSION['user'] variable is set, indicating that the user is already logged in
  //$_SESSION is a superglobal array in PHP that is used to store and manage session data across multiple pages of a web application
  header("Location: ../index.php"); 
  //function that redirects logged in user to the index page
}

//login code
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //REQUEST_METHOD is a PHP predefined variable that holds the request method used to access the current script.
  //checks whether the current HTTP request method is 'POST' 
  //$_SERVER is a PHP superglobal array that provides information about the server environment and the current request.
  //The 'GET' method appends form data to the URL, while the 'POST' method sends the data in the request body.
  //$_POST is a PHP superglobal array that is used to retrieve data that has been sent to the server using the HTTP POST method
  $email = htmlspecialchars($_POST['email']);
  //used to sanitize & protect against cross-site scripting (XSS) attacks when handling form data submitted via the POST method
  //htmlspecialchars() function is a PHP function used to convert special characters to their corresponding HTML entities.
  //the sanitized value is assigned to the variable email
  $password = htmlspecialchars($_POST['password']);
  //used to sanitize & protect against cross-site scripting (XSS) attacks when handling form data submitted via the POST method
  //htmlspecialchars() function is a PHP function used to convert special characters to their corresponding HTML entities.
  //the sanitized value is assigned to the variable password

  $stmt = $conn->prepare("SELECT * FROM students WHERE email=?");
  //$stmt is a declared variable that holds the db connection and an SQL statement
  //$conn holds the db connection object
  //prepare() method is used on the db connection object to create a prepared statement used to execute SQL queries with placeholders for dynamic values
  $stmt->bind_param("s", $email);
  //binds the value of the email variable to the prepared statement
  //"s" specifies data type of emai as string and $email contains the actual value that will replace the placeholder in the prepared statement.
  $stmt->execute();
  //method used to execute the prepared statement
  $result = $stmt->get_result();
  //method used to obtain the result set from a prepared statement after executing it

  if ($result->num_rows == 1) {
    //checks if email is available and valid/has been fetched
    $row = $result->fetch_assoc();
    //used to fetch a single row from the result set obtained after executing a prepared statement with get_result()

    if (password_verify($password, $row['password'])) {
      // Check if the provided password matches the hashed password stored in the database
      //password_verify() function is used for password verification ie confirming if it matches the stored password.
      //the function compares the provided plain text password with the hashed password
      // If the verification is successful, the user is considered authenticated.
      $_SESSION['user'] = $row['student_id'];
      //sets user variable in the session to store the 'student_id' information
      $_SESSION['email'] = $row['email'];
      //sets email variable in the session to store the 'email' information
      $_SESSION['username'] = $row['first_name'];
      //sets username variable in the session to store the 'username' information
      $user = $_SESSION['user'];
      // Gets the user ID/information stored in the user session and stores it in a variable called $user
      $success_message = "Successful login";
      //declares a variable called success_message that contains/stores the message "Successful message"
      
      //record action on logs table
      $sql = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable,user_role) 
        VALUES ('login','$user',CURDATE(), CURTIME(),'Authentication','students','student')";
        //$sql is a variable that holds the sql statement to be used to insert info in the logs table
        //data inserted into the logs table is for record keeping
      mysqli_query($conn, $sql);
      //function used to execute the connection query that establishes a connection to the db 
      //and execute the sql statement in the $sql variable to populate the logs table with the action
      header("Location: ../index.php?success_message=" . urlencode($success_message));
      //redirects the user to the index page if the log is successful
      //.(dot) is used to concatenate
      //urlencode() function is used to execute/print the message stored in the $success_message variable as it redirects.
      exit();
    } else {
      //condition to be followed if the preceeding if statement is false is the password doesnt match the stored password
      $error_message = "Invalid password";
      //the error message to be printed if the password does not match
      //$error_message is the variable that stores the output for unsuccessful log in which is "Invalid password"
    }
  } else {
    //condition to be followed if the preceeding if statement is false is the email doesnt match the stored email
    $error_message = "Invalid email";
    header("Location: ./login.php?error_message=" . urlencode("Invalid email or password"));
    //the error message to be printed if the email values do not match
    //$error_message is the variable that stores the output for unsuccessful log in which is "Invalid email"
  }

  // error_log("Login error: " . $error_message);
  //error_log is the function that records the log in error message in the server's error log
  //getting to this point means the login has been unsuccessful either due to wrong email or password
  // header("Location: ./login.php?error_message=" . urlencode("Invalid email or password"));
  //redirects the user the login page with an erroe message in the urlencode() function
  exit();
}
/*include is a php construct used to import the contents of another file to the current PHP script to allow code reuse.*/
/*the content in the () specifies the path to the file one wants to include in this case it is the conn.php file*/

?>
<!--closing tag in PHP used to indicate the end of the PHP code block-->

<!--declares document type as HTML5-->
<!--HTML5 standard is the latest version of HTML-->

<!--marks beginning of HTML document-->

<head>
  <!--contains metadata for the document such as title, character encoding, css styles etc..-->
  <!--metadata is data that provides additional information about other data, included in the head tag in a html document-->
  <meta charset="UTF-8" />
  <!--metadata that specifies the character encoding for the document to be UTF-8-->
  <!--Character encoding is a system that assigns numerical representations (code points) to characters
   in a character set, allowing computers to represent and process human-readable text using binary data-->
  <!--UTF-8 represents virtually all characters from all the world's writing systems-->
  <title>Login Page</title>
  <!--tag to set the title of the web page as "Login Page"-->
  <style>
    /*tag used to embed/include CSS code directly within an HTML document*/
    /*CSS stands for Cascading Style Sheets*/
    body {
      /*contains various CSS properties and their corresponding values for application in the body element*/
      background-color: #0b0544;
      /*sets background color of an HTML element to a specified color eg this sets it to dark blue*/
      font-family: Arial, sans-serif;
      /*used to specify the font family for text content within an HTML element*/
      /*Arial is the preffered font family to be used and incase it is not available, sans-serif is used as the generic font family/alternative*/
    }
    /*marks end of body element*/

    .login-box {
      /*class selector rule that targets HTML elements with the class attribute set to "login-box."*/
      /* A CSS class selector is used to target and apply styles to HTML elements that have a specific class attribute*/
      background-color: #fff;
      /*Sets the background color of the .login-box container to white (#fff)*/
      border-radius: 10px;
      /*border-radius is a CSS property that allows you to control the curvature of an element's corners*/
      /*this line of code is used to round the corners of the .login-box container, creating a smooth, slightly curved appearance with a border radius of 10 pixels*/
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      /*takes 4 values: horizontal offset(0), vertical offset(0), blur radius(10px), & shadow color(rgba(0, 0, 0, 0.3))*/
      /*Adds a subtle box shadow to the .login-box container.*/
      margin: 100px auto;
      /*centers container of the page by pushing it 100px down from the top and  centers it horizontally by setting the left and right margins to auto*/
      padding: 20px;
      /*a padding creates space btwn the content inside the container and its edges*/
      /*this line adds 20px of padding to all 4 sides of the container*/
      max-width: 600px;
      /*sets the maximum width an element can have*/
      /*element is set not to exceed a width of 600px*/
    }
    /*marks end of login-box container style sheet*/

    h1 {
      /*indicates heading1/main heading*/
      text-align: center;
      /*used to horizontally center the text inside <h1> elements on the web page*/
      /*text-align property is commonly used to control the alignment of text within an element*/
      /*setting the property to center aligns it at the center of its container*/
    }
    /*marks end of h1 styles*/

    /*code that applies a flexbox layout for the form element for its child elements to be verically arranged*/
    form {
      /*element containing child elements*/
      display: flex;
      /*activates flexbox layout on the elent and its child elements that allows alignment control, distribution & order of the child elements within the container*/
      flex-direction: column;
      /*sets main axis of the flex container to be vertical*/
    }
    /*end of form container*/


    label {
      margin-top: 10px;
      /*margin-top property adds space between the top edge of the <label> element and the preceding content or element*/
      /*set to 10px ie applies a margin of 10 pixels to the top of all <label> elements on the web page*/
      /*The margin creates visual separation, making the form elements more readable and enhancing the overall design.*/
    }

    input[type="text"],
    input[type="password"] {
      /*declaring the text and password input fields to be styled*/
      padding: 10px;
      /*adds 10px padding between the input field and its edge*/
      /*a padding creates space btwn the content inside the container and its edges*/
      border-radius: 5px;
      /*border-radius controls the curvature of an element's corners*/
      /*this line of code rounds the corners of the 2 input fields by 5px border radius making it smooth and appear slightly curved*/
      border: 1px solid;
      /*apply a 1px solid border around the input fields*/ 
      margin-bottom: 20px;
      /*add 20px of space below each input field*/
    }
    /*end of text and password input fields styling*/

    input[type="submit"] {
      /*declaring and styling the submit button*/
      background-color: #0b0544;
       /*sets the background color of the submit button to a dark blue (#0b0544)*/
      color: #fff;
      /*sets the text color of the button to white (#fff)*/
      padding: 10px;
      /*sets distance between submit and the edge of the button to 10px/adds 10px of padding around the submit button*/
      border-radius: 5px;
      /*creates slightly rounded corners with a 5px border radius*/
      border: none;
      /*removes the default border of the button*/
      cursor: pointer;
      /*change the mouse cursor to a pointer when hovering over the button*/
      font-weight: bold;
      /*sets the font weight of the button text to bold*/
      max-width: 60px;
      /*limits the maximum width of the button to 60 pixels*/
    }
    /*marks end of button styling*/

    input[type="submit"]:hover {
      /*styling for the submit button when hovered over*/

      background-color: #925a1b;
      /*sets bacground color to a dark orange (#925a1b) when hovering over the button*/
    }
    /*end of hover styling*/
  </style>
  <!--end of login page styling-->

  <script>
    //marks start of a JS code to check for error/success messages
    <?php if (isset($_GET['error_message'])) : ?>
      //conditional statement that uses GET to check for 'error message' parameter in the URL. if present, the code in the block is executed.
      //isset is a function that checks if a variable is set/exists and is not null
      //$_GET superglobal variable is an array that holds the values of the URL parameters passed to the current script via the HTTP GET method
      
      var success_message = "<?php echo $_GET['error_message']; ?>";
      //contains the output that will be printed if the preceding line of code is true.
      //the output is the value of the 'error message' variable that will be stored in the JS variable 'success_message'.
      alert(success_message);
      //dialog pops up that displays value of 'success_message' which is 'Invalid password'/'Invalid email'
    <?php endif; ?>
    //closes a conditional block of statement that was opened using the 'if' statement
    <?php if (isset($_GET['success_message'])) : ?>
      //checks if the URL string contains 'success message' parameter. if so, the code block is executed
      var success_message = "<?php echo $_GET['success_message']; ?>";
      //contains output to be printed out if the condition is true. 
      //output is the value of the 'success_message' variable which is stored in the 'success_message' JS variable 
      alert(success_message);
      //dialog pop up displaing the value of "success message' ie "Sucessful Login"
    <?php endif; ?>
    //closes the if cconditional statements
  </script>
  <!--marks end of JS code-->
</head>
<!--closes the head tag-->

<body>
  <!--contains php code that checks if user is logged in-->
  <?php
  //start of php code
 
  
  if (isset($errors) && !empty($errors)) { ?> 
  <!--checks if the $errors variable is set and not empty/null -->
  <!--isset() function checks if the variable exists, and the !empty() function checks if it contains any data-->
  <!-- If there are validation errors stored in the $errors variable, the code inside this block will be executed-->
    <div style="color: red">
    <!-- If there are errors, create a <div> element with red text color to display the error messages. -->
      <?php foreach ($errors as $error) { ?>
        <!--foreach loop iterates through the $errors array. It assigns each value (error message) from the $errors array to the variable $error in each iteration.-->
        <p><?php echo $error; ?></p>
        <!--echo statement is used to output the error message on the page.-->
        <!--Display each error message inside a <p> element-->
          <!--Inside the loop, each error message stored in the $error variable is displayed within a <p> element-->


    <?php }
    } ?>
    </div>
    <div class="login-box">
      <h1>CUEA Online Admission</h1>
      <!--sets the main heading/heading1 to CUEA Online Admission-->
      <div style="text-align: center">
      <!--sets the justification/alignment of the text to the center of the container-->
        <img src="../imgs/logo.png" style="display: block; margin: 0 auto" />
        <!--defines the path where the logo used in the webpage is stored/the source-->
        <!--contains the style used for the logo-->
      </div>
      <h1>Login</h1>
      <!--tag to set the heading of the webpage as Login-->
      <form action="" onsubmit="return validateForm();" method="POST">
      <!--The action="" attribute in the form element is empty,
       which means the form will submit data to the same URL it is currently on. 
       This is known as a "self-submitting" form-->
       <!--onsubmit="return validateForm(); function will be executed when the form is submitted,
        and if it returns false, the form submission will be prevented-->
        <!--method="POST" specifies the HTTP method that will be used when the form is submitted to the server-->
        <label for="email">Email</label>
        <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field. 
           In this case, the Label Email hekps us know we expect an email in the corresponding input field-->
           <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="email"-->
        <input type="text" id="email" name="email" />
        <!--<input> is an element used to create various types of form controls, eg text fields, checkboxes, radio buttons, etc
      in this case, it creates a text field-->
      <!--type="text":sets the input type to "text," meaning it's a single-line text input field where users can enter text.-->
      <!--The id attribute provides a unique identifier for the input element being email in this case-->
      <!--The name attribute is used to specify the name of the input field which is email here.
       When the form is submitted, the name-value pair of this input field will be sent to the server-->
        <label for="password">Password:</label>
        <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label Password hekps us know we expect a password in corresponding the input field-->
           <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="email"-->
        <input type="password" id="password" name="password" />
        <!--<input> ia an element used to create various types of form controls.-->
        <!--type="password": The type attribute specifies the type of input field to be created. 
        In this case, it's set to "password," which creates a password input field.-->
        <!--id="password": The id attribute provides a unique identifier for the input field.-->
        <!--name="password": The name attribute is used to specify the name of the input field which is password in this case.
         When the form is submitted, the name-value pair of this input field will be sent to the server-->
        <input type="submit" name="submit" value="submit" />
        <!--<input> is an element used to create various types of form controls.-->
        <!--type="submit": The type attribute specifies the type of input field to be created.
         In this case, it's set to "submit," which creates a submit button.-->
         <!--name="submit": The name attribute is used to specify the name of the input field.
          When the form is submitted, the name-value pair of this input field will be sent to the server.
           In this case, it will be used as the key to identify the submit button when processing the form data on the server side.-->
           <!--The value attribute sets the text displayed on the submit button.
            In this case, it is "submit," which is the visible text on the button.-->
        <p>New user <a href="../pages/Register.php">Register</a></p>
        <!--The <p> element is used to create a paragraph of text.-->
          <!--"New user": This is the text that will be displayed in the paragraph.-->
          <!--<a> is an anchor  element that creates a hyperlink to a specified URL-->
          <!--When users click on the specified link, they will be taken to the "Register" page in this case.-->
          <!--</p>tag to close the paragraph and </a> is the tag to close the anchor-->
        <p><a href="../pages/admin/adminlogin.php">Admin login</a></p>
        <!--The <p> element is used to define a paragraph of text-->
          <!--<a href="../pages/admin/adminlogin.php">Admin login</a>: 
          This is a hyperlink (<a> element) with an href attribute set to "../pages/admin/adminlogin.php".
             When users click on the link, they will be redirected to the "adminlogin.php" page, which is located in the "admin" directory inside the "pages" directory.-->
             <!--The ".." in the href attribute represents going up one level in the directory structure, so the link points to a page inside the "admin" subdirectory.-->
             <!--Admin login": This is the text that appears as the visible link to users. 
             In this case, it says "Admin login," indicating that clicking on the link will take users to the admin login page.-->
             <!--</p>tag to close the paragraph and </a> is the tag to close the anchor-->
        <p>Forgot password <a href="../pages/resetpass.php">Reset</a></p>
        <!--code representing a hyperlink to the "Forgot password" page for password reset-->
        <!--<p> element is used to define a paragraph of text.-->
          <!--Forgot password":regular text that appears as part of the paragraph.
           It informs the user about the purpose of the link, which is to recover or reset a forgotten password-->
           <!--<a href="../pages/resetpass.php">Reset</a>:hyperlink (<a> element) with an href attribute set to "../pages/resetpass.php".
             When users click on the link, they will be redirected to the "resetpass.php" page, which is located in the "pages" directory-->
             <!--The ".." in the href attribute represents going up one level in the directory structure, so the link points to a page inside the "pages" directory.-->
             <!--Reset is the text that appears as the visible link to users indicating that clicking on the link will take users to the password reset page.-->
             <!--</p>tag to close the paragraph and </a> is the tag to close the anchor-->

      </form>
    </div>
    <!-- validation javascript -->
    <script>
      function validateForm() {
        //used to set criteria that certain variables should meet in a form
        //this sets for the email and password
        var email = document.getElementById("email").value;
        //declares email variable to store values retrieved from email element by Id
        var password = document.getElementById("password").value;
        //declares password variable to store values retrieved from password element by Id
        if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
          //checks if the email is empty, does not contain the @ and . symbol 
          alert("Please enter a valid email address.");
          //alert pops up to ask the user to insert their valid email address if it checks any condition in the above statement
          return false;
        }


        if (password == "") {
          //check whether the password variable is an empty string
          alert("Please enter a password.");
          //pops an alert prompting the user to enter their password if no password is entered
          return false;
        }
      }
    </script>
    <!--tag to mark end of the JS script-->
</body>
<!--tag to close the body element-->

<!--tag to mark end of html document-->
</html>
