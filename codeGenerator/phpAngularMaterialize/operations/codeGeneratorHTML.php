<?php

class CodeGeneratorHTML{
	public function generateInsertForm($dataArray,$tableName,$prefix="prefix"){
		$code = '
		<div class="'.$prefix.'">
			<h3>'.$tableName.'</h3>
			<form action="#" ng-submit="functionName()">
				'.$this->getInputFields($dataArray,$tableName,$prefix).'
				<button class="waves-effect waves-light btn" type="submit">Add</button>
				<button class="waves-effect waves-light btn">Clear</button>
			</form>
		</div>
		';
		return $code;
	}
	public function generateModalUpdateForm($dataArray,$tableName,$prefix="prefix"){
		$code = '
			<div id="$id" class="modal $id">
				<form ng-submit="editItem()">
					<div class="modal-content">
						<h4>'.$prefix.$tableName.'</h4>
						'.$this->getInputFields($dataArray,$tableName,$prefix).'
					</div>
					<div class="modal-footer">
		        		<button class="waves-effect waves-light btn" type="submit" ng-click="editItem()">Update</button>
		        	</div>
				</form>
			</div>
		';
		return $code;
	}
	public function generateTableData($dataArray,$tableName){
		$tHead = "";
		$tData = "";
		foreach ($dataArray as $data) {
			$tHead .= '<th>'.$data["variableName"].'</th>';
			$tData .= '<td>{{x.'.$data["variableName"].'}}</td>';
		}
		$code = '
			<div class="data-table-container">
				<table class="data-clickable">
				    <tbody>
				        <tr>'.$tHead.'</tr>
				        <tr ng-repeat="x in '.$tableName.'s" data-id="{{x.id}}" ng-click="'.$tableName.'Index($index,x.id)">'.$tData.'</tr>
				    </tbody>
				</table>
			</div>
		';
		return $code;
	}
	private function getInputFields($dataArray,$tableName,$prefix=""){
		$inputCode = "";
		foreach ($dataArray as $data) {
			$required = $data["required"] ? " required":"";
			$inputCode .= '
			<div class="input-field col s12">
			    <input ng-model="'.$prefix.$tableName.'Fields.'.$data["variableName"].'" name="'.$data["variableName"].'" value="" type="'.$this->getInputType($data["dataType"]).'" class="validate" maxlength="50"'.$required.'>
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