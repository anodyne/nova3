<html>
	<head>
		<title>{{ $pageTitle }} &bull; {{ $siteName }}</title>
		
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 400;
				font-family: 'Open Sans';
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
				font-family: "Open Sans Condensed";
				font-weight: 300;
			}

			.quote {
				font-size: 24px;
			}

			.data-table{margin:15px 0}.data-table>.row{margin-left:0;margin-right:0;border-top:1px solid #ddd}.data-table>.row p{margin:10px 0}.data-table.data-table-striped>.row:nth-child(odd){background:#ededed}.data-table.data-table-bordered>.row{border-left:1px solid #ddd;border-right:1px solid #ddd}.data-table.data-table-bordered>.row:first-child{-webkit-border-radius:5px 5px 0 0;-moz-border-radius:5px 5px 0 0;border-radius:5px 5px 0 0}.data-table.data-table-bordered>.row:last-child{border-bottom:1px solid #ddd;-webkit-border-radius:0 0 5px 5px;-moz-border-radius:0 0 5px 5px;border-radius:0 0 5px 5px}.data-table.data-table-bordered>.row:nth-child(1):nth-last-child(1){border-bottom:1px solid #ddd;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px 5px 5px 5px}
		</style>
	</head>
	<body>
		{!! $template or '' !!}
		{!! $javascript or '' !!}
	</body>
</html>