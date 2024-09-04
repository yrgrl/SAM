 <!DOCTYPE html>
 <!--declares the document type as HTML5-->
<html>
    <!--marks the beginning of the HTML document-->

<head>
    <!--contains the metadata information for the document such as the tile, css styles, character encoding etc-->
    <!--metadata is the additional information/data about other data in the head tag-->
    <title>Students department</title>
    <!--sets the title of the web page to be Students department--> 

    <style>
        /*html tag that contains the css code/style sheets*/
        table {
            /* CSS selector that targets all <table> elements in the HTML document*/
            /*A CSS Selector is a pattern used to select and style HTML elements in a web page. 
            allows you to target specific elements or groups of elements in the HTML document and apply styles to them*/
            border-collapse: collapse;
            /*border-collapse property controls how table borders are collapsed or separated*/
            /*setting it to 'collapse' merges the borders of adjacent table cells into a single border removing any space between the cells*/
            width: 100%;
            /*width property sets the width of an element to occupy a certain percentage of its containing element's width*/
            /*in this case the width of the table element is set to 100% meaning it stretches horizoontally to occupy the total available width*/
            font-family: Arial, sans-serif;
            /*used to specify the font family for text content within an HTML element*/
            /*Arial is the preffered font family to be used and incase it is not available, sans-serif is used as the generic font family/alternative*/
            font-size: 14px;
            /*sets the size of the text to 14 pixels*/
            text-align: left;
            /*used to justify the text on the h1 element to the left side of the webpage*/
            /*text-align property is commonly used to control the alignment of text within an element*/
            /*setting the property to left aligns it at the left side of its container*/
        }

        th,
        /*table header styles*/
        td {
            /*table data styles*/
            padding: 8px;
            /*a padding creates space btwn the content inside the container and its edges*/
            /*this line adds 8px of padding to all 4 sides of the container*/
            border: 1px solid #ddd;
            /*apply a 1px solid border around each table cell with the color #ddd (a shade of gray)*/ 
        }

        th {
            /*table header style*/
            background-color: #f2f2f2;
            /*Sets the background color of the table header cells to a color with the code #f2f2f2)*/
            color: #333;
            /*sets the text color of the table headers to a dark gray (#333)*/
            font-weight: bold;
            /*makes the text in the table headers bold in nature*/
        }

        tr:hover {
            /*This part targets the table row elements in the table when the user hovers over them/moves the cursor on them*/
            background-color: #f5f5f5;
            /*sets a slightly darker gray (#f5f5f5) background color for the table row when hovered*/
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

    // Check if the course form has been submitted
    if (isset($_POST['submit_course'])) {
        // Get the form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $department_id = $_POST['department_id'];

        // Insert the new course into the database
        $sql = "INSERT INTO courses (course_name, course_description, course_price, department_id) VALUES ('$name', '$description', '$price','$department_id')";
        //variable which holds the sql statement that contains the data to be added to the courses table in the db
        if (mysqli_query($conn, $sql)) {
            //mysqli_query is a function used to establish the connection to the db by executing $conn and executing the sql statement held in the $sql variable
            header("Location: courses.php");
            // If the course was successfully added, redirect to the courses page
            exit;
        } else {
            //contains the statement that will be executed if the other does not execute/is false ie if course is not created
        
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            // If an error occurred, display an error message. happens when the course is not created
        }
    }
    ?>
    <div class="main">

        <h1>Rejected Students</h1>
        <!--sets the heading for the webpage as Rejected Students-->
        <table>
            <thead>
                <!--table header-->
                <tr>
                    <!--table row-->
                    <th>Studnt ID</th>
                    <!--creates a column on the table with the header Studnt ID-->
                    <th>Studnt Name</th>
                    <!--creates a column on the table with the header Studnt Name-->
                    <th>Message</th>
                    <!--creates a table column withe the header Message-->
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve existing courses from the database
                $sql = "SELECT a.*,s.*, c.*, d.name AS department, f.name AS faculty
                FROM enrollments a                
                INNER JOIN courses c ON a.course_id = c.course_id
                /*INNER JOIN is a type of db operation used to combine rows from two or more tables based on a related column between them*/
                /*an alias is another name assigned to a column or a table temporarily to make reports nmore relevant to a user*/
                INNER JOIN departments d ON c.department_id = d.id
                INNER JOIN faculties f ON d.faculty_id = f.id
                INNER JOIN students s ON a.student_id = s.student_id
                where approved_status = 'Declined' OR where approved_status = 'Rejected'
                ";
                $result = mysqli_query($conn, $sql);
                // Loop through the result set and display each course as a table row
                //executes the sql statement and establishes the db connection
                while ($row = mysqli_fetch_assoc($result)) {
                    // course_id, course_name, course_description, course_price, department_id
                    echo '<tr>';
                    echo '<td>' . $row['student_id'] . '</td>';
                    echo '<td>' . $row['first_name'] . $row['last_name'] . '</td>';
                    echo '<td>' . $row['remarks'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>