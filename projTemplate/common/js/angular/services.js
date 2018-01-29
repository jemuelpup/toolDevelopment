/*
@param:
process(String),
dataInputs(Object), -like in serialize array in jqueyr
callback(Function) - function call after the request
*/
app.service('dbOperations',function($http){
	this.processData = function(process,dataInputs){
		return $http({
			method:"POST",
			url:"/admin/functions.php",
			data: { 'process': process, 'data': dataInputs }
		}).then(function success(res){
			return res;
		}, function error(err) {
			console.log(err);
	    });
	}
});
