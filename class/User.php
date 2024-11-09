<?php
class User {

	private $userTable = 'crm_users';
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	public function login(){
		if ($this->email && $this->password){
			$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE email = ? AND password = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("ss", $this->email, $this->password);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0){
				$user = $result->fetch_assoc();
				$_SESSION['userid'] = $user['id'];
				$_SESSION['rol'] = $user['rol'];
				$_SESSION['name'] = $user['email'];
				$_SESSION['nombre'] = $user['name'];

				return 1;
			}else{
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function loggedIn (){
		if (!empty($_SESSION['userid'])) {
			return 1;
		}else {
			return 0;
		}
	}

	public function getUsers(){
		$sqlQuery = 'SELECT * FROM crm_users';

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();

		$result = $stmt->get_result();

		$usuarios = array();

		while ($usuario = $result->fetch_assoc()) {
			$usuarios[] = $usuario["name"];
		}
		return $usuarios;
	}

}
?>