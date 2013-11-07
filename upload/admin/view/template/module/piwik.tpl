<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td><span class="required">*</span> <?php echo $entry_http_url; ?></td>
						<td>
							<input type="text" size="80" name="piwik_http_url" value="<?php echo $piwik_http_url; ?>"/>
							<?php if ($error_http_url) { ?>
								<span class="error"><?php echo $error_http_url; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $entry_https_url; ?></td>
						<td>
							<input type="text" size="80" name="piwik_https_url" value="<?php echo $piwik_https_url; ?>"/>
							<?php if ($error_https_url) { ?>
								<span class="error"><?php echo $error_https_url; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $entry_tracker_location; ?></td>
						<td>
							<input type="text" size="120" name="piwik_tracker_location" value="<?php echo $piwik_tracker_location; ?>"/>
							<?php if ($error_tracker_location) { ?>
								<span class="error"><?php echo $error_tracker_location; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $entry_token_auth; ?></td>
						<td>
							<input type="text" size="80" name="piwik_token_auth" value="<?php echo $piwik_token_auth; ?>"/>
							<?php if ($error_token) { ?>
								<span class="error"><?php echo $error_token; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $entry_site_id; ?></td>
						<td>
							<input type="text" size="3" name="piwik_site_id" value="<?php echo $piwik_site_id; ?>"/>
							<?php if ($error_site_id) { ?>
								<span class="error"><?php echo $error_site_id; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_enable; ?></td>
						<td><select name="piwik_enable">
							<?php if ($piwik_enable) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $entry_ec_enable; ?></td>
						<td><select name="piwik_ec_enable">
							<?php if ($piwik_ec_enable) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $entry_proxy_enable; ?></td>
						<td><select name="piwik_proxy_enable">
							<?php if ($piwik_proxy_enable) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><?php echo $entry_use_sku; ?></td>
						<td><select name="piwik_use_sku">
							<?php if ($piwik_use_sku) { ?>
								<option value="1" selected="selected"><?php echo $text_sku_sku; ?></option>
								<option value="0"><?php echo $text_sku_model; ?></option>
							<?php } else { ?>
								<option value="1"><?php echo $text_sku_sku; ?></option>
								<option value="0" selected="selected"><?php echo $text_sku_model; ?></option>
							<?php } ?>
						</select></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>