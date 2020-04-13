<?php
///////////////////////////////////////////////////////////////////////////////
// RunMe index.php
///////////////////////////////////////////////////////////////////////////////
// 20200329     Chris OBrien    Initial
///////////////////////////////////////////////////////////////////////////////
// Todo:
//      Use better authentication than .htaccess
//      Real-time log updates
//      Allow online editing of server names?
//      Put css files local
///////////////////////////////////////////////////////////////////////////////
include 'header.php';

$organization=isset($ini["global"]["organization"]) ? $ini["global"]["organization"] : "RunMe";

if ("$organization" != "") {
            print "<script>document.title = \"$organization\";</script>";
}

print <<<_EOF_
<form>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
_EOF_;
print "<tr><td width=50%>";
button("Reboot Server","reboot");
print "<td>";
button("Logs","logs");
print "<tr><td>";
button("Ping","ping");
print "</form></table></div>";

include 'footer.php';
