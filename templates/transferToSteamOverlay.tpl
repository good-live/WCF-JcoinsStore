<div id="transferToSteamOverlay">
	<div>
		<fieldset id="transferToSteamOverlayGeneralFieldset">
			<legend>{lang}wcf.jcoins.transfer.general{/lang}</legend>
			<dl id="transferToSteamOverlayAmountDl">
				<dt><label for="amountInput">{lang}wcf.jcoins.transfer.amount{/lang}</label></dt>
				<dd>
					<input type="number" id="amountInput" name="amount" value="0" min="1" max="{$__wcf->user->jCoinsAmount}" class="short" />
				</dd>
			</dl>
		</fieldset>
	</div>

	<div class="formSubmit">
		<button data-type="submit" accesskey="s">{lang}wcf.global.button.submit{/lang}</button>
	</div>
</div>
