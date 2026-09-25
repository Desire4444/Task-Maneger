<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Student not found.");
}

$message = "";

// UPDATE LOGIC
if (isset($_POST['update_student'])) {
    $name = trim($_POST['name']);
    $age  = trim($_POST['age']);

    if (empty($name) || empty($age)) {
        $message = "<p style='color: red;'>All fields are required!</p>";
    } elseif (!is_numeric($age) || $age <= 0) {
        $message = "<p style='color: red;'>Please enter a valid age.</p>";
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $age  = (int)$age;

        $sql = "UPDATE students SET name = '$name', age = $age WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "<p style='color: red;'>Error updating record: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <style>
        body { font-family: sans-serif; margin: 30px; }
        input { margin: 5px 0; padding: 8px; display: block; }
    </style>
</head>
<body>

    <h2>Update Student Record</h2>
    <?php echo $message; ?>

    <form method="POST" action="edit.php?id=<?php echo $id; ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>">

        <label>Age:</label>
        <input type="number" name="age" value="<?php echo $student['age']; ?>">

        <input type="submit" name="update_student" value="Update Record">
        <a href="index.php">Cancel</a>
    </form>

</body>
</html>
