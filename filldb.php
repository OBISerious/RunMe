<?php

$db = new SQLite3('ping-temp.db');
$db->exec("DROP TABLE IF EXISTS ping");
$db->exec("CREATE TABLE ping(id INTEGER PRIMARY KEY, hostname TEXT, ping TEXT, conn TEXT)");

$cmd="virsh list | awk '{print $2}' | tail -n +3";
$output=shell_exec($cmd);
$outputarray=explode("\n",$output);
foreach($outputarray as $hostname){
    if ("$hostname" == ""){ continue;}
    $result = exec("ping -c 1 $hostname");
    if ($result == 0){
              $ping="up";
    }else{
              $ping="down";
    }
    $result = exec("ssh obi@$hostname date >/dev/null 2>&1; echo $?");
    if ($result == 0){
              $conn="up";
    }else{
              $conn="down";
    }
    print "$hostname $ping $conn\n";
    $db->exec("INSERT INTO ping(hostname, ping, conn) VALUES(\"$hostname\", \"$ping\", \"$conn\")");
    #$hostname=preg_replace("/  */",",",$hostname);
    #print "--$hostname--\n";
    #list($dummy,$id,$host,$state)=explode(",",$hostname);
    #print "id: $id, host: $host, state: $state\n";
}
exec("mv ping-temp.db ping.db");

?>
