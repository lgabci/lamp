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
  if (isset($_GET["muvelet"])) {
    $muvelet = $_GET["muvelet"];
    $form_id = $_GET["form_id"];
    $html_object = $_GET["html_object"];
    $html_for = $_GET["html_for"];
    $html_type = $_GET["html_type"];
    $html_name = $_GET["html_name"];
    $html_value = $_GET["html_value"];
    $szoveg = $_GET["szoveg"];

    switch ($muvelet) {
      case "uj":
        $sql = "insert into form_mezok (form_id, html_object,
                                        html_for, html_type,
                                        html_name, html_value, szoveg)
                           values (:form_id, :html_object,
                                   :html_for, :html_type,
                                   :html_name, :html_value, :szoveg)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":form_id", $form_id, PDO::PARAM_STR);
        $stmt->bindValue(":html_object", $html_object, PDO::PARAM_STR);
        $stmt->bindValue(":html_for", $html_for, PDO::PARAM_STR);
        $stmt->bindValue(":html_type", $html_type, PDO::PARAM_STR);
        $stmt->bindValue(":html_name", $html_name, PDO::PARAM_STR);
        $stmt->bindValue(":html_value", $html_value, PDO::PARAM_STR);
        $stmt->bindValue(":szoveg", $szoveg, PDO::PARAM_STR);

        $stmt->execute();

        header("Location: formok.php");
        exit;
        break;
    }
  }



// SQL select
$form_id = 1;

$sql = "select id, form_id, html_object, html_for, html_type,
               html_name, html_value, szoveg
          from form_mezok
         where form_id = :form_id
         order by id";


$stmt = $pdo->prepare($sql);
$stmt->bindValue(":form_id", $form_id);
$stmt->execute();

$form_mezok = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <title>Egyszerű LAMP alkalmazás</title>
</head>
<body>
  <a href="index.php">Főoldal</a>
  <h1>Form mezők</h1>

<?php
$sorok_szama = count($form_mezok);
if ($sorok_szama > 0) {
  echo "<table border=\"1\">";
  echo "<tr><th>ID</th><th>Object</th><th>For</th>" .
    "<th>Type</th><th>Name</th><th>Value</th><th>Szöveg</th></tr>";

  foreach ($form_mezok as $form_mezo) {
    echo "<tr><td>" . htmlspecialchars($form_mezo["id"]) . "</td><td>" .
      htmlspecialchars($form_mezo["html_object"]) . "</td><td>" .
      htmlspecialchars($form_mezo["html_for"]) . "</td><td>" .
      htmlspecialchars($form_mezo["html_type"]) . "</td><td>" .
      htmlspecialchars($form_mezo["html_name"]) . "</td><td>" .
      htmlspecialchars($form_mezo["html_value"]) . "</td><td>" .
      htmlspecialchars($form_mezo["szoveg"]) . "</td>";
  }
  echo "</table>";
}
else {
  echo "Nincs találat az adatbázisban.";
}
?>

  <hr>

<?php
$sql = "select fejlec, action
          from formok
         where id = :form_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":form_id", $form_id);
$stmt->execute();

$form = $stmt->fetch(PDO::FETCH_ASSOC);


if ($form) {
  echo "<p>" . htmlspecialchars($form["fejlec"]) . "</p>";
  echo "<form action=" . htmlspecialchars($form["action"]) . ">";
}

$sql = "select html_object, html_for, html_type, html_name, html_value, szoveg
          from form_mezok
         where form_id = :form_id
         order by id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":form_id", $form_id);
$stmt->execute();

$form_mezok = $stmt->fetchAll();
foreach ($form_mezok as $form_mezo) {
  echo "<" . $form_mezo["html_object"];
  if (isset($form_mezo["html_for"])) {
    echo " for=\"" . $form_mezo["html_for"] . "\"";
  }
  if (isset($form_mezo["html_type"])) {
    echo " type=\"" . $form_mezo["html_type"] . "\"";
  }
  if (isset($form_mezo["html_name"])) {
    echo " id=\"" . $form_mezo["html_name"] . "\"";
    echo " name=\"" . $form_mezo["html_name"] . "\"";
  }
  if (isset($form_mezo["html_value"])) {
    echo " value=\"" . $form_mezo["html_value"] . "\"";
  }
  if (isset($form_mezo["szoveg"])) {
    echo ">" . $form_mezo["szoveg"] . "</" . $form_mezo["html_object"] . ">";
  }
  else {
    echo ">";
  }

  if ($form_mezo["html_type"] == "text") {
    echo "<br>";
  }
}

?>
<!--
    <label for="rendszam">Rendszám:</label>
    <input type="text" id="rendszam" name="rendszam" value=""><br>
    <label for="tipus">Típus:</label>
    <input type="text" id="tipus" name="tipus" value=""><br>
    <label for="szin">Szín:</label>
    <input type="text" id="szin" name="szin" value=""><br>
    <label for="evjarat">Évjárat:</label>
    <input type="text" id="evjarat" name="evjarat" value=""><br>
    <button type="submit" value="uj" name="muvelet">Rendben</button>
-->
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
