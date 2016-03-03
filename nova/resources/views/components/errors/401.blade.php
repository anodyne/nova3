<html>
	<head>
		<title>Unauthorized</title>
		<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:400" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #78909c;
				display: table;
				font-weight: 300;
				font-family: "Roboto";
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
				color: #e53935;
				font-family: "Roboto Condensed";
				font-weight: 400;
			}
			.subtitle {
				margin-bottom: 40px;

				font-size: 36px;
				font-weight: 300;
			}
			.redirect-link {
				font-size: 36px;
				font-weight: 300;
			}
			.redirect-link a {
				padding-bottom: 1px;
				color: #78909c;
				text-decoration: none;
				font-size: 32px;
				font-weight: 500;
			}
			.redirect-link a:hover {
				color: #51636c;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Unauthorized!</div>
				<div class="subtitle">{{ $exception->getMessage() }}</div>
				<div class="redirect-link"><a href="{{ route('login') }}" class="btn btn-lg btn-link">Log In Now &raquo;</a></div>
			</div>
		</div>
	</body>
</html>