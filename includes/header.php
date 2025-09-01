<?php $pagina = basename($_SERVER['PHP_SELF']); ?>
<div class="navbar navbar-inverse set-radius-zero" >
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand"><img src="assets/img/logo.png" /></a>
		</div>
		<?php if($_SESSION['login']) { ?> 
		<div class="right-div">
			<a href="logout.php" class="btn btn-danger pull-right" onclick="return confirm('¿Seguro que quieres cerrar sesión?');">Cerrar Sesión</a>
		</div>
			<?php }?>
	</div>
</div>
<?php if($_SESSION['login']) { ?>
<section class="menu-section">
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<div class="navbar-collapse collapse ">
					<ul id="menu-top" class="nav navbar-nav navbar-right">
						<li><a href="dashboard.php" class="<?php echo ($pagina == 'dashboard.php')?"menu-top-active":""; ?>">Panel Control</a></li>
						<li><a href="#" class="dropdown-toggle <?php echo ($pagina == 'my-profile.php' || $pagina == 'change-password.php')?"menu-top-active":""; ?>" id="ddlmenuItem" data-toggle="dropdown">Cuenta <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="my-profile.php">Mi Perfil</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="change-password.php">Cambiar Clave</a></li>
							</ul>
						</li>
						<li><a class="<?php echo ($pagina == 'issued-books.php')?"menu-top-active":""; ?>" href="issued-books.php">Libros Prestados</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } else { ?>
<section class="menu-section">
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<div class="navbar-collapse collapse ">
					<ul id="menu-top" class="nav navbar-nav navbar-right">
						<li><a href="adminlogin.php">Acceso Administrador</a></li>
						<li><a href="index.php">Acceso Estudiante</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>