<?php

class CodeGeneratorAngular{

	public function generateControllerCode($tableName){
		$tableName = substr($tableName, 0, -4);
		$code = '$scope.'.$tableName.'s = [];
		$scope.'.$tableName.'Fields = {};
		$scope.edit'.ucfirst($tableName).'Fields = {};

		function get'.ucfirst($tableName).'s(){
			dbOperations.views("get'.ucfirst($tableName).'s","").then(function(res){
				$scope.'.ucfirst($tableName).'s = res;
				$(\'select\').material_select();
			});
		}

		$scope.'.$tableName.'Index = function(i,id){
			$scope.edit'.ucfirst($tableName).'Fields = ($scope.'.$tableName.'s)[i];
		}
		$scope.edit'.ucfirst($tableName).'Trigger = function(){
			$(\'#edit'.ucfirst($tableName).'\').modal(\'open\');
		}
		$scope.edit'.ucfirst($tableName).' = function(){
			dbOperations.processData("Edit'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
				get'.ucfirst($tableName).'();
			});
		}
		$scope.delete'.ucfirst($tableName).' = function(){
			dbOperations.processData("Remove'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
				get'.ucfirst($tableName).'s();
			});
		}
		$scope.addNew'.ucfirst($tableName).' = function(){
			dbOperations.processData("Add'.ucfirst($tableName).'",$scope.'.$tableName.'Fields).then(function(res){
				alert("New '.$tableName.' available.")
				get'.ucfirst($tableName).'s();});
		}';
		return $code;
	}
	
}


?>