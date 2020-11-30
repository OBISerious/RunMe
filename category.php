<?php
//require 'functions.php';
require 'header.php';
if(isset($_GET["function"])) { $function=$_GET["function"];
}

if ($function == "lights") {
    // Set defaults
    $button_type="4";
    $actions="on|off|toggle";
    if(isset($ini[$function]["button_type"])) { $button_type=$ini[$function]["button_type"];
    }
    if(isset($ini[$function]["actions"])) { $actions=$ini[$function]["actions"];
    }
    $actionlist=explode("|", $actions);


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
                    workingbutton($button_type, $function, $dirname, $actionitem);
                } else {
                    if(!empty(array_search($actionitem, $actionsarray))) {
                        workingbutton($button_type, $function, $dirname, $actionitem);
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
    print "<form>";
} else {
    print "<form action='rebootaction.php'>";
    print "<select name='server' id='server'>";
    print "<option value='' selected='selected'></option>";
    
    $handle = fopen("servers.list", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = str_replace(array('.', ' ', "\n", "\t", "\r"), '', $line);
            list($name,$host,$user) = explode(",", $line);
            print "<option name='server' value='$name'>$name</option>";
            // print "$line\n";
        }
    }
    print "</select>";
    print "<input type='submit' value='Reboot' />";
    print "<form>";
}




require 'footer.php';
?>

