<?php include_once( dirname(__FILE__).'/common_header.php' ); ?>

<style type="text/css">

	.postbox h3 {
	    cursor: default;
	}

</style>

<div class="wrap amazon-page">
	<div class="icon32" style="background: url(<?php echo $wpl_plugin_url; ?>img/amazon-32x32.png) no-repeat;" id="wpl-icon"><br /></div>
	<?php if ( $wpl_account->id ): ?>
	<h2><?php echo __('Edit Account','wpla') ?></h2>
	<?php else: ?>
	<h2><?php echo __('New Account','wpla') ?></h2>
	<?php endif; ?>
	
	<?php echo $wpl_message ?>

	<form method="post" action="<?php echo $wpl_form_action; ?>">

	<!--
	<div id="titlediv" style="margin-top:10px; margin-bottom:5px; width:60%">
		<div id="titlewrap">1
			<label class="hide-if-no-js" style="visibility: hidden; " id="title-prompt-text" for="title">Enter title here</label>
			<input type="text" name="wpla_title" size="30" tabindex="1" value="<?php echo $wpl_account->title; ?>" id="title" autocomplete="off">
		</div>
	</div>
	-->

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box">
					<?php include('account_edit_sidebar.php') ?>
				</div>
			</div> <!-- #postbox-container-1 -->


			<!-- #postbox-container-2 -->
			<div id="postbox-container-2" class="postbox-container">
				<div class="meta-box-sortables ui-sortable">
					

					<div class="postbox" id="GeneralSettingsBox">
						<h3><span><?php echo __('Account settings','wpla'); ?></span></h3>
						<div class="inside">

							<div id="titlediv" style="margin-bottom:5px;">
								<div id="titlewrap">
									<label for="title" class="text_label"><?php echo __('Account name','wpla'); ?></label>
									<input type="text" name="wpla_title" size="30" value="<?php echo $wpl_account->title; ?>" id="title" autocomplete="off" style="width:65%;">
								</div>
							</div>

							<label for="wpl-merchant_id" class="text_label">
								<?php echo __('Merchant ID','wpla'); ?>
                                <?php // wpla_tooltip('') ?>
							</label>
							<input type="text" name="wpla_merchant_id" id="wpl-merchant_id" value="<?php echo str_replace('"','&quot;', $wpl_account->merchant_id ); ?>" class="text_input" />
							<br class="clear" />

							<label for="wpl-marketplace_id" class="text_label">
								<?php echo __('Marketplace ID','wpla'); ?>
                                <?php // wpla_tooltip('') ?>
							</label>
							<input type="text" name="wpla_marketplace_id" id="wpl-marketplace_id" value="<?php echo str_replace('"','&quot;', $wpl_account->marketplace_id ); ?>" class="text_input" />
							<br class="clear" />

							<label for="wpl-access_key_id" class="text_label">
								<?php echo __('Access Key ID','wpla'); ?>
                                <?php // wpla_tooltip('') ?>
							</label>
							<input type="text" name="wpla_access_key_id" id="wpl-access_key_id" value="<?php echo str_replace('"','&quot;', $wpl_account->access_key_id ); ?>" class="text_input" />
							<br class="clear" />

							<label for="wpl-market_id" class="text_label">
								<?php echo __('Amazon site','wpla'); ?>
                                <?php wpla_tooltip('Select which Amazon marketplace you want to use this account with. To work with multiple markets you need to add one account for each market.') ?>
							</label>
							<select id="wpl-market_id" name="wpla_market_id" title="Type" class=" required-entry select">
								<option value="">-- <?php echo __('Please select','wpla'); ?> --</option>
								<?php foreach ($wpl_amazon_markets as $market) : ?>
									<option value="<?php echo $market->id ?>" 
										<?php if ( $wpl_account->market_id == $market->id ) : ?>
											selected="selected"
										<?php endif; ?>
										><?php echo $market->title ?></option>
								<?php endforeach; ?>
							</select>
	
							<label for="wpl-account_is_active" class="text_label">
								<?php echo __('Active','wpla'); ?>
                                <?php wpla_tooltip('If you deactivate an account, WP-Lister will stop sending feeds and fetching reports for this account.') ?>
							</label>
							<select id="wpl-account_is_active" name="wpla_account_is_active" title="Type" class=" required-entry select">
								<option value="1" <?php if ( $wpl_account->active == 1 ) echo 'selected' ?> ><?php echo __('Active','wpla'); ?></option>
								<option value="0" <?php if ( $wpl_account->active == 0 ) echo 'selected' ?> ><?php echo __('Inactive','wpla'); ?></option>
							</select>
	
						</div>
					</div>


					<div class="postbox" id="OtherMarketsBox">
						<h3><span><?php echo __('Marketplaces','wpla'); ?></span></h3>
						<div class="inside">

							<p>
								This account has permission to access the following marketplaces:
							</p>

							<table style="width:100%">
							<?php foreach ($wpl_account->allowed_markets as $market) : ?>
								<tr>
									<td>
										<?php echo $market->Name ?>
									</td><td>
										<?php echo $market->DefaultCountryCode ?>
									</td><td>
										<?php echo $market->DefaultCurrencyCode ?>
									</td><td>
										<a href="http://<?php echo $market->DomainName ?>" target="_blank"><?php echo $market->DomainName ?></a>
									</td><td>
										<?php echo $market->MarketplaceId ?>
									</td><td>
										<a href="#" onclick="jQuery('#wpl-marketplace_id').attr('value','<?php echo $market->MarketplaceId ?>');return false;" class="button button-small">Select</a>
									</td>
								</tr>
							<?php endforeach; ?>
							</table>
	
						</div>
					</div>


						
				</div> <!-- .meta-box-sortables -->
			</div> <!-- #postbox-container-1 -->



		</div> <!-- #post-body -->
		<br class="clear">
	</div> <!-- #poststuff -->

	</form>


	<?php if ( get_option('wpla_log_level') > 6 ): ?>
	<pre><?php print_r($wpl_account); ?></pre>
	<?php endif; ?>


	<script type="text/javascript">

		jQuery( document ).ready( function () {

		});	
	
	</script>

</div>



	
