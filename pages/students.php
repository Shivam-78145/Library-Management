<?php include "../config/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="header">Student Management</div>

<div class="container">
    <form method="post">
        <h2>Add Student</h2>

        <input name="name" placeholder="Student Name" required>
        <input name="course" placeholder="Course">
        <input name="department" placeholder="Department">
        <input name="contact" placeholder="Contact">

        <button name="save">Save Student</button>
    </form>

    <?php
    if(isset($_POST['save'])){
        mysqli_query($conn,"INSERT INTO students(name,course,department,contact)
        VALUES('$_POST[name]','$_POST[course]','$_POST[department]','$_POST[contact]')");
        echo "<div class='success'>Student Added Successfully</div>";
    }
    ?>

    <a class="back-link" href="../index.php">← Back to Dashboard</a>
</div>

</body>
</html>
