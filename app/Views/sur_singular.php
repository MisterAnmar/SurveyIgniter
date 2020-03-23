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
						echo '<p>'.$i.' - '.$que['question'].'</p>';
						if ($que['type'] == 'textarea') {
									echo '<textarea name="'.$que['id'].'" id="" cols="30" rows="5"></textarea>';
									echo '<br>';
						}
						elseif ($que['type'] == 'radio') {
							foreach($opts as $opt){
								  echo '<input name="question_'.$que['id'].'" type="radio" id="q'.$que['id'].'_o'.$opt['id'].'" />';
									echo $opt['option'];
									echo '<br>';
									}

						}
						elseif ($que['type'] == 'select') {
							// code...
						}
						$i++;
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
