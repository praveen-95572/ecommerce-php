<?php
include 'header.inc.php';
?>
<div class="row">
<div class="col-sm-12">
<form id="ratingForm" method="POST">
<div class="form-group">
<h4>Rate this product</h4>
<button type="button" class="btn btn-warning btn-sm rateButton" aria-label="Left Align">
<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
</button>
<input type="hidden" class="form-control" id="rating" name="rating" value="1">
<input type="hidden" class="form-control" id="itemId" name="itemId" value="12345678">
</div>
<div class="form-group">
<label for="usr">Title*</label>
<input type="text" class="form-control" id="title" name="title" required>
</div>
<div class="form-group">
<label for="comment">Comment*</label>
<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn btn-info" id="saveReview">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
</div>
</form>
</div>
</div>

<?php
include 'footer.inc.php';
?>

<script type="text/javascript">
	$('#ratingForm').on('submit', function(event){
event.preventDefault();
var formData = $(this).serialize();
$.ajax({
type : 'POST',
url : 'saveRating.php',
data : formData,
success:function(response){
$("#ratingForm")[0].reset();
window.setTimeout(function(){window.location.reload()},1000)
}
});
});
</script>