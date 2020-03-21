<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="sur-form-revamp">
				<div class="status">
					<?=session('status')?>
					<?=session()->remove('status')?>
					<?php
					if (session()->has('errors')) {
						var_dump(session('errors'));
						session()->remove('errors');
					}
					?>
				</div>
			<fieldset>
    		<legend>Edit Survey</legend>
				<form id="form-edit" action="<?=base_url('survey/revamp/'.$sur['id'])?>" method="post">
					<input type="hidden" name="id" value="<?=$sur['id']?>">
					<label for="title">Title:</label>
					<input type="text" required name="title" value="<?=$sur['title']?>">
					<label for="description">Description:</label>
					<input type="text" name="description" value="<?=$sur['description']?>">
					<br>
					<button type="submit" name="button">Update</button>
				</form>
			</fieldset>
			</div>
	  </main>
	</section>


<?= $this->endSection() ?>
