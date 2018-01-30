<?php
class QueryGenerator{
	public function generatePSInsertQueries($dataArray,$tableName){
		$query = "INSERT INTO $tableName";
		$fields = "";
		$values = "";
		$bindParam = "";
		$variables = "";
		foreach ($dataArray as $data) {
			$fields .= $data["variableName"].",";
			$values .= "?,";
			$bindParam .= $this->getBindParam($data["dataType"]);
			$variables .= '$d->'.$data["variableName"].",";
		}
		$values = substr($values, 0,-1);
		$fields = substr($fields,0,-1);
		$variables = substr($variables,0,-1);
		return "\$sql = \$c->prepare(\"$query($fields)VALUES($values)\"); \$sql->bind_param('$bindParam',$variables);";
	}
	public function generatePSUpdateQueries($dataArray,$tableName){
		$query = "UPDATE $tableName SET";
		$fields = "";
		$bindParam = "";
		$variables = "";
		foreach ($dataArray as $data) {
			$fields .= $data["variableName"]." = ?, ";
			$bindParam .= $this->getBindParam($data["dataType"]);
			$variables .= '$d->'.$data["variableName"].",";
		}
		$fields = substr($fields,0,-2);
		$variables = substr($variables,0,-1);
		return "\$sql = \$c->prepare(\"$query $fields\"); \$sql->bind_param('$bindParam',$variables);";
	}
	public function getTableName($sql){ return str_replace("`","",explode(" ",$sql)[5]); }
	private function getBindParam($dt){
		if(in_array(strtolower($dt),array("bit","tinyint","bool","boolean","smallint","mediumint","int","integer","bigint","serial"))){
			return "i";
		}
		elseif(in_array(strtolower($dt),array("decimal","dec","float","double","double precision","float"))){
			return "d";
		}
		return "s";
	}
}
?>

