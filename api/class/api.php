<?php
class Api {

	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	public function login(){
		$sqlQuery = "SELECT * FROM crm_users WHERE email = '".$_SERVER['PHP_AUTH_USER']."' AND password = '".$_SERVER["PHP_AUTH_PW"]."'";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()) {
				if ($row['rol'] == 2){
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
						$rows['id'] = $tasks['id'];
						$rows['titulo'] = $tasks['titulo'];			
						$rows['descripcion'] = $tasks['Descripcion'];
						switch ($tasks['Estado']){
							case '1':
								$rows['estado'] = "To Do";
								break;
							case '2':
								$rows['estado'] = "Doing";
								break;
							case '3':
								$rows['estado'] = "Done";
								break;
							default:
								$rows['estado'] = $tasks['Estado'];
						}
						$rows['asignados'] = $asignados;	
						$records[] = $rows;

					}

					echo json_encode($records);
					
				}else{

					$sqlQueryTMP = "SELECT * FROM crm_asignaciones WHERE id_usuario = ".$row["id"];

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
							$rows['id'] = $tasks['id'];
							$rows['titulo'] = $tasks['titulo'];			
							$rows['descripcion'] = $tasks['Descripcion'];
							switch ($tasks['Estado']){
								case '1':
									$rows['estado'] = "To Do";
									break;
								case '2':
									$rows['estado'] = "Doing";
									break;
								case '3':
									$rows['estado'] = "Done";
									break;
								default:
									$rows['estado'] = $tasks['Estado'];
							}
							$rows['asignados'] = $asignados;		
							$records[] = $rows;
						}

					}

					echo json_encode($records);

				}
			}
		}
		else{
			echo "Credenciales Incorrectas";
		}
	}

}
?>