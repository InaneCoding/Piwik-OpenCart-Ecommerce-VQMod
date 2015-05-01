<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-piwik" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
<div class="container-fluid">
<?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-piwik">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<td><span class="required">*</span> <?php echo $entry_piwik_url; ?></td>
						<td>
							<input type="text" size="80" name="piwik_url" value="<?php echo $piwik_url; ?>"/>
							<?php if ($error_piwik_url) { ?>
								<span class="error"><?php echo $error_piwik_url; ?></span>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> <?php echo $entry_tracker_location; ?></td>
						<td>
							<input type="text" size="80" name="piwik_tracker_location" value="<?php echo $piwik_tracker_location; ?>"/>
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
</div>
<?php echo $footer; ?>