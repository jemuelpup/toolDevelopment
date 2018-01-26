cg.controller('codeGen',function($scope,dbOperations){
	console.log("working");
	$scope.generateCode = function(){
		dbOperations.processData("generateCode",$scope.createQuery).then(function(res){
			// console.log(res);
			console.log(res);
		});
		
	}
});