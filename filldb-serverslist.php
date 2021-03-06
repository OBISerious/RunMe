#!/usr/bin/php
<?php
$dir="/var/www/html/RunMe";
chdir($dir);
#print "dir: $dir\n";
exec("pgrep -f filldb-serverslist.php",$result);
$numlines=count($result);
#print "numlines: $numlines\n";
if ($numlines > 3) {
        exit();
}
include 'functions.php';

global $ini;
$serverlist=isset($ini["reboot"]["serverlist"]) ? $ini["reboot"]["serverlist"] : "";

while (1) {
        #print "Creating new db\n";
        $db = new SQLite3("$dir/ping-temp.db");
        $db->exec("DROP TABLE IF EXISTS ping;");
        $db->exec("CREATE TABLE ping(id INTEGER PRIMARY KEY, hostname TEXT, ping TEXT, conn TEXT);");

        $handle = fopen("$dir/$serverlist", "r");
        if ($handle) {
            #print "reading file...\n";
            while (($line = fgets($handle)) !== false) {
                $line = str_replace(array("\n", "\r"), '', $line);
                #print "line: $line\n";
                list($name,$hostname,$user) = explode(",", $line);
                if ("$hostname" == ""){ continue;}
                $result = exec("ping -c1 -W1 $hostname >/dev/null 2>&1; echo $?");
                #print "ping: $hostname: $result\n";
                if ($result == "0"){
                        $ping="up";
                }else{
                        $ping="down";
                }
                $result = exec("timeout 5s ssh-keygen -R $hostname >/dev/null 2>&1");
                $result = exec("timeout 5s ssh-keyscan -H $hostname >> ~/.ssh/known_hosts 2>/dev/null");
                $rsafilename="$dir/$user.id_rsa";
                if (file_exists($rsafilename)) {
                        $rsa="-i $rsafilename";
                        $previousowner=posix_getpwuid(fileowner("$rsafilename"))["name"];
                        exec("sudo chown $(id -un) $rsafilename");
                }else{
                        $rsa="";
                }
                $result = exec("timeout 5s ssh -o ConnectTimeout=2 -o PreferredAuthentications=publickey $rsa $user@$hostname date >/dev/null 2>&1; echo $?");
                if ($result == "0"){
                        $conn="up";
                }else{
                        $conn="down";
                }
                exec("sudo chown $previousowner $rsafilename");
                print "$hostname $ping $conn\n";
                #print "INSERT INTO ping(hostname, ping, conn) VALUES(\"$name\", \"$ping\", \"$conn\")\n";
                $db->exec("INSERT INTO ping(hostname, ping, conn) VALUES(\"$name\", \"$ping\", \"$conn\")");
                #$hostname=preg_replace("/  */",",",$hostname);
                #print "--$hostname--\n";
                #list($dummy,$id,$host,$state)=explode(",",$hostname);
                #print "id: $id, host: $host, state: $state\n";
            }
        }
        $db->close();
        exec("mv $dir/ping-temp.db $dir/ping.db");
        sleep(5);
}

?>

