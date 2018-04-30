<?php

class CodeGeneratorAngular{

	public function generateControllerCode($tableName){
		$tableName = substr($tableName, 0, -4);
		$code = '$scope.'.$tableName.'s = [];
		$scope.add'.ucfirst($tableName).'Fields = {};
		$scope.edit'.ucfirst($tableName).'Fields = {};
		$scope.selected'.ucfirst($tableName).'Index = -1;

		function get'.ucfirst($tableName).'s(){
			dbOperations.views("Get'.ucfirst($tableName).'s","").then(function(res){
				$scope.'.$tableName.'s = res;
				$(\'select\').material_select();
				$(\'.modal\').modal();
			});
		}
		$scope.delete'.$tableName.' = function(){
			if (confirm("Are you sure you want to delete this '.$tableName.'?")) {
				dbOperations.processData("Remove'.$tableName.'",$scope.edit'.$tableName.'Fields).then(function(res){
					get'.$tableName.'s();
				});
			}
		}
		$scope.'.$tableName.'Index = function(i,id){
			$scope.edit'.ucfirst($tableName).'Fields = ($scope.'.$tableName.'s)[i];
			$scope.selected'.ucfirst($tableName).'Index = $scope.selected'.ucfirst($tableName).'Index===i ? -1 : i;
		}
		$scope.edit'.ucfirst($tableName).'Trigger = function(){
			if($scope.selected'.ucfirst($tableName).'Index == -1){
				alert("Select '.$tableName.' first");
			}
			else{
				$(\'#edit'.ucfirst($tableName).'\').modal(\'open\');
			}
		}
		$scope.edit'.ucfirst($tableName).' = function(){
			dbOperations.processData("Edit'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
				get'.ucfirst($tableName).'s();
			});
		}
		$scope.delete'.ucfirst($tableName).' = function(){
			dbOperations.processData("Remove'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
				get'.ucfirst($tableName).'s();
			});
		}
		$scope.addNew'.ucfirst($tableName).' = function(e){
			e.preventDefault();
			dbOperations.processData("AddNew'.ucfirst($tableName).'",$scope.add'.ucfirst($tableName).'Fields).then(function(res){
				alert("New '.$tableName.' available.")
				get'.ucfirst($tableName).'s();});
		}
		get'.ucfirst($tableName).'s();';
		return $code;
	}
	
}


?>