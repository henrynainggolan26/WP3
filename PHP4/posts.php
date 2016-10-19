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
	$datecreate = " ";
	if(isset($_GET['edit_id'])){
		$editid = $_GET['edit_id'];
		$sql = $con->select_update($editid);
		$result = mysqli_fetch_array($sql);
		if (!$sql) {
			die("Error: Data not found..");
		}
		$datecreate = $result['create_at'];
	}
	echo nl2br(" ". "<br>" . PHP_EOL);
	echo nl2br("Wellcome '" .$_SESSION['username']. "'". "<br>" . PHP_EOL);
	if(isset($_GET['edit_id'])){
		$editid = $_GET['edit_id'];
		$sql = $con->select_update($editid);
		$result = mysqli_fetch_array($sql);
		if (!$sql) {
			die("Error: Data not found..");
		}
		$title=$result['title'] ;
		$content= $result['content'];				
?>
<form action="" method="post">
	<table>
 		<tr> 
 			<td valign="top"><label>Title</label></td>
 			<td valign="top">:</td>
 			<td><input placeholder="Title" type="text" name="title" size="30" value="<?php echo $title ?>" required></td>
 		</tr>
 		<tr> 
			 <td valign="top"><label>Content</label></td>
			 <td valign="top">:</td>
			 <td><input placeholder="Content" type="text" name="content" size="30" value="<?php echo $content?>" required></td>
 		</tr>
 		<tr>
 			<td colspan="3" align="right"><button type="submit" name="save">Save</button></td>
 		</tr>
 	</table>
 </form>
<?php
	} 
	else {
?>
<form action="" method="post">
	<table>
 		<tr> 
 			<td valign="top"><label>Title</label></td>
 			<td valign="top">:</td>
 			<td><input placeholder="Title" type="text" name="title" size="30" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '';?>" required></td>
 		</tr>
 		<tr> 
			 <td valign="top"><label>Content</label></td>
			 <td valign="top">:</td>
			 <td><input placeholder="Content" type="text" name="content" size="30" value="<?php echo isset($_POST['content']) ? $_POST['content'] : '';?>" required></td>
 		</tr>
 		<tr>
 			<td colspan="3" align="right"><button type="submit" name="submit">Save</button></td>
 		</tr>
 	</table>
</form>
<?php
	}
?>

<?php 
	$user = $_SESSION['username'];

	//show data
	$result = $con->select();
	echo "<table border='1' cellpadding='10'>"; 
	echo "<tr> <th> ID Post </th> <th> Title</th>  <th> Content </th> <th> User ID </th> <th> Create at</th> <th> Update at </th> <th> Action </th></tr>";
	while ($test = mysqli_fetch_array($result)) {
		$id = $test['id_post'];
		echo "<tr align='left'>";	
		echo"<td><font color='black'>" .$test['id_post']."</font></td>";
		echo"<td><font color='black'>" .$test['title']."</font></td>";
		echo"<td><font color='black'>". $test['content']. "</font></td>";
		echo"<td><font color='black'>". $test['user_id']. "</font></td>";
		echo"<td><font color='black'>". $test['create_at']. "</font></td>";
		echo"<td><font color='black'>". $test['update_at']. "</font></td>";	
		echo"<td> <a href ='posts.php?edit_id=$id'> Edit</a> <a href ='posts.php?delete_id=$id'><center>Delete</center></a>";
		echo "</tr>";
	}
	echo "</table>";

	//insert data
	if(isset($_POST['submit'])){
		$date = date("Y-m-d H:i:s");
		$title = $_POST['title'];
		$content = $_POST['content'];
		$id_user = $_SESSION['id_user'];

		if($title && $content != ""){
			$con->insert($title, $content, $id_user, $date, $date);
			header("Refresh:0");
		}
		else{
			echo "Correct input";
		}
	}

	//edit data
	if(isset($_POST['save'])){
		$title = $_POST['title'];
		$content = $_POST['content'];
		$id_user = $_SESSION['id_user'];
		$dateupdate = date("Y-m-d H:i:s");
		if($title && $content != ""){
			$con->update($editid, $title, $content, $id_user, $datecreate, $dateupdate);
			header('Location: posts.php');
		}
		else{
			echo "Correct input";
		}	
	}

	//delete data
	if(isset($_GET['delete_id'])){
		$id = $_GET['delete_id'];
		$res = $con->delete($id);
		header('Location: posts.php');
	}
?>