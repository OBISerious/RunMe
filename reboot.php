<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe reboot.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200329     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
require 'header.php';

$dry=1;
$waitbetween=isset($ini["reboot"]["waitbetween"]) ? $ini["reboot"]["waitbetween"] : "300";
$serverlist=isset($ini["reboot"]["serverlist"]) ? $ini["reboot"]["serverlist"] : "";
$title=isset($ini["reboot"]["name"]) ? $ini["reboot"]["name"] : "";
$instructions=isset($ini["reboot"]["instructions"]) ? $ini["reboot"]["instructions"] : "";

if ("$title" != "") {
    print "<script>document.title = \"$title\";</script>";
}

if ("$instructions" != "") {
    print "<h1>$instructions</h1><br>";
}

print <<<_EOF_
<select name="server" id="server" style="font-size:50px;">
<option value="" selected="selected">Select a server</option>
_EOF_;

$handle = fopen($serverlist, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = str_replace(array("\n", "\r"), '', $line);
        list($name,$host,$user) = explode(",", $line);
        $cmd="grep \"$name,\" $logfile | tail -1 | awk '{print $1 \" \" $2}'";
        $lastdate=shell_exec($cmd);
        $lastdate = str_replace(array("\n", "\r"), '', $lastdate);
        $lastdate = strtotime($lastdate);
        print "<option name='server' value='$line,$lastdate'>$name</option>\n";
    }
}
print <<<_EOF_
</select>
<button type="button" class="btn btn-primary btn-lg" onclick="rebootaction()"> Reboot </button>
<script>
function rebootaction() {
    var line = document.getElementById("server").value;
    var actionurl = "rebootaction.php?server=" + line;
    var linearray = line.split(',');
    var name = linearray[0];
    var epoch = Math.round(Date.now() / 1000);
    if (epoch - linearray[3] < $waitbetween) {
        alert("Unable to reboot server within " + $waitbetween + " seconds of last attempt");
    } else {
        var result = confirm("Do you really want to reboot server " + name);
        if (result == true) {
            location.href = actionurl;
        }
    }
}
</script>
_EOF_;

require 'footer.php';
?>

