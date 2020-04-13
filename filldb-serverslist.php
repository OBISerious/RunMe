<?php
include 'functions.php';

global $ini;
$serverlist=isset($ini["reboot"]["serverlist"]) ? $ini["reboot"]["serverlist"] : "";

$db = new SQLite3('ping-temp.db');
$db->exec("DROP TABLE IF EXISTS ping");
$db->exec("CREATE TABLE ping(id INTEGER PRIMARY KEY, hostname TEXT, ping TEXT, conn TEXT)");

$handle = fopen($serverlist, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = str_replace(array("\n", "\r"), '', $line);
        list($name,$hostname,$user) = explode(",", $line);
        if ("$hostname" == ""){ continue;}
        $result = exec("ping -c1 -W1 $hostname >/dev/null 2>&1; echo $?");
        #print "ping: $hostname: $result\n";
        if ($result == "0"){
                $ping="up";
        }else{
                $ping="down";
        }
        $result = exec("timeout 5s ssh -o ConnectTimeout=2 -o PreferredAuthentications=publickey $user@$hostname date >/dev/null 2>&1; echo $?");
        if ($result == "0"){
                $conn="up";
        }else{
                $conn="down";
        }
        print "$hostname $ping $conn\n";
        $db->exec("INSERT INTO ping(hostname, ping, conn) VALUES(\"$name\", \"$ping\", \"$conn\")");
        #$hostname=preg_replace("/  */",",",$hostname);
        #print "--$hostname--\n";
        #list($dummy,$id,$host,$state)=explode(",",$hostname);
        #print "id: $id, host: $host, state: $state\n";
    }
}
exec("mv ping-temp.db ping.db");

?>
