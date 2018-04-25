cg.controller('codeGen',function($scope,dbOperations){
	console.log("working");
	$scope.generateCode = function(){


		dbOperations.processData("generateCode",
			{"createQuery":$scope.createQuery,
			 "prefix":$scope.prefix}).then(function(res){
			// $
			console.log(res);
			$scope.insertQuery = res.insertQuery;
			$scope.updateQuery = res.updateQuery;
			$scope.htmlForm = res.htmlForm;
			$scope.updateModal = res.updateModal;
			$scope.tableData = res.tableData;
			$scope.phpInsertFunction = res.phpInsertFunction;
			$scope.generatePHPSwitchCase = res.generatePHPSwitchCase;
			$scope.selectQuery = res.selectQuery;
			$scope.angularController = res.angularController;
		});
		
	}
});