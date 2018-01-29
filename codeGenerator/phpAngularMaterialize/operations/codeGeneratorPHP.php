<?php

class CodeGeneratorPHP{
	public function generatePHPFuncInsertUpdate($tableName){
		return "function insert".ucfirst($tableName)."(\$c,\$d){}function update".ucfirst($tableName)."(\$c,\$d){}";
	}
	public function generatePHPSwitchCase($tableName){
		return "case \"Add".ucfirst($tableName)."\":{insert".ucfirst($tableName)."(\$conn,\$data);}break;case \"Edit".ucfirst($tableName)."\":{update".ucfirst($tableName)."(\$conn,\$data);}break;";
	}



}

?>