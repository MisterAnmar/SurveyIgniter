<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<a href="<?=base_url('survey/create')?>">New Survey</a>
			<p><?=session('status')?></p>
			<?=session()->remove('status')?>

			<div class="">
				<h3>Surveys</h3>
				<?php
				if (isset($surs) && is_array($surs)) {
					echo '<ul>';
					foreach ($surs as $sur) {
						echo '<li><a href="'.base_url('survey/fetch/'.$sur['id']).'">'.$sur['title'].'</a> - <a href="'.base_url('survey/revamp/'.$sur['id']).'">Edit</a> </li>';
					}
					echo '</ul>';
				}
				//var_dump($surs);
				?>
			</div>

	  </main>
	</section>


<?= $this->endSection() ?>
