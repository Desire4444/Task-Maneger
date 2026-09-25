<?php
// 1. Connect to Database
$conn = mysqli_connect("localhost", "root", "", "webtechdb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Handle Insert (Create)
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $age = (int)$_POST['age'];

    if (!empty($name) && $age > 0) {
        mysqli_query($conn, "INSERT INTO students (name, age) VALUES ('$name', $age)");
    }
    header("Location: index.php");
    exit();
}

// 3. Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id = $id");
    header("Location: index.php");
    exit();
}

// 4. Handle Update
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $age = (int)$_POST['age'];

    if (!empty($name) && $age > 0) {
        mysqli_query($conn, "UPDATE students SET name='$name', age=$age WHERE id=$id");
    }
    header("Location: index.php");
    exit();
}

// Check if we are currently editing a record
$edit_student = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
    $edit_student = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>

    <!-- Registration -->
    <h2><?php echo $edit_student ? "Edit Student" : "Daeyang Register Student"; ?></h2>
    <form method="POST" action="index.php">
        <?php if ($edit_student): ?>
            <input type="hidden" name="id" value="<?php echo $edit_student['id']; ?>">
        <?php endif; ?>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $edit_student ? $edit_student['name'] : ''; ?>" required>

        <label>Age:</label>
        <input type="number" name="age" value="<?php echo $edit_student ? $edit_student['age'] : ''; ?>" required>

        <?php if ($edit_student): ?>
            <input type="submit" name="update" value="Update Student">
            <a href="index.php">Cancel</a>
        <?php else: ?>
            <input type="submit" name="add" value="Add Student">
        <?php endif; ?>
    </form>

    <br><hr><br>

    <!-- Display Records Table -->
    <h2>Student List</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM students");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
