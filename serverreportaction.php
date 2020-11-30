<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe serverreport.php
/////////////////////////////////////////////////////////////////////////////////
//// 20201129     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////

$serverlist="servers.list";


$handle = fopen($serverlist, "r");
$pid=getmypid();
$output = fopen("serverreport.html.$pid","w");
fwrite($output,"<table border=2 padding=5><tr><th width=150px>Host name<th width=100px>Patch<th width=400px>Version\n");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = str_replace(array("\n", "\r"), '', $line);
        list($name,$host,$user) = explode(",", $line);
        $cmd="ssh -o ConnectTimeout=2 $user@$name \"/usr/lib/update-notifier/apt-check 2>&1\" 2>/dev/null";
        $patch=shell_exec($cmd);
        $cmd="ssh -o ConnectTimeout=2 $user@$name \"cat /etc/os-release | grep 'VERSION=' | sed -e 's/^VERSION=//'\" 2>/dev/null";
        $version=shell_exec($cmd);
        fwrite($output,"<tr><td>$name &nbsp<td>$patch<td>$version\n");
    }
}
fwrite($output,"</table>");
$generated=date("Y-m-d H:i");
fwrite($output,"Generated $generated\n");
fclose($output);
unlink("serverreport.html");
rename("serverreport.html.$pid","serverreport.html");

?>

