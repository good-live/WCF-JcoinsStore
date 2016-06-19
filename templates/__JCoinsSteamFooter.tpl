{if $__wcf->user->steamID64}
	<script src="{@$__wcf->getPath()}js/de.wcflabs.goodlive.steamGame{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@LAST_UPDATE_TIME}" data-relocate="true"></script>
	<script data-relocate="true">
		//<![CDATA[
		$(function() {
			WCF.Language.addObject({
				'wcf.jcoins.steamTransfer.title': '{lang}wcf.jcoins.steamTransfer.title{/lang}',
				'wcf.jcoins.steamTransfer.success': '{lang}wcf.jcoins.transfer.success{/lang}'
			});

			new de.wcflabs.goodlive.steamGame.jcoins.TransferToSteamOverlay();
		});
		//]]>
	</script>
{/if}
