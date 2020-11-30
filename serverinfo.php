<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe serverinfo.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200728     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
require 'header.php';

$serverlist=isset($ini["serverinfo"]["serverlist"]) ? $ini["serverinfo"]["serverlist"] : "";
$title=isset($ini["serverinfo"]["name"]) ? $ini["serverinfo"]["name"] : "";
$instructions=isset($ini["serverinfo"]["instructions"]) ? $ini["serverinfo"]["instructions"] : "";

if ("$title" != "") {
    print "<script>document.title = \"$title\";</script>";
}

if ("$instructions" != "") {
    print "<h1>$instructions</h1><br>";
}

print <<<_EOF_
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
                function reply_click(clicked_id)
                {
                        var linearray = clicked_id.split(',');
                        var name = linearray[0];
                        var elem = document.getElementById(name);
                        elem.value = "*** Checking ***";
                        var actionurl = "serverinfoaction.php?server=" + clicked_id;
                        $.get(actionurl,function( data) {
                            var elem = document.getElementById(name);
                            elem.value = data;
                        });
                }
</script>

<table>
_EOF_;

$handle = fopen($serverlist, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = str_replace(array("\n", "\r"), '', $line);
        list($name,$host,$user) = explode(",", $line);
        print <<<_EOF_
<tr><td>$name &nbsp
<td><input type="text" id="$name" value="" style='width:30em'>
<td><button id="$line" onClick="reply_click(this.id + ',uptime')">Uptime</button>
<td><button id="$line" onClick="reply_click(this.id + ',date')">Date</button>
<br>\n
_EOF_;
    }
}
print "</table>";

require 'footer.php';
?>

