<?php
	session_start();
	if(isset($_SESSION['user'])){
		header('location:'.$_SESSION['location']);
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>LogIn</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./dist/css/main.css">
</head>
<body class="cover" style="background-image: url(./dist/assets/img/loginFont.jpg);">
<main id="app">
	<!--form action="home.html" method="" autocomplete="off" class="full-box logInForm">
		<p class="text-center text-muted"><i class="zmdi zmdi-edit"></i></i></p>
		<p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserEmail">E-mail</label>
		  <input class="form-control" id="UserEmail" type="email">
		  <p class="help-block">Escribe tú E-mail</p>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserPass">Contraseña</label>
		  <input class="form-control" id="UserPass" type="text">
		  <p class="help-block">Escribe tú contraseña</p>
		</div>
		<div class="form-group text-center">
			<input type="submit" value="Iniciar sesión" class="btn btn-raised btn-danger">
		</div>
	</form-->

	<div id="login" class="">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-primary">
			  	<div class="panel-heading"><span class="glyphicon glyphicon-lock"></span> Sign in</div>
			  	<div class="panel-body">
			    	<label>Username:</label>
			    	<input type="text" class="form-control" v-model="logDetails.username" v-on:keyup="keymonitor">
			    	<label>Password:</label>
			    	<input type="password" class="form-control" v-model="logDetails.password" v-on:keyup="keymonitor">
			  	</div>
			  	<div class="panel-footer">
			  		<button class="btn btn-primary btn-block" @click="checkLogin();"><span class="glyphicon glyphicon-log-in"></span> Login</button>
			  	</div>
			</div>
			<div class="alert alert-danger text-center" v-if="errorMessage">
				<button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-alert"></span> {{ errorMessage }}
			</div>
			<div class="alert alert-success text-center" v-if="successMessage">
				<button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-check"></span> {{ successMessage }}
			</div>
		</div>
	</div>

	<!--====== Scripts -->
	<script src="./dist/js/jquery-3.1.1.min.js"></script>
	<script src="./dist/js/bootstrap.min.js"></script>
	<script src="./dist/js/material.min.js"></script>
	<script src="./dist/js/ripples.min.js"></script>
	<script src="./dist/js/sweetalert2.min.js"></script>
	<script src="./dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./dist/js/main.js"></script>

	<script src="vuejs/js/vue.js"></script>
	<script src="vuejs/js/axios.min.js"></script>
	<script src="vuejs/js/app-login.js"></script>
	<script>
		$.material.init();
	</script>
</main>
</body>
</html>