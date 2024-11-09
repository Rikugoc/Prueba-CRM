<h3><?php if($_SESSION["userid"]) { echo "Usuario : ".ucfirst($_SESSION["name"]); } ?> | <a href="logout.php">Cerrar Sesión</a> </h3><br>
<p><strong>Bienvenido <?php if ($_SESSION["rol"] == '1') echo "Soporte"; elseif ($_SESSION["rol"] == '2') echo "Admin"; ?></strong></p>	
<ul class="nav nav-tabs">
	<?php if($_SESSION["rol"] == '1') { ?>		
		<li id="incidencias"><a href="incidencias.php">Incidencias</a></li>
	<?php } ?>
	
	<?php if($_SESSION["rol"] == '2') { ?>
		<li id="incidencias"><a href="incidencias.php">Incidencias</a></li>
	<?php } ?>
</ul>