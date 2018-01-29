app.controller("login",function($scope,dbOperations){

	$scope.functionName = function(){
		dbOperations.processData("processName","").then(function(res){
			console.log(res);
		});
	}
	console.log("gumagana here");
});
