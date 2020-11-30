<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe serverinfoaction.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200802     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
require 'functions.php';
$date=date("YmdHis");
#$dry="echo ";
$dry="";
$timeout=isset($ini["serverinfo"]["timeout"]) ? $ini["serverinfo"]["timeout"] : "10";
writelog("Server info  Action Run");

if(isset($_GET["server"])) {
    $server=$_GET["server"];
    list($name,$host,$user,$action) = explode(",", $server);
    writelog("Rebooting server $name, $host with user $user");
    if (file_exists("$user.id_rsa")) {
        $rsa="-i $user.id_rsa";
    }else{
        $rsa="";
    }
    if ($action == "uptime") { $cmdaction = "uptime"; };
    if ($action == "date") { $cmdaction = "date"; };
    if (! isset($action)) { $cmdaction = "uptime"; };
    $cmd="${dry}ssh -o ConnectTimeout=10 -o PreferredAuthentications=publickey $rsa $user@$host \"$cmdaction\" 2>&1";
    writelog("$cmd");
    $output=shell_exec($cmd);
    writelog("$output");
    print "$output";

} 
