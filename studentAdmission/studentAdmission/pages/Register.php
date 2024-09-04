<!DOCTYPE html>
<!--declares document type as HTML5-->
<!--HTML5 standard is the latest version of HTML-->
<html>
<!--marks beginning of HTML document-->

<head>
  <!--contains metadata for the document such as title, character encoding, css styles etc..-->
  <!--metadata is data that provides additional information about other data, included in the head tag in a html document-->
  <title>Registration Form</title>
  <!--tag to set the title of the web page as "Registration Form"-->
  <style>
    /*tag used to embed/include CSS code directly within an HTML document*/
    /*CSS stands for Cascading Style Sheets*/
    body {
      /*contains various CSS properties and their corresponding values for application in the body element*/
      background-color: #0b0544;
      /*sets background color of an HTML element to a specified color using the code*/
      font-family: Arial, sans-serif;
      /*used to specify the font family for text content within an HTML element*/
      /*Arial is the preffered font family to be used and incase it is not available, sans-serif is used as the generic font family/alternative*/
    }

    /*marks end of body element*/

    .registration-box {
      /*class selector rule that targets HTML elements with the class attribute set to "registration-box."*/
      /* A CSS class selector is used to target and apply styles to HTML elements that have a specific class attribute*/
      background-color: #fff;
      /*Sets the background color of the .registration-box container to white (#fff)*/
      border-radius: 10px;
      /*border-radius is a CSS property that allows you to control the curvature of an element's corners*/
      /*this line of code is used to round the corners of the .registration-box container, creating a smooth, slightly curved appearance with a border radius of 10 pixels*/
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      /*takes 4 values: horizontal offset(0), vertical offset(0), blur radius(10px), & shadow color(rgba(0, 0, 0, 0.3))*/
      /*Adds a subtle box shadow to the .registration-box container.*/
      margin: 100px auto;
      /*centers container of the page by pushing it 100px down from the top and  centers it horizontally by setting the left and right margins to auto*
      padding: 20px;
      /*a padding creates space btwn the content inside the container and its edges*/
      /*this line adds 20px of padding to all 4 sides of the container*/
      max-width: 600px;
      /*sets the maximum width an element can have*/
      /*element is set not to exceed a width of 600px*/
    }

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
      /*set to 10px ie applies a margin of 10px to the top of all <label> elements on the web page*/
      /*The margin creates visual separation, making the form elements more readable and enhancing the overall design.*/
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      /*declaring and styling the text, email and password input fields*/
      padding: 10px;
      /*adds 10px padding between the input field and its edge*/
      /*a padding creates space btwn the content inside the container and its edges*/
      border-radius: 5px;
      /*border-radius controls the curvature of an element's corners*/
      /*this line of code rounds the corners of the 3 input fields by 5px border radius making it smooth and appear slightly curved*/
      border: 1px solid;
      /*apply a 1px solid border around the input fields*/
      margin-bottom: 20px;
      /*adds 20px of space below each input field*/
    }

    /*end of text, email and password input fields styling*/

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
    }

    /*marks end of button styling*/

    input[type="submit"]:hover {
      /*styling for the submit button when hovered over*/
      background-color: #3e8e41;
      /*sets background color to a different one when hovering over the button*/
    }

    /*end of hover styling*/
  </style>
  <!--end of registration page styling-->

</head>
<!--end of head element-->

<body>
  <!--contains registration info/form-->
  <div class="registration-box">
    <!--HTML element with the CSS class "registration-box" assigned to it-->
    <h1>CUEA Online Admission</h1>
    <!--contains the main heading/heading1 of the webpage-->
    <div style="text-align: center;">
      <!--justifies the heading/text to be at the centre of the web page-->
      <img src="../imgs/logo.png" style="display: block; margin: 0 auto;">
      <!--contains the path to the image source that contains the logo used-->
    </div>

    <h1>Register</h1>
    <!--sets heading 1/main heading of the webpage to Register-->
    <form action="../php/register.php" onsubmit="return validateRegister();" method="POST">
      <!--The form element starts with an "action" attribute that points to the PHP file responsible for processing the form data(../php/register.php)-->
      <!--The "onsubmit" attribute calls the JS function "validateRegister()" to perform client-side validation before submitting the form-->
      <!--The "method" attribute is set to "POST" to send the form data securely-->

      <!--label-input pairs used to capture users information-->
      <label for="fname">First Name:</label>
      <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label First Name helps us know we expect a users first name in corresponding the input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="fname"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie First Name in this case-->
      <input type="text" id="first_name" name="firstName">
      <!--<input> is an element used to create various types of form controls, eg text fields, checkboxes, radio buttons, etc
      in this case, it creates a text field-->
      <!--type="text":sets the input type to "text," meaning it's a single-line text input field where users can enter text.-->
      <!--The id attribute provides a unique identifier for the input element being first_name in this case-->
      <!--The name attribute is used to specify the name of the input field which is firstName here.
       When the form is submitted, the name-value pair of this input field will be sent to the server-->
      <label for="middleName">Middle Name:</label>
      <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label Middle Name helps us know we expect a users middle name in the corresponding input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="middleName"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie Middle Name in this case-->
      <input type="text" id="middle_name" name="middleName">
      <!--<input> is an element used to create various types of form controls, eg text fields, checkboxes, radio buttons, etc
      in this case, it creates a text field-->
      <!--type="text":sets the input type to "text," meaning it's a single-line text input field where users can enter text.-->
      <!--The id attribute provides a unique identifier for the input element being middle_name in this case-->
      <!--The name attribute is used to specify the name of the input field which is middleName here.
       When the form is submitted, the name-value pair of this input field will be sent to the server-->
      <label for="lastName">Last Name:</label>
      <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label Last Name helps us know we expect a users last name in the corresponding input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="lastName"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie Last Name in this case-->
      <input type="text" id="last_name" name="lastName">
      <!--<input> is an element used to create various types of form controls, eg text fields, checkboxes, radio buttons, etc
      in this case, it creates a text field-->
      <!--type="text":sets the input type to "text," meaning it's a single-line text input field where users can enter text.-->
      <!--The id attribute provides a unique identifier for the input element being last_name in this case-->
      <!--The name attribute is used to specify the name of the input field which is lastName here.
       When the form is submitted, the name-value pair of this input field will be sent to the server-->
      <label for="email">Email:</label>
      <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label Email helps us know we expect a users email address in the corresponding input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="email"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie Email in this case-->
      <input type="text" id="email" name="email">
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
          In this case, the Label Password helps us know we expect a users password in corresponding the input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="Password"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie Password in this case-->
      <input type="password" id="password" name="password">
      <!--<input> is an element used to create various types of form controls.-->
      <!--type="password": The type attribute specifies the type of input field to be created. 
        In this case, it's set to "password," which creates a password input field.-->
      <!--id="password": The id attribute provides a unique identifier for the input field.-->
      <!--name="password": The name attribute is used to specify the name of the input field which is password in this case.
         When the form is submitted, the name-value pair of this input field will be sent to the server-->
      <label for="confirm-password">Confirm Password:</label>
      <!--The <label> element is used to associate a label with an input element.
           It provides a textual description for the input field, 
           making it easier for users to understand what information is expected in the field.
          In this case, the Label Confirm Password helps us know we expect the user to reenter their password for confirmation in the corresponding input field-->
      <!--for attribute in the <label> element is used to specify the id of the associated input element.
             In this case, it is for="confirm-password"-->
      <!--the label is what the user will see on their end to guide them on what to insert in the input field ie Confirm Password in this case-->
      <input type="password" id="confirm_password" name="confirm-password">
      <!--<input> ia an element used to create various types of form controls.-->
      <!--type="password": The type attribute specifies the type of input field to be created. 
        In this case, it's set to "password," which creates a password input field.-->
      <!--id="confirm_password": The id attribute provides a unique identifier for the input field.-->
      <!--name="confirm-password": The name attribute is used to specify the name of the input field ie confirm-password in this case.
         When the form is submitted, the name-value pair of this input field will be sent to the server-->
      <input type="submit" name="submit" value="Register">
      <!--<input> is an element used to create various types of form controls.-->
      <!--type="submit": The type attribute specifies the type of input field to be created.
         In this case, it's set to "submit," which creates a submit button.-->
      <!--name="submit": The name attribute is used to specify the name of the input field.
          When the form is submitted, the name-value pair of this input field will be sent to the server.
           In this case, it will be used as the key to identify the submit button when processing the form data on the server side.-->
      <!--The value attribute sets the text displayed on the submit button.
            In this case, it is "Register" which is the visible text on the button.-->
      <p>Already have an account <a href="./login.php">Login</a></p>
      <!--The <p> element is used to create a paragraph of text.-->
      <!--"Already have an account": This is the text that will be displayed in the paragraph.-->
      <!--<a> is an anchor  element that creates a hyperlink to a specified URL-->
      <!--When users click on the specified link, they will be taken to the "Login" page in this case.-->
      <!--</p>tag to close the paragraph and </a> is the tag to close the anchor-->
    </form>
    <!--marks end of the form element-->
  </div>
  <!--closes the div element-->
  <script>
    /*marks start of the js validation script*/
    function validateRegister() {
      //JS function named called when the registration form is submitted for validation.
      var firstName = document.getElementById("first_name").value;
      // Retrieves the value entered in the "first_name" input field and stores it in the variable "firstName".
      var lastName = document.getElementById("last_name").value;
      // Retrieves the value entered in the "last_name" input field and stores it in the variable "lastName".
      var email = document.getElementById("email").value;
      // Retrieves the value entered in the "email" input field and stores it in the variable "email".
      var password = document.getElementById("password").value;
      // Retrieves the value entered in the "password" input field and stores it in the variable "password".
      var confirmPassword = document.getElementById("confirm_password").value;
      // Retrieves the value entered in the "confirm_password" input field and stores it in the variable "confirmPassword".

      if (firstName == "") {
        // Checks if the "firstName" variable is empty (i.e., the first name is not entered by the user).
        alert("Please enter your first name");
        // If the first name is empty, display an alert with the message "Please enter your first name".
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }
      if (lastName == "") {
        // Checks if the "lastName" variable is empty (i.e., the last name is not entered by the user).
        alert("Last name cannot be blank");
        // If the last name is empty, display an alert with the message "Last name cannot be blank".
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }
      if (email == "") {
        // Checks if the "email" variable is empty (i.e., the email is not entered by the user).
        alert("Please enter your email");
        // If the email is empty, display an alert with the message "Email Address cannot be blank".
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }
      if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
        // Checks if the "email" variable is empty or if it does not contain the '@' symbol or a dot ('.') character.
        alert("Please enter a valid email address.");
        // If the email is empty or does not have the correct format, display an alert with the message "Please enter a valid email address."
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }

      if (password == "") {
        // Checks if the "password" variable is empty (i.e., the password is not entered by the user)
        alert("Please enter your password");
        // If the password is empty, display an alert with the message "Please enter your password"
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }
      if (!isPasswordValid(password)) {
        alert("Password must have at least one number, one uppercase letter, and one symbol.");
        return false;
      }
      if (password != confirmPassword) {
        // Checks if the "password" variable is not equal to the "confirmPassword" variable, indicating that the passwords do not match.
        alert("Passwords do not match.");
        // If the passwords do not match, display an alert with the message "Passwords do not match."
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.

      }

    }

    function isPasswordValid(password) {
      // nested function named to check the password complexity.
      // a nested function is a function defined within another function
      if (!/\d/.test(password) || !/[A-Z]/.test(password) || !/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(password) || password.length < 8) {
        // checks If the password does not contain a digit,an uppercase letter,a symbol and is less than 8 characters long
        alert("Password must have at least one number, one uppercase letter, and one symbol.");
        //if the conditions are not met an alert message is displayed saying "Password must have at least one number, one uppercase letter, and one symbol."
        return false;
        // Return false to prevent the form submission, as the required field is not filled out.
      }
      return true;
      // If all complexity requirements are met, return true to indicate that the password is valid.
    }
  </script>
</body>

</html>