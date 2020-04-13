<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe rebootaction.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200329     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
require 'functions.php';
$date=date("YmdHis");
#$dry="echo ";
$dry="";
$timeout=isset($ini["reboot"]["timeout"]) ? $ini["reboot"]["timeout"] : "10";
writelog("Reboot Action Run");

if(isset($_GET["server"])) {
    $server=$_GET["server"];
} else {
    header("location: reboot.php?");
    debug_print_backtrace();
    exit;
}
list($name,$host,$user) = explode(",", $server);
writelog("Rebooting server $name, $host with user $user");

#$cmd="${dry}ssh -o ConnectTimeout=10 $user@$host \"date\"";
#writelog("$cmd");
#$output=shell_exec($cmd);
#writelog("$output");

$result = exec("timeout 5s ssh-keyscan -H $hostname >> ~/.ssh/known_hosts 2>/dev/null");
if (file_exists("$user.id_rsa") {
    $rsa="-i $user.id_rsa";
}else{
    $rsa="";
}
$cmd="${dry}ssh -o ConnectTimeout=10 $user@$host \"sudo shutdown -r now\" 2>&1";
#writelog("$cmd");
$output=shell_exec($cmd);
writelog("$output");
header("location: reboot.php?");



