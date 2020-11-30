<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe functions.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200329     Chris OBrien    Initial
//// 20200331     Chris OBrien    Added runme.ini
/////////////////////////////////////////////////////////////////////////////////

$ini=parse_ini_file("runme.ini", true);
$ini=array_change_key_case($ini, CASE_LOWER);
// print_r($ini);
validate_ini($ini);
$logfile=$ini["global"]["logfile"];

function validate_ini($ini)
{
            if(!isset($ini["global"]["logfile"])) { print "No logfile\n";
                }
}

function actionbutton($text,$action) {
        print "<input type=\"button\" value=\"$text\" style=\"padding: 15px; font-size: 18px; width: 100%; height: 200px; letter-spacing: 1px; font-size: 48;\" onClick=\"window.location='category.php?function=$action'\"/>";
        }

function button($text,$url) {
        print "<input type=\"button\" value=\"$text\" style=\"padding: 15px; font-size: 18px; width: 100%; height: 200px; letter-spacing: 1px; font-size: 48;\" onClick=\"window.location='$url.php'\"/>";
        }

function writelog($text) {
    global $logfile;
    //$logfile=$ini["global"]["logfile"];
	$user="";
	//if(isset($_SERVER['PHP_AUTH_USER'])) $user=$_SERVER['PHP_AUTH_USER'];
    $user=isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "";
	$handle=fopen($logfile,"a");
	$date=date("Y-m-d H:i:s");
	fwrite($handle,"$date $user $text\n");
}

//function workingbutton($type,$function,$trigger,$action) {
//	$name = strtoupper($action);
//	if ( $function == "lights") {
//		$function = "lightaction.php";
//		$functionvar = "lights";
//	}
//	if ( $type == "1" ) {
//		print "<td><input type='button' value='$name' onClick='window.location=\"$function?$functionvar=$trigger&action=$action\"'/>";
//	}
//}

function workingbutton($type,$function,$trigger,$action)                                                                                 
{
    $name = strtoupper($action);
    #if ($function == "lights") {
    #    $function = "lightaction.php";
    #    $functionvar = "lights";
    #}
    switch ($action) {
    case "on":
        $buttoncolour="success";
        break;
    case "off":
        $buttoncolour="danger";
        break;
    case "toggle":
        $buttoncolour="primary";
        break;
    default:
        $buttoncolour="secondary";
        break;
    }
    if ($type == "1" ) {
        print "<td><input type='button' value='$name' onClick='window.location=\"$function?$functionvar=$trigger&action=$action\"'/>";
    }
    if ($type == "2" ) {
        print "<td><button type=\"button\" class=\"btn btn-$buttoncolour\">$name</button>";
    }
    if ($type == "3" ) {
        print "<td><button type=\"button\" class=\"btn btn-outline-$buttoncolour btn-lg\">$name</button>";
    }
    if ($type == "4" ) {
        #print "<td align='center'><a class=\"btn btn-outline-$buttoncolour btn-lg\" href=\"$function?$functionvar=$trigger&action=$action\"><h2>$name</h2></a>";
        print "<td align='center'><a class=\"btn btn-outline-$buttoncolour btn-lg\" href=\"action.php?function=$function&objects=$trigger&action=$action\"><h2>$name</h2></a>\n";
    }
}

