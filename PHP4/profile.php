<?php
	include_once('menu.php');
	session_start();
	//set session when logout 
	if(isset($_SESSION['username'])){
		header('location:index.php'); 
	}
	//
	include_once 'db.php';
	$con = new DB_con();
	echo nl2br(" ". "<br>" . PHP_EOL);	
	echo nl2br("Welcome : " .$_SESSION['username']. "<br>" . PHP_EOL);  
?>
<form action="" method="post">
	<table>
 		<tr> 
 			<td valign="top"><label>Password Old</label></td>
 			<td valign="top">:</td>
 			<td><input placeholder="Password old" type="password" name="passwordold" required></td>
 		</tr>
 		<tr> 
			 <td valign="top"><label>Password New</label></td>
			 <td valign="top">:</td>
			 <td><input placeholder="Password new" type="password" name="passwordnew" required></td>
 		</tr>
 		<tr>
 			<td colspan="3" align="right"><button type="submit" name="update">Update</button></td>
 		</tr>
 	</table>
</form>
<?php
	if(isset($_POST['update'])){
		$passwordold = $_POST['passwordold'];
		$passwordnew = $_POST['passwordnew'];
		$con->updatepass($passwordnew,$passwordold);
		header('Location: profile.php');
	}	
?>
