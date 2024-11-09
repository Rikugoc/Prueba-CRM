<?php
include_once 'class/Database.php';
include_once 'class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<title>Tabla de Incidencias</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/task.js"></script>	
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container" style="background-color:#f4f3ef;">  
	<h2>Tabla de Incidencias</h2>	
	<?php include('top_menus.php'); ?>	
	<br>
	<h4>Incidencias</h4>		
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addTasks" class="btn btn-info" title="Add Tasks"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="tasksListing" class="table table-bordered table-striped">
			<thead>
				<tr>						
					<th>Id</th>					
					<th>Título</th>					
					<th>Descripción</th>
					<th>Estado</th>	
					<th>Asignado</th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	
	<div id="taskModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="taskForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i>Añadir Incidencia</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">	
							<label for="project" class="control-label">Título</label>
							<input type="text" class="form-control" id="Titulo" name="Titulo" placeholder="Título" required>			
						</div>

						<div class="form-group">	
							<label for="project" class="control-label">Descripción</label>
							<input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Descripción" required>			
						</div>

						<div class="form-group">	
							<label for="project" class="control-label">Estado</label>
							<select class="form-control" id="Estado" name="Estado" required>
							<option value="1">To Do</option>
							<option value="2">Doing</option>
							<option value="3">Done</option>
						</select>
						</div>

						<?php 
						if($_SESSION["rol"] == '2') { 

							echo '
							<div class="form-group">	
								<label for="project" class="control-label">Asignado</label>
								<select class="form-control" id="Asignado" name="Asignado">
									<option value="Nadie"> </option>
							';
							$usuarios = $user->getUsers();
							for ($i = 0; $i < count($usuarios); $i++){
								echo "<option value='" . $usuarios[$i] . "'>" . $usuarios[$i] . "</option>";
							}

							echo '
							</select>
							</div>';
						}else {
							echo '
							<input type="hidden" name="Asignado" id="Asignado" value="'.$_SESSION['nombre'].'"/>
							';
						}
						?>

					<div class="modal-footer">
						<input type="hidden" name="id" id="id" />
						<input type="hidden" name="action" id="action" value="" />
						<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
			
</div>
 <?php include('inc/footer.php');?>
