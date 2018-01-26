/*
@param:
process(String),
dataInputs(Object), -like in serialize array in jqueyr
callback(Function) - function call after the request
*/
cg.service('dbOperations',function($http){
	// this is responsible for insertion and updating of data
	this.processData = function(process,dataInputs,callback){
		return $http({
			method:"POST",
			url:"/codeGenerator/phpAngularMaterialize/operations/main.php",
			data: {
				'process': process,
				'data': dataInputs
			}
		}).then(function success(res){
			return res.data;
		}, function err(response) {
			return "Something wrong in intranet connection. Check the server.";
	    });
	}
	
});