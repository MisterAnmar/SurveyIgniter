<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="survey">
				<?php
				if (isset($survey)) {
					echo '<h2>'.$survey['title'].'</h2>';
					echo '<p>'.$survey['description'].'</p>';
				}
				 ?>
			</div>

				<hr>
				<div>
					<p>Total Questions: <?=$queCount?></p>
				</div>
				<div id="sur-container-publish">
					<form class="" action="<?=base_url('survey/publish')?>" method="post">
						<input type="hidden" name="id" value="<?=$survey['id']?>">
						<input type="hidden" name="active" value="1">
						<label for="start_at">Start:</label>
						<input type="date" name="start_at" required value="">
						<label for="end_at">End:</label>
						<input type="date" name="end_at" required value="">
						<br>
						<button type="submit" name="button">Publish</button>
					</form>
				</div>

	  </main>
	</section>


<script type="text/javascript">

</script>

<?= $this->endSection() ?>
