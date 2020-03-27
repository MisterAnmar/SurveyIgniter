<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<?php
			if (isset($sur)) {
				echo '<h2>'.$sur['title'].'</h2>';
				echo '<a href="'.base_url('survey/revamp/'.$sur['id']).'">Edit</a>
							<a href="'.base_url('survey/affix/'.$sur['id']).'">Add Questions</a>';
				echo '<br>';
				echo '<p>'.$sur['description'].'</p>';
			}

			if (isset($ques) && is_array($ques)) {
				echo '<hr>';
				$i = 1;
					foreach ($ques as $que) {
						echo '<div class="question-block">';
						echo '<div class="question">';
						echo '<p>'.$i.' - '.$que['question'].'</p>';
						echo '</div>';
						if ($que['type'] == 'textarea') {
								echo '<div class="options">';
								echo '<p>Text Box</p>';
								echo '</div>';
						}	else {
								echo '<div class="options">';
								echo '<ol type="a">';
							foreach($opts as $opt){
									//echo '<input name="question_'.$que['id'].'" type="radio" id="q'.$que['id'].'_o'.$opt['id'].'" />';
									echo '<li>';
									echo $opt['option'];
									echo '</li>';
									}
								echo '</ol>';
								echo '</div>';
						}
						$i++;
						echo '</div>';
					}
			}else {
				echo 'No Questions Yet.';
			}
			?>
	  </main>
	</section>


<script type="text/javascript">

</script>

<?= $this->endSection() ?>
