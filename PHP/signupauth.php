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
    // Get username, password, and password confirmation from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordconfirm = $_POST["reenterpassword"];
    $hashedPassword = "";

    // Check if passwords match
    if ($password == $passwordconfirm) {
        // Send password to Python hashing file for hashing
        if ($hashedPassword == "") {
            $temporaryfile = tempnam(sys_get_temp_dir(), 'hash_');
            file_put_contents($temporaryfile, $password);
            $hashedPassword = shell_exec('python hashalgo.py ' . escapeshellarg($temporaryfile));
            echo $hashedPassword; // Output hashed password for debugging
            unlink($temporaryfile);
        }
        
        
        $sqlappend = "INSERT INTO Users (Username, PasswordHash) VALUES ('$username', '$hashedPassword')";
        if ($connnectdatabase->query($sqlappend) === TRUE) {
            echo "New record created successfully";
            
        } else {
            echo "Error: " . $sqlappend . "<br>" . $connnectdatabase->error;
        }
        
        $connnectdatabase->close();
    } else {
        echo "Passwords provided do not match";
    }
}
?>
