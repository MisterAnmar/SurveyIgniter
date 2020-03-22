<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<h2>Survey</h2>
			<div class="status">
				<?=session('status')?>
				<?=session()->remove('status')?>
			</div>
			<nav>
				<a href="<?=base_url('survey/revamp/'.$sur['id'])?>">Edit</a>
				<a href="<?=base_url('survey/affix/'.$sur['id'])?>">Add Questions</a>
			</nav>
			<?php
			if (isset($sur)) {
				echo '<h2>'.$sur['title'].'</h2>';
				echo '<p>'.$sur['description'].'</p>';
			}else {
				echo 'No such Survey!';
			}

			if (isset($ques) && is_array($ques)) {
				foreach ($ques as $que) {
					// Display Based on type
					echo '<p>'.$que['title'].'</p>';
				}
			}else {
				echo 'No Questions Yet.';
			}
			?>
	  </main>
	</section>

<?= $this->endSection() ?>
