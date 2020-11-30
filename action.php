<?php
require 'functions.php';
$date=date("YmdHis");
writelog("Action Script Start");

$action="";
if(isset($_GET["function"])) { $function=$_GET["function"]; }
if(isset($_GET["objects"])) { $objects=$_GET["objects"]; }
if(isset($_GET["action"])) { $action=$_GET["action"]; }
if(isset($argv[1])) { $function=$argv[1]; }
if(isset($argv[2])) { $objects=$argv[2]; }
if(isset($argv[3])) { $action=$argv[3]; }
if (! $function ) {
    writelog("No function.  Aborting.");
    header("location: index.php");
    exit;
}

function action_lights($objects,$action) {
    writelog("Starting action");
    global $ini, $function;
    $starturl=$ini[$function]["webhook_start"];
    $endurl=$ini[$function]["webhook_end"];
    writelog("objects: $objects - action: $action");
    $outputarray=array();
    $objectsarray=explode("-", $objects);
    foreach($objectsarray as $object) {
        $url="$starturl$object$action$endurl";
        $cmd="curl -X POST $url";
        print "\n\n--$url--\n\n";
        writelog("$cmd");
        $output=shell_exec($cmd);
        print "$output";
        writelog("$output");
        if (preg_match("/Congratulations!/", $output)) {
            array_push($outputarray, "$object-$action");
        }
    }
    header("location: category.php?function=lights");
}



switch ($function) {
case "lights":
        action_lights($objects,$action);
        break;
case "reboot":
        action_reboot();
        break;
default:
        header("location: index.php");
        break;
}

exit;
?>
