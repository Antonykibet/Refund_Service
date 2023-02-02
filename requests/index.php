<?php

$servername = "localhost";
$username = "owuorian";
$password = "Valmamucera95";
$database = "discord_records";

$conn = new mysqli($servername, $username, $password, $database);

$sql = "SELECT id, username, Store, order_number, login_credentials, amount FROM refund_requests WHERE status='not processed'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Username</th>";
            echo "<th>Order Number</th>";
            echo "<th>Login Credentials</th>";
            echo "<th>Amount</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['order_number'] . "</td>";
                echo "<td>" . $row['login_credentials'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
            echo "</tr>";
        }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();


?>

<style>
    table, td, th {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: left;
    }


</style>



