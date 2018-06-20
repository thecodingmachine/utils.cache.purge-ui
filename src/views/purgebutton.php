<form class="navbar-form pull-right" style="margin-right: 5px">
<button id="menupurgeglobalcache" class="btn btn-warning" data-loading-text="Purging cache..." data-toggle="button"><i class="icon-refresh icon-white"></i> Purge all caches</button>
<button id="menupurgeglobalcachedone" class="btn btn-success" disabled="disabled" style="display:none"><i class="icon-ok icon-white"></i> All cache purged</button>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery("#menupurgeglobalcache").click(function() {
		jQuery('#menupurgeglobalcache').button('loading');

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
				jQuery("#menupurgeglobalcache").hide();
				jQuery("#menupurgeglobalcachedone").show();
				setTimeout(function() {
					jQuery("#menupurgeglobalcachedone").hide();
					jQuery("#menupurgeglobalcache").show();
					jQuery('#menupurgeglobalcache').button('reset');
				}, 1000);
			}).fail(function() {
				addMessage("An error occurred while purging cache", "alert alert-error");
			});

		return false;
	})
});
</script>