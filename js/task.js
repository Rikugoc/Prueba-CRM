$(document).ready(function(){	

	var taskRecords = $('#tasksListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"task_action.php",
			type:"POST",
			data:{action:'listIncidencias'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 5, 6],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addTasks').click(function(){
		$('#taskModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#taskForm')[0].reset();
		$("#taskModal").on("shown.bs.modal", function () { 
			$('.modal-title').html("<i class='fa fa-plus'></i> Añadir Incidencia");			
			$('#action').val('addTask');
			$('#save').val('Save');
		});
	});		
	
	$("#tasksListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getTask';
		$.ajax({
			url:'task_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#taskModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#titulo').val(data.titulo);
					$('#descripcion').val(data.Descripcion);
					$('#estado').val(data.Estado);	
					$('#Asignado').val(data.Asignado);
					$('#action').val('updateTask');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#taskModal").on('submit','#taskForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"task_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#taskForm')[0].reset();
				$('#taskModal').modal('hide');				
				$('#save').attr('disabled', false);
				taskRecords.ajax.reload();
			}
		})
	});		

	$("#tasksListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteTasks";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"task_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					taskRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
});