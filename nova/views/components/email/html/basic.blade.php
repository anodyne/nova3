<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style>
			body {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				font-size: 14px;
				line-height: 20px;
				color: #333333;
				background-color: #ffffff;
			}
		</style>
	</head>
	<body>
		{{ Markdown::parse($content) }}
	</body>
</html>