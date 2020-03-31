<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="sur-form-create">

				<fieldset>
					<legend>Create Survey</legend>
					<div class="status">
						<?=session('status')?>
						<?php
							var_dump(session('errors'));
						?>
					</div>
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
