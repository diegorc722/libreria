<?php $pagina = basename($_SERVER['PHP_SELF']); ?>
<div class="navbar navbar-inverse set-radius-zero" >
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand">
				<img src="assets/img/logo.png" />
			</a>
		</div>
		<div class="right-div">
			<a href="logout.php" class="btn btn-danger pull-right" onclick="return confirm('¿Seguro que quieres cerrar sesión?');">Cerrar Sesión</a>
		</div>
	</div>
</div>
<section class="menu-section">
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<div class="navbar-collapse collapse ">
					<ul id="menu-top" class="nav navbar-nav navbar-right">
						<li><a href="dashboard.php" class="<?php echo ($pagina == 'dashboard.php')?"menu-top-active":""; ?>">Panel Control</a></li>
						<li>
							<a href="#" class="dropdown-toggle <?php echo ($pagina == 'add-category.php' || $pagina == 'manage-categories.php')?"menu-top-active":""; ?>" id="ddlmenuItem1" data-toggle="dropdown">Categorías <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem1">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="add-category.php">Agregar Categoría</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="manage-categories.php">Administrar Categorías</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle <?php echo ($pagina == 'add-author.php' || $pagina == 'manage-authors.php')?"menu-top-active":""; ?>" id="ddlmenuItem2" data-toggle="dropdown">Autores <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem2">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="add-author.php">Agregar Autor</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="manage-authors.php">Administrar Autores</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle <?php echo ($pagina == 'add-book.php' || $pagina == 'manage-books.php')?"menu-top-active":""; ?>" id="ddlmenuItem3" data-toggle="dropdown">Libros <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem3">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="add-book.php">Agregar Libro</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="manage-books.php">Administrar Libros</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle <?php echo ($pagina == 'issue-book.php' || $pagina == 'manage-issued-books.php')?"menu-top-active":""; ?>" id="ddlmenuItem4" data-toggle="dropdown">Prestamos <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem4">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="issue-book.php">Agregar Prestamo</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="manage-issued-books.php">Administrar Prestamos</a></li>
							</ul>
						</li>
						<li><a class="<?php echo ($pagina == 'reg-students.php')?"menu-top-active":""; ?>" href="reg-students.php">Registro de Estudiantes</a></li>
						<li><a class="<?php echo ($pagina == 'change-password.php')?"menu-top-active":""; ?>" href="change-password.php">Cambiar Clave</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>