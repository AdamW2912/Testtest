<?php
// Database connection settings
$host = 'lingering-shadow.49192WP.dbinf.buildingtogether.io ';
$username = '34177-2tso';
$password = 'personeeldevadam2023';
$database = '49192WP';



// Connect to the database
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Update functionality
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];

    $query = "UPDATE registration SET firstName='$firstName', lastName='$lastName', gender='$gender', email='$email', password='$password', number='$number' WHERE id='$id'";
    $conn->query($query);
}

// Search functionality
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$escapedSearchTerm = $conn->real_escape_string($searchTerm);
$query = "SELECT * FROM registration WHERE firstName LIKE '%{$escapedSearchTerm}%' OR lastName LIKE '%{$escapedSearchTerm}%' OR email LIKE '%{$escapedSearchTerm}%'";

$result = $conn->query($query);
$data = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .update-form input[type="text"] {
            width: 100%;
        }

        .update-form button[type="submit"] {
            width: auto;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <h1>Registration Data</h1>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Password</th>
            <th>Number</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <form class="update-form" method="POST" action="">
                    <input type="hidden" name="oldId" value="<?php echo $row['id']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="firstName" value="<?php echo $row['firstName']; ?>"></td>
                    <td><input type="text" name="lastName" value="<?php echo $row['lastName']; ?>"></td>
                    <td><input type="text" name="gender" value="<?php echo $row['gender']; ?>"></td>
                    <td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
                    <td><input type="text" name="password" value="<?php echo $row['password']; ?>"></td>
                    <td><input type="text" name="number" value="<?php echo $row['number']; ?>"></td>
                    <td><button type="submit" name="update">Update</button></td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>