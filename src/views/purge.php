<h1>Purge all caches</h1>

<?php if ($this->done == 'true'):?>
<div class="alert alert-success good">All cache has successfully been purged.</div>
<script type="text/javascript">
setTimeout(function() {
	jQuery('.good').fadeOut(3000);
}, 7000);
</script>

<?php endif; ?>

<p>Click the button below to purge all PSR-6, PSR-16, Doctrine and Mouf cache pools whose instances are defined in Mouf.</p>

<form action="purge" method="post">
	<input type="hidden" name="selfedit" value="<?php echo plainstring_to_htmlprotected($this->selfedit); ?>" />
	<button class="btn btn-danger" type="submit">Purge all cache</button>
</form>