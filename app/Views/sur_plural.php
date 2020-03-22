<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<h2>Survey(s)</h2>
			<?php
			if (isset($surs) && is_array($surs)) {
				foreach ($surs as $sur) {
					echo $sur['title'];
					echo '<br>';
					echo $sur['description'];
				}
			}else {
				echo 'No Survey to display.!';
			}
			?>
	  </main>
	</section>


<?= $this->endSection() ?>
