<?php
///////////////////////////////////////////////////////////////////////////////
//// RunMe header.php
/////////////////////////////////////////////////////////////////////////////////
//// 20200329     Chris OBrien    Initial
/////////////////////////////////////////////////////////////////////////////////
include 'functions.php';
$organization=isset($ini["global"]["organization"]) ? $ini["global"]["organization"] : "RunMe";
$backgroundcolour=isset($ini["global"]["backgroundcolour"]) ? $ini["global"]["backgroundcolour"] : "0000FF";

print <<<_EOF_
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #$backgroundcolour;">
  <a class="navbar-brand" href="http://$_SERVER[HTTP_HOST]">$organization</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="http://$_SERVER[HTTP_HOST]">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logs.php">Logs</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a class="navbar-brand" href="http://logout@$_SERVER[HTTP_HOST]">Logout</a>
    </form>
  </div>
</nav>
<br>

<!-- Menu Div -->
<div style="margin:auto; height:100%; overflow:auto; width:70%; padding: 10px;" id="control">
<!-- original
<div style="margin:auto, position:fixed; left:0; top:153; width:70%; height:100%; overflow:auto; visibility:visible; z-index:10;" id="control">
-->

<!-- END OF HEADER -->

_EOF_

?>


