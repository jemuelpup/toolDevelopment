<?php

include 'lexicalAnalizer.php';
include 'codeGeneratorSQLQuery.php';
include 'codeGeneratorHTML.php';

class MainFunct{
	// class variables
	public $lex,$qg; // for lexical analizer

	function generate($query,$prefix){
		/* instantiate class */
		$this->lex = new LexicalAnalizer();
		$this->qg = new QueryGenerator();
		$this->HTML = new CodeGeneratorHTML();

		/* get the formatted data (The inputs)*/
		$structuredData = $this->lex->getTokens($query);
		$tableName = $this->qg->getTableName($query);

		/* use generator functions */

		echo "{
			\"insertQuery\":\"".$this->qg->generatePSInsertQueries($structuredData,$tableName)."\",
			\"updateQuery\":\"".$this->qg->generatePSUpdateQueries($structuredData,$tableName)."\",
			\"htmlForm\":\"".$this->HTML->generateInsertForm($structuredData,$tableName,"")."\",
			\"updateModal\":\"".$this->HTML->generateModalUpdateForm($structuredData,$tableName,$prefix)."\",
			\"tableData\":\"".$this->HTML->generateTableData($structuredData,$tableName,$prefix)."\",
		}";
	}


	function getCodes(){
		echo "{
			\"htmlForms\":\"".createHTMLForms($jsonObject)."\",
			\"insertQuery\":\"".addFunctionCall("getFieldValue",createInsertQueries($jsonObject))."\",
			\"updateQuery\":\"".addFunctionCall("getFieldValue",createUpdateQueries($jsonObject))."\",
			\"updateQueryStoredProcedure\":\"".addFunctionCall("getFieldValue",createUpdateQueriesStoredProcedure($jsonObject))."\",
			\"selectQuery\":\"".createSelectQueries($jsonObject)."\",
			\"dataTable\":\"".createDynamicDataTable($jsonObject)."\",
			\"viewDataTableFunc\":\"".createPHPselect($jsonObject)."\",
			\"viewHTMLModalUpdate\":\"".createModalViewForEditting($jsonObject)."\"
		}";
	}
}

$main = new MainFunct();


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
	case "generateCode":{
		 
		$main->generate($data,"edit-");
	}
}



$q = "CREATE TABLE IF NOT EXISTS `employee_tbl` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `position_fk` int(11) DEFAULT NULL,
  `branch_fk` int(11) DEFAULT NULL,
  `salary` decimal(11,2) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_fk` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `birth_day` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;";




?>