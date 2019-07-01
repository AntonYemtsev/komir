<!doctype html>
<html class="no-js h-100" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Войти - Komir.kz</title>
	<meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="/admin/styles/shards-dashboards.1.1.0.min.css">
	<link rel="stylesheet" href="/admin/styles/extras.1.1.0.min.css">
	<script async defer src="https://buttons.github.io/buttons.js"></script>
	<link rel="stylesheet" href="/admin/styles/additional.css">
</head>
<body class="h-100">
	<div class="main-content-container h-100 px-4 container-fluid">
		<div class="h-100 no-gutters row">
			<div class="auth-form mx-auto my-auto col-md-5 col-lg-3">
				<div class="card">
					<div class="card-body">
						<img class="auth-form__logo d-table mx-auto mb-3" src="/admin/images/main-logo.svg" alt="Komir.kz">
						<form class="login-form" method="post" action="/login">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group">
								<label for="login-form-email">E-mail</label>
								<input type="email" id="login-form-email" placeholder="example@yourdomain.com" autocomplete="email" class="form-control" name="email" value="{{$email}}">
							</div>
							<div class="form-group">
								<label for="login-form-password">Пароль</label>
								<input type="password" id="login-form-password" placeholder="••••••••" autocomplete="current-password" class="form-control" name="password">
							</div>
							<div class="form-group">
								<label class="custom-control custom-checkbox" style="padding-left: 1.25rem; font-size: 14px">
									<input id="login-form-remember" type="checkbox" class="custom-control-input">
									<label id="login-form-remember" class="custom-control-label" aria-hidden="true"></label>
									<span class="custom-control-description">Запомнить меня</span>
									<a href="/lost-password" style="float: right;">Забыли пароль?</a>
								</label>
							</div>
							<button type="submit" name="submit" id="login-form-submit" class="mb-2 btn btn-primary mr-2">Войти</button>

							<br>
							<span class="control__help" style="color: red;">{{$email_error}} {{$auth_error}}</span>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
		<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
		<script src="/admin/scripts/extras.1.1.0.min.js"></script>
		<script src="/admin/scripts/shards-dashboards.1.1.0.min.js"></script>
		<script src="/admin/scripts/app/app-components-overview.1.1.0.js"></script>
	</body>
</html>