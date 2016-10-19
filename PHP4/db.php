<?php
	class DB_con
	{
		var $conn = false;

		function __construct(){
			$this->conn = mysqli_connect("localhost", "root", "ssmaju", "php_test");
			if(mysqli_connect_errno()){
				echo "error : Can't conncet to database";
			}
		}
		public function cek_login($username, $password){
			$query = "SELECT id_user,username,password FROM users WHERE username = '".$username."' AND password = '".$password."'" ;
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function select(){
			$query = "SELECT * FROM posts";
			$res=mysqli_query($this->conn, $query );
			return $res;
		}

		public function get_create_at_user($id){
			$query = "SELECT create_at FROM posts WHERE user_id = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function insert($title, $content, $user_id, $create_at, $update_at){
			$query = "INSERT INTO posts (title, content, user_id, create_at, update_at) 
			VALUES ('".$title."','".$content."','".$user_id."','".$create_at."','".$update_at."')";
			$res = mysqli_query($this->conn, $query);
			return $res;

		}

		public function delete($id){
			$query = "DELETE FROM posts WHERE id_post = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function select_update($id){
			$query = "SELECT * FROM posts WHERE id_post = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function update($id, $title, $content, $user_id, $create_at, $update_at){
			$query="UPDATE posts SET title='$title', content='$content', user_id='$user_id', create_at='$create_at', update_at='$update_at' WHERE id_post = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}
		public function updatepass($passwordnew, $passwordold){
			$query="UPDATE users SET password='$passwordnew' WHERE password = '".$passwordold."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}
	}
?>