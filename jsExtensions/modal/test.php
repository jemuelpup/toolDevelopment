<?php

/*************************************************************************************
* Note:
* In the development process, always add the table name in the function.
* the function name syntax must be:
* Syntax: dbMethod_name($param)
*************************************************************************************/

dbInsert_insertUser($_POST['data']);
dbUpdate_updateUser($_POST['data']);

function dbInsert_insertUser($data){
	$tableName = "tbl_user";
	$fields = "";
	$values = "";
	foreach($data as $fieldData){
		$fields .= $fieldData["name"].",";
		if ($fieldData["type"] == "text") {	$values .= "'".$fieldData["val"]."',";	}
		elseif($fieldData["type"] == "number") {	$values .= $fieldData["val"].",";	};
	}
	$fields = "(".substr($fields, 0, -1).")";
	$values = "(".substr($values, 0, -1).")";
	$sql = "INSERT INTO $tableName $fields VALUES $values ";
	echo $sql;
}
/* Add where clause in this Function 
	For better performance, add array of WHERE clause and the updateExeption fields
*/
function dbUpdate_updateUser($data){
	$whereClause = "";
	
	$tableName = "tbl_user";
	$updateVal = "";
	foreach($data as $fieldData){
		if ($fieldData["type"] == "text") {	$updateVal .= $fieldData["name"]." = '".$fieldData["val"]."',";	}
		elseif("num") {	$updateVal .= $fieldData["name"]." = ".$fieldData["val"].",";	};
	}
	$updateVal = substr($updateVal, 0, -1);
	$sql = "UPDATE $tableName SET $updateVal";
	echo $sql;
}




?>