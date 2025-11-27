<?php

// db config
$servername = "localhost";
$username = "lamp_user";
$password = "almA0000";
$dbname = "lamp_db";

// connection to db
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("DB connection error: " . $conn->connect_error);
}

// SQL select
$sql = "select id, rendszam, tipus, szin, evjarat
          from autok
         order by rendszam";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <title>Egyszerű LAMP alkalmazás</title>
</head>
<body>
  <h1>Autók listája</h1>

<?php
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr><th>ID</th><th>Rendszám</th><th>Típus</th>" .
    "<th>Szín</th><th>Évjárat</th></tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" .
      htmlspecialchars($row["rendszam"]) . "</td><td>" .
      htmlspecialchars($row["tipus"]) . "</td><td>" .
      htmlspecialchars($row["szin"]) . "</td><td>" .
      htmlspecialchars($row["evjarat"]) . "</td></tr>";
  }
  echo "</table>";
}
else {
  echo "Nincs találat az adatbázisban.";
}
?>

<?php
$conn->close();
?>

<hr>
<p>Powered by Linux, Apache2, MariaDB (MySQL) and PHP.</p>

</body>
</html>
