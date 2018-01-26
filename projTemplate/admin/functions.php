<?php
/*
 This files contains the sql queries for
 UPDATE AND INSERT only
*/
// Includes
include $_SERVER['DOCUMENT_ROOT'].'/common/commonfunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/common/dbconnect.php';

// server side vars
session_start();


// variables
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


/* function area */
// insert function block
function insertFunctionName($c,$d){
	//sample codes inside the function
	$sql = $c->prepare("INSERT INTO category_tbl (name,category_code,description) VALUES (?,?,?)");
	$sql->bind_param('sss',$d->name,$d->category_code,$d->description);
	$msg = ($sql->execute() === TRUE) ? "Adding new Category success" : "Error: " . $sql . "<br>" . $c->error;
}

// update function block
function updateFunctionName($c,$d){
	//sample codes inside the function
	$sql = $c->prepare("INSERT INTO category_tbl (name,category_code,description) VALUES (?,?,?)");
	$sql->bind_param('sss',$d->name,$d->category_code,$d->description);
	$msg = ($sql->execute() === TRUE) ? "Adding new Category success" : "Error: " . $sql . "<br>" . $c->error;
}






?>