<?php

class CodeGeneratorPHP{
	public function generatePHPFuncInsertUpdate($tableName){
		$tableName = substr($tableName, 0, -4);
		return "function insert".ucfirst($tableName)."(\$c,\$d){}
		function update".ucfirst($tableName)."(\$c,\$d){}
		function select".ucfirst($tableName)."(\$c){}";
	}
	public function generatePHPSwitchCase($tableName){
		$tableName = substr($tableName, 0, -4);
		return "case \"AddNew".ucfirst($tableName)."\":{insert".ucfirst($tableName)."(\$conn,\$data);}break;
		case \"Edit".ucfirst($tableName)."\":{update".ucfirst($tableName)."(\$conn,\$data);}break;
		case \"Get".ucfirst($tableName)."s\":{select".ucfirst($tableName)."(\$conn);}break;";
	}

}

?>