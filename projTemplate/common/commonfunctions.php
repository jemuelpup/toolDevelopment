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
/**************************************************************************/

?>