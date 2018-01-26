<?php
/* This file contains the elements for viewing */

include $_SERVER['DOCUMENT_ROOT'].'/common/commonfunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/common/dbconnect.php';

$process="";

if(isset($_POST['process'])){
	$process = $_POST['process'];
}
else{
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$process = $request->process;
	$data = $request->data;
}

switch($process){
	case "selectFunctionName":{
		selectFunctionName($conn);
	}
	case "selectFunctionNameWCond":{
		selectFunctionNameWCond($conn,$data);
	}
}

// selectItemCategory($conn);
function selectFunctionName($c){
	$sql = "SELECT id,name,category_code,description FROM category_tbl WHERE active = 1";
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}

/* This function needs some edit*/
function selectFunctionNameWCond($c,$d){
	$sql = "SELECT id,name,category_code,description FROM category_tbl WHERE active = 1 and name = $d->name";// add security here
	print_r(hasRows($c,$sql) ? json_encode(selectQuery($c,$sql)) : "");
}


?>