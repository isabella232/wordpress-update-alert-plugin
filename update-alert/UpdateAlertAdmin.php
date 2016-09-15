<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 18/09/2015
 * Time: 15:20
 */

class UpdateAlertAdmin {
	function __construct() {
		// Hooks
		add_action( 'admin_menu', array($this, 'registerMenus') );
		add_action( 'admin_init', array($this, 'registerSetting') );
	}

	public function registerMenus() {
		add_options_page(
			'Update Alert',
			'Update Alert',
			'manage_options',
			'update-alert',
			array($this, 'adminConfiguration')
		);
	}

	public function registerSetting() {
		register_setting(
			'update-alert',  // settings section
			'update-alert-enabled' // setting name
		);
	}

	public function adminConfiguration() {
		$errorList = array();
		$EWORLDACCELERATOR_UPDATEALERT_ENABLED = 1;
		$EWORLDACCELERATOR_UPDATEALERT_DAYS = 1;
		$EWORLDACCELERATOR_UPDATEALERT_EMAIL = '';

		if (isset($_POST['submitConfig']) && $_POST['submitConfig'] == 1) {
			// TODO
		}
		?>
<div class="wrap">
	<h2>Update Alert Settings</h2>

	<?php if (sizeof($errorList) > 0) : ?>
		<div class="error">
			<p><strong><?php echo join('</strong><br /><strong>', $errorList); ?></strong></p></div>
	<?php endif; ?>
	<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') : ?>
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><strong>Settings saved.</strong></p></div>
	<?php endif; ?>

	<form novalidate="novalidate" action="" method="post">
		<input type="hidden" value="1" name="submitConfig">
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row"><label for="pluginenable">Enable plugin</label></th>
				<td>
					<fieldset>
					<label title="Enable email alerts">
						<input type="radio" value="1" name="EWORLDACCELERATOR_UPDATEALERT_ENABLED"<?php if ($EWORLDACCELERATOR_UPDATEALERT_ENABLED == 1) : ?> checked="checked"<?php endif; ?>> <span>Enabled</span>
					</label>
					<br />
					<label title="Disable email alerts">
						<input type="radio" value="2" name="EWORLDACCELERATOR_UPDATEALERT_ENABLED"<?php if ($EWORLDACCELERATOR_UPDATEALERT_ENABLED == 2) : ?> checked="checked"<?php endif; ?>> <span>Disabled</span>
					</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="pluginDays">Day(s) between alerts</label></th>
				<td><input type="text" class="small-text" value="<?php echo $EWORLDACCELERATOR_UPDATEALERT_DAYS; ?>" id="pluginDays" name="EWORLDACCELERATOR_UPDATEALERT_DAYS">
					<p class="description">Minimum: 1, Maximum: 31</p></td>
			</tr>
			<tr>
				<th scope="row"><label for="pluginEmails">Emails</label></th>
				<td><textarea cols="60" rows="6" name="EWORLDACCELERATOR_UPDATEALERT_EMAIL" id="pluginEmails"><?php echo $EWORLDACCELERATOR_UPDATEALERT_EMAIL; ?></textarea>
					<p class="description">1 email per line</p></td>
			</tr>
			</tbody>
		</table>

		<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
	</form>
	<div class="notice notice-warning is-dismissible">
		<p>
		<h2>UpdateAlert needs a cron job executed every day</h2>
		<ul class="list-unstyled">
			<li><strong>You know how to configure a cron job</strong> => add this <em>0 5 * * * wget {$smarty.const._PS_BASE_URL_}/modules/updatealert/cron.php -O /dev/null</em></li>
			<li>or</li>
			<li><strong>You don't know how to add a cron job</strong> => so register on <a href="https://cron-job.org/" target="_blank">cron-job.org (100% free service)</a> and create a cron job like <a href="{$smarty.const._PS_BASE_URL_}/modules/updatealert/cronjob.org.png" target="_blank">described here</a> with this URL : {$smarty.const._PS_BASE_URL_}/modules/updatealert/cron.php</li>
		</ul>
		</p>
	</div>

</div>
		<?php
	}
}
$updateAlertAdmin = new UpdateAlertAdmin();