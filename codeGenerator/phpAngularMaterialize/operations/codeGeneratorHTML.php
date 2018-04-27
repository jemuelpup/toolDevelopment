<?php

class CodeGeneratorHTML{

	public function generateInsertForm($dataArray,$tableName){
		$tableName = substr($tableName, 0, -4);
		$code = '
		<div class="add'.ucfirst($tableName).'">
			<h3>Add '.$tableName.'</h3>
			<form action="#" ng-submit="addNew'.ucfirst($tableName).'($event)">
				'.$this->getInputFields($dataArray,$tableName,"add").'
				<button class="waves-effect waves-light btn" type="submit">Add</button>
				<button class="waves-effect waves-light btn">Clear</button>
			</form>
		</div>
		';
		return $code;
	}
	public function generateModalUpdateForm($dataArray,$tableName){
		$tableName = substr($tableName, 0, -4);
		$code = '
			<div id="edit'.ucfirst($tableName).'" class="modal edit'.ucfirst($tableName).'">
				<form ng-submit="edit'.ucfirst($tableName).'()">
					<div class="modal-content">
						<h4>'.$tableName.'</h4>
						'.$this->getInputFields($dataArray,$tableName,"edit",true).'
					</div>
					<div class="modal-footer">
		        		<button class="waves-effect waves-light btn modal-action modal-close" type="submit" ng-click="edit'.ucfirst($tableName).'()">Update</button>
		        	</div>
				</form>
			</div>
		';
		return $code;
	}
	public function generateTableData($dataArray,$tableName){
		$tHead = "";
		$tData = "";
		$tableName = substr($tableName, 0, -4);
		foreach ($dataArray as $data) {
			$tHead .= '<th>'.$data["variableName"].'</th>';
			$tData .= '<td>{{x.'.$data["variableName"].'}}</td>';
		}
		$code = '
		<div class="'.$tableName.'List">
			<h3>'.$tableName.' list</h3>
			<div class="data-table-container">
				<table class="data-clickable" ng-init="selected'.ucfirst($tableName).'Index=-1">
				    <tbody>
				        <tr>'.$tHead.'</tr>
				        <tr ng-repeat="x in '.$tableName.'s" ng-click="'.$tableName.'Index($index)" ng-class="{\'active\': $index === selected'.ucfirst($tableName).'Index}">'.$tData.'</tr>
				    </tbody>
				</table>
			</div>
			<a class="waves-effect waves-light btn" ng-click="editMaterialTrigger()">Edit</a>
			<a class="waves-effect waves-light btn" ng-click="delete'.ucfirst($tableName).'()">Delete</a>
		</div>
		';
		return $code;
	}
	private function getInputFields($dataArray,$tableName,$prefix="",$hasPlaceHolder=false){
		if(strlen($prefix)>0){
			$tableName = ucfirst($tableName);
		}
		$tableName = str_replace("_tbl", "", $tableName);
		$inputCode = "";
		$placeHolder = "";
		foreach ($dataArray as $data) {
			if($hasPlaceHolder){
				$placeHolder = "placeholder='".$data["variableName"]."'";
			}
			$required = $data["required"] ? " required":"";
			$inputCode .= '
			<div class="input-field col s12">
			    <input ng-model="'.$prefix.ucfirst($tableName).'Fields.'.$data["variableName"].'" name="'.$data["variableName"].'" value="" type="'.$this->getInputType($data["dataType"]).'" class="validate" maxlength="50" '.$placeHolder.' '.$required.'>
			    <label for="'.$data["variableName"].'">'.$data["variableName"].'</label>
			</div>
			';
		}
		return $inputCode;
	}
	private function getInputType($dt){
		if(in_array(strtolower($dt),array("bit","tinyint","bool","boolean","smallint","mediumint","int","integer","bigint","serial","decimal","dec","float","double","double precision","float"))){
			return "number";
		}
		elseif(in_array(strtolower($dt),array("date","datetime","timestamp","time","year"))){
			return "date";
		}
		return "text";
	}
}


?>