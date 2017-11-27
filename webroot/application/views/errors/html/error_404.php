<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link rel="stylesheet" href="/css/site.css"></link>
</head>
<body>
	<div id="error-container">
		<a href="/"><img src="/logo_256.png"/></a>
		<h1><?php echo $heading; ?></h1>
		<hr />
		<?php echo $message; ?>
	</div>
</body>
</html>