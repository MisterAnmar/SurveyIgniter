<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="sur-form-revamp">

			<fieldset>
    		<legend>Edit Survey</legend>
				<div class="status">
					<?=session('status')?>
					<?php
						var_dump(session('errors'));
					?>
				</div>
				<form id="form-edit" action="<?=base_url('survey/revamp/'.$survey['id'])?>" method="post">
					<input type="hidden" name="id" value="<?=$survey['id']?>">
					<label for="title">Title:*</label>
					<input type="text" required name="title" value="<?=$survey['title']?>">
					<label for="description">Description:</label>
					<input type="text" name="description" value="<?=$survey['description']?>">
					<br>
					<button type="submit" name="button">Update</button>
				</form>
			</fieldset>
			</div>
	  </main>
	</section>


<?= $this->endSection() ?>
