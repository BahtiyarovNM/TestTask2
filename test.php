<?php

$dbhost = "127.0.0.1";
$dbuser = "root";
$dbpass = "123";
$dbname = "TestDB";
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "SELECT `id`,`firstname` FROM `usertest` ";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$table = "<table width=\"100%\" border=\"1\">
<tr>
    <th width=\"8%\">статус</th>
    <th width=\"15%\">кол-во</th>
  </tr>";
while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {

    $table .= "<tr>";
    $table .= "<td>" . $row['id'] . "</td>";
    $table .= "<td>" . $row['firstname'] . " </td>";
    $table .= "</tr>";
}
$table .= "</table>";
echo $table;