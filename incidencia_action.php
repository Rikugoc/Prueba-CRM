<?php
include_once 'class/Database.php';
include_once 'class/Incidencias.php';

$database = new Database();
$db = $database->getConnection();

$task = new Tasks($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listIncidencias') {
	$task->listIncidencias();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addTask') {	
	$task->id = $_POST["id"];
    $task->titulo = $_POST["titulo"];
	$task->Descripcion = $_POST["Descripcion"];
	$task->Estado = $_POST["Estado"];
	$task->asignados = $_POST["asignados"];	
	$task->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTask') {
	$task->id = $_POST["id"];
	$task->getTasks();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateTask') {
	$task->id = $_POST["id"];
    $task->titulo = $_POST["titulo"];
	$task->Descripcion = $_POST["Descripcion"];
	$task->Estado = $_POST["Estado"];
	$task->asignados = $_POST["asignados"];	
	$task->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteTasks') {
	$task->id = $_POST["id"];
	$task->delete();
}
?>