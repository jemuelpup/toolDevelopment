<!DOCTYPE html>
<html>
<body>

<?php
	if(isset($_GET["submit"])) {
		$path = str_replace('\\', '/', $_GET["path"]);
		$directory = $path."/";
		$difflist = file_get_contents(substr($path, 0,strrpos($path,'/')).'/'.$_GET["deliveryFile"]); // this is the input
		$listArray = explode("\n", $difflist);



		foreach($listArray as $fileLoc){
			if(trim($fileLoc)!='' and substr(trim($fileLoc),-5)!='none'){
				$filename = $directory.trim($fileLoc);
				if (file_exists($filename)) {
					echo "<p>$filename exists</p>";
				} else {
					echo "<p style='color:red;'>$filename does not exist</p>";
				}
			}
		}
	}
	
?>



<h1>Delivery file checker</h1>
<form action="/JOFileChecker.php" method="get">
  First name: <input type="text" name="path"><br>
  Delivery file: <input type="file" name="deliveryFile"><br>  
  <input type="submit" name="submit" value="Submit">
</form> 



</body>
</html>


