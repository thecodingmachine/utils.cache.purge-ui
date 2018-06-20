<form class="navbar-form pull-right" style="margin-right: 5px">
<button id="menupurgepsr6cache" class="btn btn-warning" data-loading-text="Purging cache..." data-toggle="button"><i class="icon-refresh icon-white"></i> Purge PSR-6 caches</button>
<button id="menupurgepsr6cachedone" class="btn btn-success" disabled="disabled" style="display:none"><i class="icon-ok icon-white"></i> PSR-6 caches purged</button>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery("#menupurgepsr6cache").click(function() {
		jQuery('#menupurgepsr6cache').button('loading');

		var url;
		if (MoufInstanceManager.selfEdit) {
			url = MoufInstanceManager.rootUrl+"purgeGlobalCaches/doPurge?selfedit=true";
		} else {
			url = MoufInstanceManager.rootUrl+"purgeGlobalCaches/doPurge?selfedit=false";
		}

		jQuery.ajax(url)
			.done(function(data) {
				if (data) {
					addMessage("An error occurred while purging cache:<br/>"+data, "alert alert-error");
				}
				jQuery("#menupurgepsr6cache").hide();
				jQuery("#menupurgepsr6cachedone").show();
				setTimeout(function() {
					jQuery("#menupurgepsr6cachedone").hide();
					jQuery("#menupurgepsr6cache").show();
					jQuery('#menupurgepsr6cache').button('reset');
				}, 1000);
			}).fail(function() {
				addMessage("An error occurred while purging cache", "alert alert-error");
			});

		return false;
	})
});
</script>