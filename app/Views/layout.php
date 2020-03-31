<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Survey App</title>
  <link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/marx.min.css')?>"  media="screen,projection"/>
	<script src="<?=base_url('assets/js/jquery341.min.js')?>" charset="utf-8"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style media="screen">
		body {
			font-size: 16px;
			background: #fff;
			font-family: NewsGothicBT-Light,Helvetica,Arial,sans-serif;
			color: #000;
		}

		.visible{
			border-bottom: 1px solid #ccc;
		}

		.question_container{
			position: relative;
			border:1px solid #cccccc;
			padding: 1.5em;
			padding-top: 2.4em;
			margin-bottom: 1em;
			margin-top: 1em;
		}
		.remove_field{
			padding: 0.5em;
			position:absolute;
		  right:0.2em;
		  top:0.2em;
		}
		.question_save{
			position:absolute;
		  right:1.5em;
		  bottom:1.5em;
		}
	</style>
</head>
<body>
	<section id="header">
	  <main>
			<h1><a href="<?=base_url()?>">Survey App</a></h1>
	  </main>
	</section>
<hr>
  <?= $this->renderSection('content') ?>
<hr>
	<section id="footer">
	  <main>
			<p>Footer</p>
	  </main>
	</section>
</body>
</html>
