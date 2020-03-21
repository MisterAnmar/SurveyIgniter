<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

	<section id="content">
	  <main>
			<h2>Survey</h2>
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
<script type="text/javascript">

function editContent(btn)
{
	var x = document.getElementById("surv-title");
	if (x.contentEditable == "true") {
		x.contentEditable = "false";
		btn.innerHTML = "Edit";
		var titleText = x.innerText;
		var survID = document.getElementById("title-btn").value;
		console.log(titleText);
		console.log(survID);
		x.classList.toggle("visible");
		// DO ajax call
		doFetch(titleText, survID);
	} else {
		x.contentEditable = "true";
		btn.innerHTML = "Done";
		x.classList.toggle("visible");
	}
}

// Ajax handler function
function doFetch(textData, survID)
{
	const editData = {
		title: textData,
		id: survID
	};

const options = {
    method: 'POST',
    body: JSON.stringify(editData),
		headers: {
			"Content-Type": "application/json",
			"X-Requested-With": "XMLHttpRequest"
		}
}

fetch('<?=base_url('survey/commit')?>', options)
    .then(res => res.text())
    .then(res => console.log(res));
}

</script>

<?= $this->endSection() ?>
