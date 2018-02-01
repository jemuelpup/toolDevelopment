<?php

class CodeGeneratorPHP{
	public function generatePHPFuncInsertUpdate($tableName){
		return "function insert".ucfirst(str_replace("_tbl", "", $tableName))."(\$c,\$d){}function update".ucfirst(str_replace("_tbl", "", $tableName))."(\$c,\$d){}function select".ucfirst(str_replace("_tbl", "", $tableName))."(\$c){}";
	}
	public function generatePHPSwitchCase($tableName){
		return "case \"Add".ucfirst(str_replace("_tbl", "", $tableName))."\":{insert".ucfirst(str_replace("_tbl", "", $tableName))."(\$conn,\$data);}break;case \"Edit".ucfirst(str_replace("_tbl", "", $tableName))."\":{update".ucfirst(str_replace("_tbl", "", $tableName))."(\$conn,\$data);}break;case \"Get".ucfirst(str_replace("_tbl", "", $tableName))."\":{select".ucfirst(str_replace("_tbl", "", $tableName))."(\$conn);}break;";
	}

}

?>