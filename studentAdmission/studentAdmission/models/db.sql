CREATE DATABASE online_enrollment;
USE online_enrollment;
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,    
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),   
    id_passport VARCHAR(20)  NULL,
    dob DATE  NULL,
    nationality VARCHAR(50)  NULL,
    gender VARCHAR(10)  NULL,
    marital_status VARCHAR(20)  NULL,
    religion VARCHAR(50)  NULL,
    password VARCHAR(100) NOT NULL,
    parent_first_name VARCHAR(50),
    parent_last_name VARCHAR(50),
    parent_email VARCHAR(100),
    parent_phone VARCHAR(20)
);
CREATE TABLE courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(100) NOT NULL,
    course_description VARCHAR(255),
    course_price DECIMAL(10,2) NOT NULL
);
CREATE TABLE enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATETIME TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_status VARCHAR(255) NULL,
    approved_by INT NULL,
    remarks VARCHAR(500) NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
    FOREIGN KEY (approved_by) REFERENCES staff(staff_id)
);
CREATE TABLE applications (
    application_id  INT PRIMARY KEY AUTO_INCREMENT,
    enrollments_id  INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),    
);
CREATE TABLE guardians (
    guardian_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20)
);
CREATE TABLE student_guardians (
    student_id INT NOT NULL,
    guardian_id INT NOT NULL,
    PRIMARY KEY (student_id, guardian_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (guardian_id) REFERENCES guardians(guardian_id)
);
CREATE TABLE staff (
    staff_id INT PRIMARY KEY AUTO_INCREMENT,    
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);
CREATE TABLE progress (
    progressid INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    progress_level  VARCHAR(50),
    progress_points INT NOT NULL,
    message VARCHAR(200)
);
CREATE TABLE student_qualifications (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT NOT NULL,
  qualification VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  institutions_attended VARCHAR(255) NULL,
  index_no VARCHAR(50) NULL,
  certificate_no VARCHAR(50) NULL,
  student_before TINYINT(1) NULL,
  FOREIGN KEY (student_id) REFERENCES students(student_id)
);
CREATE TABLE sponsor (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  address VARCHAR(200) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  FOREIGN KEY (student_id) REFERENCES students(student_id)
);
ALTER TABLE applications
ADD level_of_study VARCHAR(50) NOT NULL,
ADD student_type VARCHAR(50) NOT NULL,
ADD study_mode VARCHAR(50) NOT NULL;

CREATE TABLE faculties (
  id INT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE departments (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  faculty_id INT NOT NULL,
  FOREIGN KEY (faculty_id) REFERENCES faculties(id)
);
ALTER TABLE courses
ADD department_id INT NOT NULL,
ADD CONSTRAINT fk_course_department
FOREIGN KEY (department_id)
REFERENCES departments(id);

ALTER TABLE faculties ADD description VARCHAR(255) NOT NULL AFTER name;
ALTER TABLE applications ADD COLUMN status VARCHAR(10) DEFAULT 'Pending';
