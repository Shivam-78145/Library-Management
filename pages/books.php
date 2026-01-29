<?php include "../config/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="header">Book Management</div>

<div class="container">
    <form method="post">
        <h2>Add Book</h2>

        <input name="title" placeholder="Book Title" required>
        <input name="author" placeholder="Author Name">
        <input type="number" name="stock" placeholder="Number of Copies" value="1" min="1" required>

        <button name="add">Add Book</button>
    </form>

    <?php
    if(isset($_POST['add'])){
        $title = $_POST['title'];
        $author = $_POST['author'];
        $stock = $_POST['stock'];

        // Both stock and available_copies are set to the same value initially
        mysqli_query($conn,"INSERT INTO books(title,author,stock,available_copies)
        VALUES('$title','$author','$stock','$stock')");

        echo "<div class='success'>✅ Book Added Successfully</div>";
    }
    ?>

    <a class="back-link" href="../index.php">← Back to Dashboard</a>
</div>

</body>
</html>
