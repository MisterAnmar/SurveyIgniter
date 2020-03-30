<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
				<h2>PageTitle</h2>
			<hr>
			<nav>
				<a href="<?=base_url('survey/create')?>">New Survey</a>
			</nav>
			<div>
				<span class="alert"><?=session('status')?></span>
			</div>
			<div>
				<?php
				if (isset($surveys) && is_array($surveys)) {
					echo '<ul>';
					foreach ($surveys as $sur) {
						echo '<li><a href="'.base_url('survey/fetch/'.$sur['id']).'">'.$sur['title'].'</a> - <a href="'.base_url('survey/revamp/'.$sur['id']).'">Edit</a> </li>';
					}
					echo '</ul>';
				}
				?>
			</div>
	  </main>
	</section>


<?= $this->endSection() ?>
