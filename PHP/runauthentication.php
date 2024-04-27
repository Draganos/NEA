<?php
// Connect to MySQL Server
$servername = "localhost";
$serverconnectusername = "abdullah";
$serverconnectpassword = "NEAfile892006";
$databasename = "database1nea";

$connnectdatabase = new mysqli($servername, $serverconnectusername, $serverconnectpassword, $databasename);
if ($connnectdatabase->connect_error) {
    die("Connection to the database failed: " . $connnectdatabase->connect_error);
}
echo "Connected to database successfully";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashedPassword = "";

    // Send password to Python hashing file for hashing
    if ($hashedPassword == "") {
        $temporaryfile = tempnam(sys_get_temp_dir(), 'hash_');
        file_put_contents($temporaryfile, $password);
        $hashedPassword = shell_exec('python hashalgo.py ' . escapeshellarg($temporaryfile));
        echo $hashedPassword; // Output hashed password for debugging
        unlink($temporaryfile);
    }


    // Fetch user data from the database
    $sqlquery = "SELECT UserID, username, PasswordHash FROM Users WHERE username = ?";
    $stmt = $connnectdatabase->prepare($sqlquery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["PasswordHash"])) {
        // Password is correct, user is authenticated
        // Start a session, store user information if needed, redirect to dashboard, etc.
        session_start();
        $_SESSION["UserID"] = $user["UserID"];
        $_SESSION["username"] = $user["username"];
        header("Location: dashboard.html");
        exit();
    } else {
        // Incorrect username or password
        echo "Invalid login credentials";
    }
}
?>
