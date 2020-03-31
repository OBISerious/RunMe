<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe functions.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200329     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
require 'variables.php';

function button($text,$url) {
        print "<input type=\"button\" value=\"$text\" style=\"padding: 15px; font-size: 18px; width: 100%; height: 200px; letter-spacing: 1px; font-size: 48;\" onClick=\"window.location='$url.php'\"/>";
        }

function writelog($text) {
	include 'variables.php';
	$user="";
	if(isset($_SERVER['PHP_AUTH_USER'])) $user=$_SERVER['PHP_AUTH_USER'];
	$handle=fopen($logfile,"a");
	$date=date("Y-m-d H:i:s");
	fwrite($handle,"$date $user $text\n");
}

function workingbutton($type,$function,$trigger,$action) {
	$name = strtoupper($action);
	if ( $function == "lights") {
		$function = "lightaction.php";
		$functionvar = "lights";
	}
	if ( $type == "1" ) {
		print "<td><input type='button' value='$name' onClick='window.location=\"$function?$functionvar=$trigger&action=$action\"'/>";
	}
}
