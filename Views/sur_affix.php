
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<div class="">
				<h2><?=$sur['title']?></h2>
				<p><?=$sur['description']?></p>
			</div>
			<div class="questions">
				<?php
				if (isset($ques) && is_array($ques)) {
					foreach ($ques as $que) {
						echo '<p>'.$que['title'].'</p>';
					}
				}
				?>
			</div>
			<div id="sur-form-questions">
				<form id="form-question-add" action="" method="post">
					<label for="">Question:</label>
					<select id="quesType" name="quesType">
						<option value="text">Text field</option>
						<option value="check">Multi Select</option>
						<option value="radio">Single Select</option>
					</select>
					<button type="submit" name="button">Add</button>
				</form>
			</div>
	  </main>
	</section>

