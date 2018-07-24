<?php

class CodeGeneratorAngular{

	public function generateControllerCode($tableName){
		$tableName = substr($tableName, 0, -4);
		$code = '$scope.'.$tableName.'s = [];
$scope.add'.ucfirst($tableName).'Fields = {};
$scope.edit'.ucfirst($tableName).'Fields = {};

function get'.ucfirst($tableName).'s(){
	dbOperations.views("Get'.ucfirst($tableName).'s","").then(function(res){
		$scope.'.$tableName.'s = res;
		$(".modal").modal();
	});
}

$scope.'.$tableName.'Index = function('.$tableName.'){
	$scope.edit'.ucfirst($tableName).'Fields = $scope.edit'.ucfirst($tableName).'Fields == '.$tableName.' ? {} : '.$tableName.';
	
	console.log($scope.edit'.ucfirst($tableName).'Fields);
}
$scope.edit'.ucfirst($tableName).'Trigger = function(){
	if($scope.edit'.ucfirst($tableName).'Fields.id){
		$("#edit'.ucfirst($tableName).'").modal("open");
	}
	else{
		alert("Select '.$tableName.' first");
	}
}
$scope.edit'.ucfirst($tableName).' = function(){
	dbOperations.processData("Edit'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
		get'.ucfirst($tableName).'s();
		$("#edit'.ucfirst($tableName).'").modal("close");
	});
}
$scope.delete'.ucfirst($tableName).' = function(){
	if($scope.edit'.ucfirst($tableName).'Fields.id){
		if(confirm("Are you sure you want to delete this '.$tableName.'?")){
			dbOperations.processData("Remove'.ucfirst($tableName).'",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
				get'.ucfirst($tableName).'s();
				alert("'.ucfirst($tableName).' deleted");
			});
		}
	}
	else{
		alert("Select '.$tableName.' first");
	}
}
$scope.addNew'.ucfirst($tableName).' = function(){
	dbOperations.processData("AddNew'.ucfirst($tableName).'",$scope.add'.ucfirst($tableName).'Fields).then(function(res){
		alert("New '.$tableName.' available.")
		get'.ucfirst($tableName).'s();
	});
}
$scope.add'.ucfirst($tableName).'StockTrigger = function(){
	if($scope.edit'.ucfirst($tableName).'Fields.id){
		$("#add'.ucfirst($tableName).'Stock").modal("open");
	}
	else{
		alert("Select '.$tableName.' first");
	}
}
$scope.add'.ucfirst($tableName).'Stock = function(e){
	dbOperations.processData("Edit'.ucfirst($tableName).'AddStock",$scope.edit'.ucfirst($tableName).'Fields).then(function(res){
		alert("'.ucfirst($tableName).' Stock updated.");
		get'.ucfirst($tableName).'s();
		$("#add'.ucfirst($tableName).'Stock").modal("close");
	});
	console.log(edit'.ucfirst($tableName).'Fields);
}
get'.ucfirst($tableName).'s();';
		return $code;
	}
	
}


?>