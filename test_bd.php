<?php
\$conn = new mysqli('localhost', 'toor', '1234');
if (\$conn->connect_error) {
    die("Connection failed: " . \$conn->connect_error);
}
echo "Connected successfully to MySQL as toor user";
\$conn->close();
?>
