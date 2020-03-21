<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="sur-form-create">
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
					<legend>Create Survey</legend>
					<form id="form-create" action="<?=base_url('survey/create')?>" method="post">
						<label for="title">Title:*</label>
						<input type="text" autofocus required name="title" value="">
						<label for="description">Description:</label>
						<input type="text" name="description" value="">
						<br>
						<button type="submit" name="button">Create</button>
					</form>
				</fieldset>
			</div>
	  </main>
	</section>


<?= $this->endSection() ?>
