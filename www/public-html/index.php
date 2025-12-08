<?php

// db config
$host = "localhost";
$db = "lamp_db";
$user = "lamp_user";
$pass = "almA0000";
$charset = "utf8mb4";

// connection to db
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// action
  if (isset($_GET['muvelet'])) {
    $muvelet = $_GET['muvelet'];
    $rendszam = $_GET['rendszam'];
    $tipus = $_GET['tipus'];
    $szin = $_GET['szin'];
    $evjarat = $_GET['evjarat'];

    switch ($muvelet) {
      case 'uj':
        $sql = "insert into autok (rendszam, tipus, szin, evjarat)
                           values (:rendszam, :tipus, :szin, :evjarat)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':rendszam', $rendszam, PDO::PARAM_STR);
        $stmt->bindValue(':tipus', $tipus, PDO::PARAM_STR);
        $stmt->bindValue(':szin', $szin, PDO::PARAM_STR);
        $stmt->bindValue(':evjarat', $evjarat, PDO::PARAM_STR);

        $stmt->execute();

        break;
    }
  }



// SQL select
$sql = "select id, rendszam, tipus, szin, evjarat
          from autok
         order by rendszam";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$autok_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
$sorok_szama = count($autok_lista);
if ($sorok_szama > 0) {
  echo "<table>";
  echo "<tr><th>ID</th><th>Rendszám</th><th>Típus</th>" .
    "<th>Szín</th><th>Évjárat</th></tr>";

  foreach ($autok_lista as $sor) {
    echo "<tr><td>" . htmlspecialchars($sor["id"]) . "</td><td>" .
      htmlspecialchars($sor["rendszam"]) . "</td><td>" .
      htmlspecialchars($sor["tipus"]) . "</td><td>" .
      htmlspecialchars($sor["szin"]) . "</td><td>" .
      htmlspecialchars($sor["evjarat"]) . "</td></tr>";
  }
  echo "</table>";
}
else {
  echo "Nincs találat az adatbázisban.";
}
?>

  <hr>



  <p>Próba form</p>
  <form action="index.php">
    <label for="rendszam">Rendszám:</label>
    <input type="text" id="rendszam" name="rendszam" value=""><br>
    <label for="tipus">Típus:</label>
    <input type="text" id="tipus" name="tipus" value=""><br>
    <label for="szin">Szín:</label>
    <input type="text" id="szin" name="szin" value=""><br>
    <label for="evjarat">Évjárat:</label>
    <input type="text" id="evjarat" name="evjarat" value=""><br>
    <button type="submit" value="uj" name="muvelet">Rendben</button>
  </form>



  <hr>

  <p>

<?php
// SQL select
$sql = "select foverzio, alverzio, szoveg
          from verzio";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$verzio = $stmt->fetch(PDO::FETCH_ASSOC);

if ($verzio != false) {
  echo "Verzió: " .
    htmlspecialchars($verzio["foverzio"]) . "." .
    htmlspecialchars($verzio["alverzio"]) . " " .
    htmlspecialchars($verzio["szoveg"]) . " - ";
}
?>

  Powered by Linux, Apache2, MariaDB (MySQL) and PHP.</p>

</body>
</html>
