<?php



$query = "CREATE TABLE IF NOT EXISTS `tbl_role` (
`role_id` int(11) NOT NULL,
  `role_title` varchar(50) NOT NULL,
  `role_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
	
$formattedQuery = formatStringForCodeGeneration($query);
$jsonObject = json_decode(formatData($formattedQuery));

createHTMLForms($jsonObject); echo "<hr>";
createInsertQueries($jsonObject); echo "<hr>";
createUpdateQueries($jsonObject); echo "<hr>";







/*********************************************************************************************************
* Database process Area **********************************************************************************
* This is the area where all the queries are generated
*********************************************************************************************************/
function createInsertQueries($jsonObject){
	$tableName = "";
	$fields = "";
	$values = "";
	
	foreach($jsonObject as $object){
		$tableName = $object->tableName;
		foreach($object->data as $key){
			$fields .= $key->columnName.",";
			if ($key->dataType == "str") {	$values .= "'$".$key->columnName."',";	}
			elseif("num") {	$values .= "$".$key->columnName.",";	};
		}
	}
	$fields = "(".substr($fields, 0, -1).")";
	$values = "(".substr($values, 0, -1).")";
	$sql = "INSERT INTO $tableName $fields VALUES $values";
	echo "$sql<br><br>";
}

function createUpdateQueries($jsonObject){
	$tableName = "";
	$updateVal = "";
	
	foreach($jsonObject as $object){
		$tableName = $object->tableName;
		foreach($object->data as $key){
			if ($key->dataType == "str") {	$updateVal .= "$key->columnName = '$$key->columnName',";	}
			elseif("num") {	$updateVal .= "$key->columnName = $$key->columnName,";	};
		}
	}
	$updateVal = substr($updateVal, 0, -1);
	$sql = "UPDATE $tableName SET $updateVal";
	echo "$sql<br><br>";
}



















/*********************************************************************************************************
* UI/UX Development Area **********************************************************************************
* This is the area where all the forms and usefull code in user view is found
* Note: some code here can be copy paste in your page
*********************************************************************************************************/

function createHTMLForms($jsonObject){
	foreach($jsonObject as $object){
		//	echo $object->tableName;
		foreach($object->data as $jsonData){
			$inputType = "text";
			if($jsonData->dataType=="num"){
				$inputType = "number";
			}
			echo "
			<label for='$jsonData->columnName'>$jsonData->columnName</label>
			<input type='$inputType' class='' name='$jsonData->columnName' maxlength='$jsonData->length' $jsonData->attribute/>
			";
		}
	}
}

function createDynamicDataTable($jsonObject){
//	<table>
//		<tr>
//			<th>Company</th>
//			<th>Contact</th>
//			<th>Country</th>
//		</tr>
//		<tr>
//			<td>Alfreds Futterkiste</td>
//			<td>Maria Anders</td>
//			<td>Germany</td>
//		</tr>
//	</table>
}










/*********************************************************************************************************
* Data Processing Area ***********************************************************************************
* This is the area where all the needed data to be processed was prepared
*********************************************************************************************************/

/*******************************************************************
This function returns an array of needed data in input field
return: JSON data (tableName, data)
Data contains contents:
	columnName-colName
	dataType-dataType // str or num
	attribute-attribute
	length-maxLength
*******************************************************************/
function formatData($formattedQuery){
	$start = 0;
	$state1 = 1;
	$state2 = 2;
	$state3 = 3;
	$state4 = 4;
	$state5 = 5;
	$state6 = 6;
	$state7 = 7;
	$state8 = 8;
	$state9 = 9;
	$state10 = 10;
	$state11 = 11;
	$state12 = 12;
	$stateEnd = 999;
	$state = $start;

	$tableName = "";
	$colName = "";
	$dataType = "";
	$attribute = "";
	$maxLength = "";
	$colNameAndType = [];
	$dataJSON = "";
	
	foreach($formattedQuery as $queryWord){
		switch ($state) {
			case $start:{
				if($queryWord=='CREATE'){
					$state = $state1;
				}
				else{
					$state = $stateEnd;
				}
			}break;
			case $state1:{
				if($queryWord=='TABLE'){
					$state = $state2;
				}
				else{
					$state = $stateEnd;
				}
			}break;
			case $state2:{// check the opening parenthesis and get the tableName
				if($queryWord=='('){
					$state = $state3;
				}
				else{
					$state = $state2;
					$tableName = $queryWord;
				}
			}break;
			case $state3:{ // the column name
				$colName = "";
				$dataType = "";
				$attribute = "";
				$maxLength = "";
				
				$colName = $queryWord;
				$state = $state4;
			}break;
			case $state4:{ // the data type
				if(
					strtolower($queryWord)==strtolower("INT") or
					strtolower($queryWord)==strtolower("SMALLINT") or
					strtolower($queryWord)==strtolower("TINYINT") or
					strtolower($queryWord)==strtolower("MEDIUMINT") or
					strtolower($queryWord)==strtolower("BIGINT") or
					strtolower($queryWord)==strtolower("FLOAT") or
					strtolower($queryWord)==strtolower("DOUBLE") or
					strtolower($queryWord)==strtolower("BIT") or
					strtolower($queryWord)==strtolower("DECIMAL")
				){
					$dataType = "num";
				}
				elseif(
					strtolower($queryWord)==strtolower("time") or
					strtolower($queryWord)==strtolower("date") or
					strtolower($queryWord)==strtolower("smalldatetime") or
					strtolower($queryWord)==strtolower("datetime") or
					strtolower($queryWord)==strtolower("datetime2") or
					strtolower($queryWord)==strtolower("datetimeoffset") 
				){
					$dataType = "date";
				}
				else{
					$dataType = "str";
				}
				$state = $state5;
			}break;
			case $state5:{ // for checking if the datatype has attribute
				if($queryWord=='('){
					$state = $state6;
				}
				elseif($queryWord==','){
					$state = $state3;
					array_push($colNameAndType,array("columnName"=>$colName,"dataType"=>$dataType,"attribute"=>$attribute,"length"=>$maxLength));
				}
				elseif($queryWord=='NOT'){
					$state = $state9;
				}
				else{ $state = $state8; }
			}break;
			case $state6:{ // This is the maximum numbers of character of the string
				$maxLength = $queryWord;
				$state = $state7;
			}break;
			case $state7:{ if($queryWord==')'){ $state = $state8; } else{ $state = $state10; } }break;
			case $state8:{
				if($queryWord=='NOT'){ $state = $state9; }
				else if($queryWord==','){
					$state = $state3;
					array_push($colNameAndType,array("columnName"=>$colName,"dataType"=>$dataType,"attribute"=>$attribute,"length"=>$maxLength));
				}
				else{ $state = $state3; }
			}break;
			case $state9:{
				if($queryWord=='NULL'){
					$state = $state10;
					$attribute="required";
				}
				else{ $state = $state10; }
			}break;
			case $state10:{
				if($queryWord==','){
					$state = $state3;
					array_push($colNameAndType,array("columnName"=>$colName,"dataType"=>$dataType,"attribute"=>$attribute,"length"=>$maxLength));
				}
				elseif($queryWord==')'){
					$state = $stateEnd;
					array_push($colNameAndType,array("columnName"=>$colName,"dataType"=>$dataType,"attribute"=>$attribute,"length"=>$maxLength));
				}
				else{
					$state = $state10;
				}
			}break;
			case $stateEnd:{ }break;
		}
		if($start == $stateEnd) break 2;
	}
	
	$tableData = array();
	$tname = array(
		'tableName' => $tableName
	);
	array_push($tableData, array_merge($tname, array('data' => $colNameAndType)));
	return json_encode($tableData);
	
}


// This function returns array of generated String
function formatStringForCodeGeneration($query){
	$query = trim(preg_replace('/\s+/', ' ', $query));// trim removes space before and after the string
	$query = str_replace('(', ' ( ', $query);
	$query = str_replace(')', ' ) ', $query);
	$query = str_replace(',', ' , ', $query);
	$query = str_replace('`', '', $query);
	$query = preg_replace('/\s+/', ' ', $query);
	return explode(' ',$query);
}






















/*********************************************************************************************************
* Tool creation Area *************************************************************************************
* This is the area where all useful code to create tools was prepared
*********************************************************************************************************/

/* Functions for creating finite State machines */
function createCase(){
	for($i=0; $i<13; $i++){
		//		echo "\$state$i = $i,<br>";
	}
	for($i=0; $i<13; $i++){
		echo "
		case \$state$i:{
		if(\$queryWord==''){
			\$state = \$state;
			}
			else{
			\$state = \$state;
			}
		}break;<br>";
	}
}







/**************************/
function createHTMLFormsTest($jsonObject){
	foreach($jsonObject as $object){
		//	echo $object->tableName;
		foreach($object->data as $jsonData){
			$inputType = "text";
			$dummyValues = "hahhahah";
			if($jsonData->dataType=="num"){
				$inputType = "number";
				$dummyValues = "'0'";
			}
			echo "
			<label for='$jsonData->columnName'>$jsonData->columnName</label>
			<input type='$inputType' class='' name='$jsonData->columnName' maxlength='$jsonData->length' value=$dummyValues $jsonData->attribute/>
			";
		}
	}
}















/* Future useful function */
/****************************************************************************
* This function echo all the keys and values of an object
****************************************************************************/
function getTheKeysAndValueOfObject($jsonObject){
	$tableName = "";
	//	$sql = "INSERT INTO $tableName ";
	foreach($jsonObject as $object){
		$tableName = $object->tableName;
		foreach($object->data as $key){
			while ($val = current($key)) {
				/*Note
					$key - The data type
					$val - Literal value
				*/
				echo key($key)."=".$val."---";
				next($key);
			}
			echo "<hr>";
		}
	}

}

?>