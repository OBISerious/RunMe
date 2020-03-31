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

$cmd="${dry}ssh -o ConnectTimeout=10 $user@$host \"sudo shutdown -r now\"";
#$cmd="${dry}ssh $user@$host \"date\"";
$output=shell_exec($cmd);
writelog("$output");
header("location: reboot.php?");



