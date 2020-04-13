<?php

require 'header.php';

$db = new SQLite3('ping.db');
$res = $db->query('SELECT * FROM ping');
print "<meta http-equiv=\"refresh\" content=\"5\" />";
print "<table class='table table-bordered'>";
print "<tr align='center'><th>Hostname<th>Ping<th>Connectivity";

while ($row = $res->fetchArray()) {
    #echo "{$row['id']} {$row['hostname']} {$row['ping']} {$row['conn']} \n";
    $hostname=$row['hostname'];
    $ping=$row['ping'];
    $conn=$row['conn'];
    print "<tr><td>$hostname";
    $class=($ping == "up" ? "success" : "danger");
    print "<td align='center'><p class=\"btn btn-$class btn-lg\">$ping</p>";
    $class=($conn == "up" ? "success" : "danger");
    print "<td align='center'><p class=\"btn btn-$class btn-lg\">$conn</p>";
    print "\n";
}
print "</table>";
