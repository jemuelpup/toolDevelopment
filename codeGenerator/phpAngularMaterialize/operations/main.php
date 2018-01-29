<?php

include 'lexicalAnalizer.php';
include 'codeGeneratorSQLQuery.php';
include 'codeGeneratorHTML.php';
include 'codeGeneratorPHP.php';

class MainFunct{
	// class variables
	public $lex,$qg; // for lexical analizer
	function generate($query,$prefix=""){
		/* instantiate class */
		$this->lex = new LexicalAnalizer();
		$this->qg = new QueryGenerator();
		$this->HTML = new CodeGeneratorHTML();
		$this->php = new CodeGeneratorPHP();
		/* get the formatted data (The inputs)*/
		$structuredData = $this->lex->getTokens($query);
		$tableName = $this->qg->getTableName($query);
		/* use generator functions */
		$generatedData = array(
			"insertQuery"=>$this->qg->generatePSInsertQueries($structuredData,$tableName),
			"updateQuery"=>$this->qg->generatePSUpdateQueries($structuredData,$tableName),
			"htmlForm"=>$this->HTML->generateInsertForm($structuredData,$tableName,""),
			"updateModal"=>$this->HTML->generateModalUpdateForm($structuredData,$tableName,$prefix),
			"tableData"=>$this->HTML->generateTableData($structuredData,$tableName,$prefix),
			"phpInsertFunction"=>$this->php->generatePHPFuncInsertUpdate($tableName),
			"generatePHPSwitchCase"=>$this->php->generatePHPSwitchCase($tableName)
		);
		print_r(json_encode($generatedData));
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
		$main->generate(str_replace("\n","",$data->createQuery),validateData($data->prefix));
	}
}

function validateData($data){
	return (isset($data)) ? $data:"";
}



?>