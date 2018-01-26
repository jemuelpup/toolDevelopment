<?php
require('../../toolDevelopment.php');

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Untitled Document</title>
		<meta charset="UTF-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="css/modal.css">
	</head>
	<body>
		<form id="inputForms" action="test.php" method="post">
			<?php
				createHTMLFormsTest($jsonObject);
			?>
		</form>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/modal.js"></script>
		<script>
			$(document).ready(function(){
				
				$( "#inputForms" ).submit(function( event ) {
					saveToDatabase($(this),"test.php");
				});
				
				/**********************************************************************************
				* This function will save all the data in the input field of the given form
				* @param:
				* inputForm - this is the form selector
				* phpURL - This is the php file that will save the datas in the input field
				**********************************************************************************/
				function saveToDatabase(inputForm,phpURL){
					event.preventDefault();
					var allInputs = [];
					inputForm.find('input').map(function (i,e){
						allInputs.push({
							name: $(e).attr("name"),
							type: $(e).attr("type"),
							val: $(e).val()
						});
					});
					$.ajax({
						url: phpURL,
						type: 'POST',
						data: { data: allInputs},
						success: function(result){
							console.log(result)
						},
						error: function () {
							alert("Something wrong.");
						}
					});
					
				}
			});
		</script>
	</body>
</html>