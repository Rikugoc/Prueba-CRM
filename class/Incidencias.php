<?php
class Tasks {	
   
	private $userTable = 'crm_users';
	private $incidenciasTable = 'crm_incidencias';	
	private $asignacionesTable = 'crm_asignaciones';			
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listIncidencias(){
		
		$sqlWhere = '';

		if($_SESSION["rol"] == '2') { 
			
			$sqlQuery = "SELECT * FROM crm_incidencias";
			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();	
			
			$displayRecords = $result->num_rows;
			$records = array();		
			while ($tasks = $result->fetch_assoc()) {

				$asignados = array();

				$sqlQuery1 = "SELECT * FROM crm_asignaciones WHERE id_incidencia = ".$tasks['id'];
			
				$stmt1 = $this->conn->prepare($sqlQuery1);
				$stmt1->execute();
				$result1 = $stmt1->get_result();

				while ($asignaciones = $result1->fetch_assoc()) {
					$sqlQuery2 = "SELECT * FROM crm_users WHERE id = ".$asignaciones['id_usuario'];

					$stmt2 = $this->conn->prepare($sqlQuery2);
					$stmt2->execute();
					$result2 = $stmt2->get_result();

					while ($usuarios = $result2->fetch_assoc()) {
						$asignados[] = " ".$usuarios['email'];
					}

				}

				$rows = array();			
				$rows[] = $tasks['id'];
				$rows[] = $tasks['titulo'];			
				$rows[] = $tasks['Descripcion'];
				switch ($tasks['Estado']){
					case '1':
						$rows[] = "To Do";
						break;
					case '2':
						$rows[] = "Doing";
						break;
					case '3':
						$rows[] = "Done";
						break;
					default:
						$rows[] = $tasks['Estado'];
				}
				
				$rows[] = $asignados;
				$rows[] = '<button type="button" name="update" id="'.$tasks["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
				$rows[] = '<button type="button" name="delete" id="'.$tasks["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
				$records[] = $rows;
			}
			
			$output = array(
				"draw"	=>	intval($_POST["draw"]),
				"data"	=> 	$records
			);
			
			echo json_encode($output);

		}	

		if($_SESSION["rol"] == '1') { 

			$sqlQueryTMP = "SELECT * FROM crm_asignaciones WHERE id_usuario = ".$_SESSION["userid"];

			$stmtTMP = $this->conn->prepare($sqlQueryTMP);
			$stmtTMP->execute();
			$resultTMP = $stmtTMP->get_result();

			$records = array();	

			while ($TasksTMP = $resultTMP->fetch_assoc()) {
			
				$sqlQuery = "SELECT * FROM crm_incidencias WHERE id = ".$TasksTMP['id_incidencia'];
				
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$result = $stmt->get_result();	
				
				$displayRecords = $result->num_rows;	
				while ($tasks = $result->fetch_assoc()) {

					$asignados = array();

					$sqlQuery1 = "SELECT * FROM crm_asignaciones WHERE id_incidencia = ".$tasks['id'];
				
					$stmt1 = $this->conn->prepare($sqlQuery1);
					$stmt1->execute();
					$result1 = $stmt1->get_result();

					while ($asignaciones = $result1->fetch_assoc()) {
						$sqlQuery2 = "SELECT * FROM crm_users WHERE id = ".$asignaciones['id_usuario'];

						$stmt2 = $this->conn->prepare($sqlQuery2);
						$stmt2->execute();
						$result2 = $stmt2->get_result();

						while ($usuarios = $result2->fetch_assoc()) {
							$asignados[] = " ".$usuarios['email'];
						}

					}

					$rows = array();			
					$rows[] = $tasks['id'];
					$rows[] = $tasks['titulo'];			
					$rows[] = $tasks['Descripcion'];
					switch ($tasks['Estado']){
						case '1':
							$rows[] = "To Do";
							break;
						case '2':
							$rows[] = "Doing";
							break;
						case '3':
							$rows[] = "Done";
							break;
						default:
							$rows[] = $tasks['Estado'];
					}
					$rows[] = $asignados;
					$rows[] = '<button type="button" name="update" id="'.$tasks["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';			
					$rows[] = '<button type="button" name="delete" id="'.$tasks["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';			
					$records[] = $rows;
				}
				
				$output = array(
					"draw"	=>	intval($_POST["draw"]),
					"data"	=> 	$records
				);

			}

			echo json_encode($output);

		}

	}

	public function insert(){
		
		if($this->Titulo) {
			$sqlQuery = "INSERT INTO crm_incidencias (titulo, Descripcion, Estado) VALUES ('".$this->Titulo."', '".$this->Descripcion."', '".$this->Estado."')";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();

			if ($this->Asignado != "Nadie"){
				$sqlQuerySearchUser = "SELECT * FROM crm_users WHERE name = '".$this->Asignado."'";
				$stmtSearchUser = $this->conn->prepare($sqlQuerySearchUser);
				$stmtSearchUser->execute();
				$resultUser = $stmtSearchUser->get_result();
				while ($usuario = $resultUser->fetch_assoc()) {
					$sqlQuerySearchLastTask = "SELECT * FROM crm_incidencias ORDER BY id DESC LIMIT 1";
					$stmtSearchLastTask = $this->conn->prepare($sqlQuerySearchLastTask);
					$stmtSearchLastTask->execute();
					$resultLastTask = $stmtSearchLastTask->get_result();
					while($lastTask = $resultLastTask->fetch_assoc()) {
						$sqlQuery1 = "INSERT INTO crm_asignaciones (id_incidencia, id_usuario) VALUES ('".$lastTask["id"]."', '".$usuario["id"]."')";
						$stmt1 = $this->conn->prepare($sqlQuery1);
						$stmt1->execute();
					}
				}
			}
		}
	}

	public function getTasks(){
		if($this->id) {	
			$sqlQuery = "SELECT * FROM crm_incidencias WHERE id = ".$this->id;	
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}

	public function update(){		
		if($this->id) {
			$sqlQuery = "UPDATE crm_incidencias SET titulo = '".$this->Titulo."', Descripcion = '".$this->Descripcion."', Estado = '".$this->Estado."' WHERE id = '".$this->id."'";
			$stmt = $this->conn->prepare($sqlQuery);
			if($stmt->execute()){
				$sqlQuerySearchUser = "SELECT * FROM crm_users WHERE name = '".$this->Asignado."'";
				$stmtSearchUser = $this->conn->prepare($sqlQuerySearchUser);
				$stmtSearchUser->execute();
				$resultUser = $stmtSearchUser->get_result();
				while($actualUser = $resultUser->fetch_assoc()) {
					$sqlQuery1 = "UPDATE crm_asignaciones SET id_usuario = '".$actualUser['id']."' WHERE id_incidencia = '".$this->id."'";
					$stmt1 = $this->conn->prepare($sqlQuery1);
					if($stmt1->execute()){
						return true;
					}
				}
			}			
		}	
	}

	public function delete(){
		if($this->id) {			

			$sqlQueryAsignaciones = "DELETE FROM crm_asignaciones WHERE id_incidencia = ".$this->id;
			$stmtAsignaciones = $this->conn->prepare($sqlQueryAsignaciones);
			$stmtAsignaciones->execute();

			$sqlQuery = "DELETE FROM crm_incidencias WHERE id = ".$this->id;
			$stmt = $this->conn->prepare($sqlQuery);

			if($stmt->execute()){
				return true;
			}
		}
	} 

}
?>