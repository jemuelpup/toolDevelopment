<?php

require $_SERVER['DOCUMENT_ROOT'].'/common/dbconnect.php';
session_start();
$process="";
$data = "";

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
	case "FunctionName":{
		functionName($conn,$data);
	}
}

function functionName($c,$d){
	//sample codes inside the function
	$sql = $c->prepare("INSERT INTO category_tbl (name,category_code,description) VALUES (?,?,?)");
	$sql->bind_param('sss',$d->name,$d->category_code,$d->description);
	$msg = ($sql->execute() === TRUE) ? "Adding new Category success" : "Error: " . $sql . "<br>" . $c->error;
}


/* 
reusable functions - optional
*/


function validateData($d){
	if(isset($d)){
		return $d;
	}
	return "";
}
function validateDate($d){
	if(isset($d)){
		return date("Y-m-d", strtotime(str_replace('/', '-',$d)));
	}
	return "0000-00-00";
}
/**************************************************************************/




?>