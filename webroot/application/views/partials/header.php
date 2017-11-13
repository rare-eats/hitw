<!doctype html>
<html lang="en">
  <head>
  	<title>Rare Eats - <?php echo $title;?></title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

	<!-- Load additional CSS files passed in $data, should they exist -->
	<?php if(isset($css)): ?>
		<?php foreach($css as $style): ?>
			<link rel="stylesheet" href="<?php echo $style.'.css'; ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>
  </head>
  <body>