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
<?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-piwik" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="entry-enable"><span data-toggle="tooltip" title="<?php echo $help_enable; ?>"><?php echo $entry_enable; ?></span></label>
				<div class="col-sm-10">
					<select name="piwik_enable" id="entry-enable" class="form-control">
						<?php if ($piwik_enable) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="entry-analytics_url"><span data-toggle="tooltip" title="<?php echo $help_analytics_url1; ?>"><?php echo $entry_analytics_url; ?></span></label>
				<div class="col-sm-10">
					<input type="text" name="piwik_analytics_url" value="<?php echo $piwik_analytics_url; ?>" placeholder="<?php echo $help_analytics_url2; ?>" id="entry-analytics_url" class="form-control"/>
					<?php if ($error_analytics_url) { ?>
						<div class="text-danger"><?php echo $error_analytics_url; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="entry-tracker_location"><span data-toggle="tooltip" title="<?php echo $help_tracker_location1; ?>"><?php echo $entry_tracker_location; ?></span></label>
				<div class="col-sm-10">
					<input type="text" name="piwik_tracker_location" value="<?php echo $piwik_tracker_location; ?>" placeholder="<?php echo $help_tracker_location2; ?>" id="entry-tracker_location" class="form-control"/>
					<?php if ($error_tracker_location) { ?>
						<div class="text-danger"><?php echo $error_tracker_location; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="entry-token_auth"><span data-toggle="tooltip" title="<?php echo $help_token_auth1; ?>"><?php echo $entry_token_auth; ?></span></label>
				<div class="col-sm-10">
					<input type="text" name="piwik_token_auth" value="<?php echo $piwik_token_auth; ?>" placeholder="<?php echo $help_token_auth2; ?>" id="entry-token_auth" class="form-control"/>
					<?php if ($error_token_auth) { ?>
						<div class="text-danger"><?php echo $error_token_auth; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="entry-site_id"><span data-toggle="tooltip" title="<?php echo $help_site_id1; ?>"><?php echo $entry_site_id; ?></span></label>
				<div class="col-sm-10">
					<input type="text" name="piwik_site_id" value="<?php echo $piwik_site_id; ?>" placeholder="<?php echo $help_site_id2; ?>" id="entry-site_id" class="form-control"/>
					<?php if ($error_site_id) { ?>
						<div class="text-danger"><?php echo $error_site_id; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="entry-ec_enable"><span data-toggle="tooltip" title="<?php echo $help_ec_enable; ?>"><?php echo $entry_ec_enable; ?></span></label>
				<div class="col-sm-10">
					<select name="piwik_ec_enable" id="entry-ec_enable" class="form-control">
						<?php if ($piwik_ec_enable) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="entry-proxy_enable"><span data-toggle="tooltip" title="<?php echo $help_proxy_enable; ?>"><?php echo $entry_proxy_enable; ?></span></label>
				<div class="col-sm-10">
					<select name="piwik_proxy_enable" id="entry-proxy_enable" class="form-control">
						<?php if ($piwik_proxy_enable) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="entry-use_sku"><span data-toggle="tooltip" title="<?php echo $help_use_sku; ?>"><?php echo $entry_use_sku; ?></span></label>
				<div class="col-sm-10">
					<select name="piwik_use_sku" id="entry-use_sku" class="form-control">
						<?php if ($piwik_use_sku) { ?>
							<option value="1" selected="selected"><?php echo $text_sku_sku; ?></option>
							<option value="0"><?php echo $text_sku_model; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_sku_sku; ?></option>
							<option value="0" selected="selected"><?php echo $text_sku_model; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
</div>
<?php echo $footer; ?>