<!doctype html>
<?php
include_once 'class/User.php';
include_once 'class/database.php';
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($user->loggedIn()){
  header("Location: incidencias.php");
}

$loginMessage = '';
if(!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {  
  $user->email = $_POST["email"];
  $user->password = $_POST["password"];
  if($user->login()) {
    header("Location: incidencias.php");  
  } else {
    $loginMessage = 'Usuario no válido, vuelva a intentarlo!';
  }
} else {
  $loginMessage = 'Rellene todos los campos.';
}

include('inc/header.php');
?>

<html>

  <body>
    <?php include('inc/container.php');?>
    <div class="content"> 
      <div class="container-fluid">
        <h2>Example: Customer Relationship Management (CRM) System</h2>     
            <div class="col-md-6">                    
        <div class="panel panel-info">
          <div class="panel-heading" style="background:#00796B;color:white;">
            <div class="panel-title">Admin Log In</div>                        
          </div> 
          <div style="padding-top:30px" class="panel-body" >
            <?php if ($loginMessage != '') { ?>
              <div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $loginMessage; ?></div>                            
            <?php } ?>
            <form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
              <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" id="email" name="email" value="<?php if(!empty($_POST["email"])) { echo $_POST["email"]; } ?>" placeholder="email" style="background:white;" required>                                        
              </div>                                
              <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" value="<?php if(!empty($_POST["password"])) { echo $_POST["password"]; } ?>" placeholder="password" required>
              </div>          
              
              <div style="margin-top:10px" class="form-group">                               
                <div class="col-sm-12 controls">
                  <input type="submit" name="login" value="Login" class="btn btn-info">             
                </div>            
              </div>  
              
              
              <h2>Usuarios actuales (para el ejemplo)</h2>

              <h3>Soporte</h3>
              <strong>Email: </strong>Paquito098@gmail.com<br>
              <strong>Password:</strong> .abc123.<br>
              
              <h3>Soporte</h3>
              <strong>Email: </strong>Manolo@gmail.com<br>
              <strong>Password:</strong> .abc123.<br>

              <h3>Administrador</h3>
              <strong>Email: </strong>Admin@gmail.com<br>
              <strong>Password:</strong> .abc123.<br>
                      
              
            </form>   
          </div>                     
        </div>  
      </div>       
        </div>        
        
    <?php include('inc/footer.php');?>
  </body>

</html>