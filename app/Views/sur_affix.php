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
				echo $count;
				?>
			</div>
			<div id="sur-form-questions">
				<select id="add-question-type" name="questionTypeSelector">
					<option value="textarea">Text Box</option>
					<option value="checkbox">Multi Select</option>
					<option value="radio">Single Select</option>
				</select>
			</div>
			<form id="question-form" action="" method="post" style="display:none;">
				<input type="hidden" name="surID" value="<?=$sur['id']?>">

			<div id="question-wrapper">
				<input type="text" name="question" placeholder="Write your question" value="">
			</div>
			<div id="option-add">
				<button type="button" id="add-option" name="add-option">Add Optione</button>
			</div>
			<div id="options-container">

			</div>
			<div id="question-control">
				<button type="submit" name="submit">Submit Question</button>
			</div>
			</form>
			<div id="result"></div>
	  </main>
	</section>

<script type="text/javascript">
$(function(){

$("#add-question-type").on("change", function(event){
	event.preventDefault();
	$(this).prop('disabled', true);
	let qType = $(this).val();
	$("#question-form").show();
		//$("#question-form").append('<input type="hidden" name="questionType" value="checkbox">');
	if (qType == 'checkbox') {
		$("#question-form").append('<input type="hidden" name="questionType" value="checkbox">');
	}else if (qType == 'radio') {
		$("#question-form").append('<input type="hidden" name="questionType" value="radio">');
	}else if (qType == 'textarea') {
		$("#question-form").append('<input type="hidden" name="questionType" value="textarea">');
	}
});

$(document).on("click", "#add-option", function(event){
	$("#options-container").append(singleOption);
});

$(document).on('click', '.remove', function(event){
	event.preventDefault();
	console.log("Remove Clicked");
   $(this).closest('.option-wrapper').remove();
});

var singleOption = '<div class="option-wrapper"> ' +
				'	<span class="remove">X</span> ' +
				' <input type="text" name="option[]" placeholder="Write your option." value=""> ' +
				' </div>';
});

//Code a reset button for new question

$(function(){
  $("#question-form").submit(function(e){
    e.preventDefault();
      var formData = $(this).serializeFormJSON();
			//console.log(formData);
  $.post( "<?=base_url('survey/affixq')?>", formData, function(result) {

  }, "json")
	.done(function(result){

		if (result.status) {
			alert(result.message);
			location.reload(true);
		}else {
			alert(result.message + " - " + result.errors);
		}
	})
	.fail(function(result) {
		console.log("fail");
  });
  });
});

(function ($) {
    $.fn.serializeFormJSON = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);
</script>

<?= $this->endSection() ?>
