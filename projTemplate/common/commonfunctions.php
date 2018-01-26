<?php
/* **************************************************************************
reusable functions - optional
****************************************************************************/
function validateData($d){
	if(isset($d)){ return $d; }
	return "";
}
function validateDate($d){
	if(isset($d)){ return date("Y-m-d", strtotime(str_replace('/', '-',$d))); }
	return "0000-00-00";
}
function selectQuery($c,$sql){
	$resultSetArray = [];
	$res = $c->query($sql);
	if($res->num_rows>0){
		while($row = $res->fetch_assoc()){
			array_push($resultSetArray,$row);
		}
		return $resultSetArray;
	}
	return "";
}
// check if query produces output
function hasRows($c,$sql){
	$res = $c->query($sql);
	if($res->num_rows>0){
		return true;
	}
	return false;
}

/**************************************************************************/

?>