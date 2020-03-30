<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div id="survey">
				<?php
				if (isset($survey)) {
					echo '<h2>'.$survey['title'].'</h2>';
					echo '<p>'.$survey['description'].'</p>';
				}
				 ?>
			</div>
			<nav>
				<?php
				echo '<a href="'.base_url('survey/revamp/'.$survey['id']).'">Edit</a>';
				echo '<a href="'.base_url('survey/affix/'.$survey['id']).'">Add Questions</a>';
				echo '<a href="'.base_url('survey/removesurvey/'.$survey['id']).'">Delete</a>';
				 ?>
			</nav>
				<hr>
			<?php

			if (isset($questions) && !empty($questions) && is_array($questions)) {

				$i = 1;
					foreach ($questions as $que) {
						echo '<div class="question-block">';
						echo '<button type="button" style="float:right;" value="'.$que['id'].'" class="question-remove">Delete</button>';
						echo '<div class="question">';
						echo '<p>'.$i.' - '.$que['content'].'</p>';
						echo '</div>';
						if ($que['type'] == 'textarea') {
								echo '<div class="options">';
								echo '<p>Text Box</p>';
								echo '</div>';
						}	else {
								echo '<div class="options">';
								echo '<ol type="a">';
							foreach($options as $opt){
								if ($opt['question_id'] == $que['id'] ) {
									//echo '<input name="question_'.$que['id'].'" type="radio" id="q'.$que['id'].'_o'.$opt['id'].'" />';
									echo '<li>';
									echo $opt['option'];
									echo '</li>';
								}
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
		var qid = $(this).val();
		$(this).closest('.question-block').remove();
		if (window.confirm("Do you really want to delete this question?")) {
			//var menuId = $( "ul.nav" ).first().attr( "id" );
			var request = $.ajax({
			  url: "<?=base_url('survey/detach')?>",
			  method: "post",
			  data: { id : qid }
			});
			request.done(function( msg ) {
				if (msg.code == 100) {
					alert(msg.status);
				}else{
					alert( "Request failed: " + msg.status );
				}
			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			});

		}else{
			return;
		}
	});

});

</script>

<?= $this->endSection() ?>
