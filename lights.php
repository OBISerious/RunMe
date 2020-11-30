<?php
require 'header.php';

$function="lights";
$buttontype="4";
$actionlist=array("on","off","toggle");

print "<form action='lightaction.php'>";
print "<table class='table table-bordered'>";

$handle = fopen("lights.list", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        if(substr($line, 0, 1) == "#") { continue;
        }
        $line = str_replace(array("\n", "\r"), '', $line);
        list($name,$dirname,$actions) = explode(",", $line);
        $actionsarray = explode("|", $actions);
        array_unshift($actionsarray, "first element");
        print "<tr><td><h2>$name</h2>";
        foreach($actionlist as $actionitem) {
            if(!$actions) {
                workingbutton($buttontype, $function, $dirname, $actionitem);
            } else {
                if(!empty(array_search($actionitem, $actionsarray))) {
                    workingbutton($buttontype, $function, $dirname, $actionitem);
                } else {
                    print "<td>&nbsp;";
                }
            }
        }
        // if(!$actions) workingbutton($buttontype,$function,$dirname,"on");
        // workingbutton($buttontype,$function,$dirname,"off");
        // workingbutton($buttontype,$function,$dirname,"toggle");
    }
}
// print "</select>";
// print "<input type='submit' value='Reboot' />";
print "<form>";



require 'footer.php';
?>

