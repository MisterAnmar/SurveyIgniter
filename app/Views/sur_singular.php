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
						echo '<button type="button" value="'.$sur['id'].','.$que['id'].'" class="question-remove">Delete</button>';
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

$(function(){

	$(".question-remove").on("click", function(event){
		event.preventDefault();
		var record = $(this).val();
		if (window.confirm("Do you really want to delete this question?")) {
			var formData = {record: record };

			$.post( "<?=base_url('survey/detach')?>", formData, function(result) {
			}, "json")
			.done(function(result){
				if (result.status) {
					alert(result.message);
					$(this).closest('.question-block').remove();
				}else {
					alert(result.message + " - " + result.errors);
				}
			})
			.fail(function(result) {
				console.log("fail");
			});
		}else{
			return;
		}
	});

});

</script>

<?= $this->endSection() ?>
