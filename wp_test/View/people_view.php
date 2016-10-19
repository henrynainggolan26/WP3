<?php
	$username = "root";
	$password = "ssmaju";
	$dbname = "test_wordpress";
	$servername = "localhost"; 
 
	$connection = mysqli_connect($servername, $username, $password, $dbname);



	if (isset($_POST['submit'])) {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		mysqli_query($connection, 'insert into xxxxx');

	}
?>

<form action="" method="post">
First Name: <input type="text" name="firstname"><br /><br />
Last Name: <input type="text" name="lastname"><br /><br />
Gender: <input type="radio" name="gender" value="male"> male <input type="radio" name="gender" value="famale"> famale <br /><br />
E-mail: <input type="text" name="email"><br /><br />
Phone: <input type="text" name="phone"><br /><br />
Address: <input type="text" name="address"><br /><br />
<input type="submit" value='1' name='submit'>
</form>


<?php

$results = 'xxxxx';

foreach ($results as $key => $value) {
	
}
