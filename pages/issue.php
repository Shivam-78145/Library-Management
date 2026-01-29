<?php include "../config/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="header">📝 Issue Book</div>

<div class="container">

    <!-- Issue Book Form -->
    <form method="post">
        <h2>Issue Book</h2>

        <!-- Student Dropdown -->
        <label>Student</label>
        <select name="student_id" required>
            <option value="">Select Student</option>
            <?php
            $students = mysqli_query($conn,"SELECT id,name FROM students");
            while($s = mysqli_fetch_assoc($students)){
                echo "<option value='".$s['id']."'>".$s['name']." (ID: ".$s['id'].")</option>";
            }
            ?>
        </select>

        <!-- Book Dropdown (Only Books with available copies) -->
        <label>Book</label>
        <select name="book_id" required>
            <option value="">Select Book</option>
            <?php
            $books = mysqli_query($conn,"SELECT id,title,available_copies FROM books WHERE available_copies > 0");
            while($b = mysqli_fetch_assoc($books)){
                echo "<option value='".$b['id']."'>".$b['title']." (Available: ".$b['available_copies'].")</option>";
            }
            ?>
        </select>

        <!-- Issue Dates -->
        <label>Start Date</label>
        <input type="date" name="start" required>

        <label>End Date</label>
        <input type="date" name="end" required>

        <!-- Security Deposit -->
        <input type="number" name="deposit" placeholder="Security Deposit" required min="0">

        <!-- Submit Button -->
        <button name="issue">Issue Book</button>
    </form>

    <?php
    if(isset($_POST['issue'])){
        $student_id = $_POST['student_id'];
        $book_id = $_POST['book_id'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $deposit = $_POST['deposit'];

        // Check available copies
        $check = mysqli_query($conn,"SELECT available_copies FROM books WHERE id='$book_id'");
        $row = mysqli_fetch_assoc($check);

        if($row['available_copies'] > 0){
            // Insert issue record
            mysqli_query($conn,"INSERT INTO issues(student_id,book_id,start_date,end_date,deposit)
            VALUES('$student_id','$book_id','$start','$end','$deposit')");

            // Decrease available copies by 1
            mysqli_query($conn,"UPDATE books SET available_copies = available_copies - 1 WHERE id='$book_id'");

            echo "<div class='success'>✅ Book Issued Successfully!</div>";
        } else {
            echo "<div class='success'>⚠ No Copies Available</div>";
        }
    }
    ?>

    <!-- Back Link -->
    <a class="back-link" href="../index.php">← Back to Dashboard</a>
</div>

<!-- Table of Issued Books -->
<div class="container">
    <h2>All Issued Books</h2>
    <table border="1" width="100%" style="border-collapse: collapse; text-align:center;">
        <tr style="background:#0d6efd; color:white;">
            <th>ID</th>
            <th>Student</th>
            <th>Book</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Deposit</th>
        </tr>
        <?php
        $res = mysqli_query($conn,"
            SELECT i.id, s.name AS student, b.title AS book, i.start_date, i.end_date, i.deposit
            FROM issues i
            JOIN students s ON i.student_id = s.id
            JOIN books b ON i.book_id = b.id
            ORDER BY i.id DESC
        ");
        while($row = mysqli_fetch_assoc($res)){
            echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['student']."</td>
                <td>".$row['book']."</td>
                <td>".$row['start_date']."</td>
                <td>".$row['end_date']."</td>
                <td>".$row['deposit']."</td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
