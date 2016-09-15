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

	public function adminConfiguration() {
		$errorList = array();
		$successList = array();
		$EWORLDACCELERATOR_UPDATEALERT_ENABLED = intval(get_option('EWORLDACCELERATOR_UPDATEALERT_ENABLED'));
		$EWORLDACCELERATOR_UPDATEALERT_DAYS = intval(get_option('EWORLDACCELERATOR_UPDATEALERT_DAYS'));
		$EWORLDACCELERATOR_UPDATEALERT_EMAIL = get_option('EWORLDACCELERATOR_UPDATEALERT_EMAIL');

		// If not configured yet => default values
		if ($EWORLDACCELERATOR_UPDATEALERT_ENABLED == 0) {
			$EWORLDACCELERATOR_UPDATEALERT_ENABLED = 1;
			$EWORLDACCELERATOR_UPDATEALERT_DAYS = 7;
			$EWORLDACCELERATOR_UPDATEALERT_EMAIL = '';
		}

		if (isset($_POST['submitConfig']) && $_POST['submitConfig'] == 1) {
			$enabled = isset($_POST['EWORLDACCELERATOR_UPDATEALERT_ENABLED']) ? intval($_POST['EWORLDACCELERATOR_UPDATEALERT_ENABLED']) : 0;
			$days = isset($_POST['EWORLDACCELERATOR_UPDATEALERT_DAYS']) ? intval($_POST['EWORLDACCELERATOR_UPDATEALERT_DAYS']) : 0;
			$emailList = isset($_POST['EWORLDACCELERATOR_UPDATEALERT_EMAIL']) ? trim($_POST['EWORLDACCELERATOR_UPDATEALERT_EMAIL']) : '';

			if ($enabled != 1 && $enabled != 2) {
				$errorList[] = 'Enabled value is not recognized';
			}
			else {
				$oldValue = $EWORLDACCELERATOR_UPDATEALERT_ENABLED;
				update_option('EWORLDACCELERATOR_UPDATEALERT_ENABLED', $enabled);
				$_GET['settings-updated'] = 'true';
				if ($enabled == 1 && $oldValue == 2) {
					$successList[] = 'System enabled';
				}
				else if ($enabled == 2 && $oldValue == 1) {
					$successList[] = 'System disabled';
				}
			}
			if ($emailList == '') {
				$errorList[] = 'Email list is empty. You must set at least 1 email';
			}
			else {
				$listOk = true;
				$emailArray = explode(PHP_EOL, $emailList);
				if (sizeof($emailArray) > 0) {
					foreach ($emailArray as $currentEmail) {
						$currentEmail = trim($currentEmail);
						if (filter_var($currentEmail, FILTER_VALIDATE_EMAIL) === false) {
							$errorList[] = $currentEmail.' is not a valid email address';
							$listOk = false;
						}
					}
				}
				if ($listOk) {
					update_option('EWORLDACCELERATOR_UPDATEALERT_EMAIL', $emailList);
				}
			}
			if ($days < 1 || $days > 31) {
				$errorList[] = 'Days value is not correct';
			}
			else {
				update_option('EWORLDACCELERATOR_UPDATEALERT_DAYS', $days);
			}

			if (sizeof($errorList) <= 0) {
				echo '<script type="text/javascript">document.location.href="?page=update-alert&settings-updated=true"; </script>';
			}
			else {
				if (isset($_GET['settings-updated'])) {
					unset($_GET['settings-updated']);
				}
			}
		}
		?>
<div class="wrap">
	<h2>Update Alert Settings</h2>

	<?php if (sizeof($errorList) > 0) : ?>
		<div class="error">
			<p><strong><?php echo join('</strong><br /><strong>', $errorList); ?></strong></p></div>
	<?php endif; ?>
	<?php if (sizeof($successList) > 0) : ?>
		<div class="success">
			<p><strong><?php echo join('</strong><br /><strong>', $successList); ?></strong></p></div>
	<?php endif; ?>
	<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') : ?>
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><strong>Settings saved.</strong></p></div>
	<?php endif; ?>

	<form novalidate="novalidate" action="?page=update-alert" method="post">
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
		<h2>UpdateAlert needs a cron job executed every day</h2>
		<ul class="list-unstyled">
			<li><strong>You know how to configure a cron job</strong> => add this <em>0 5 * * * wget <?php echo plugin_dir_url( __FILE__ ); ?>cron.php -O /dev/null</em></li>
			<li>or</li>
			<li><strong>You don't know how to add a cron job</strong> => so register on <a href="https://cron-job.org/" target="_blank">cron-job.org (100% free service)</a> and create a cron job like <a href="<?php echo plugin_dir_url( __FILE__ ); ?>cronjob.org.png" target="_blank">described here</a> with this URL : <?php echo plugin_dir_url( __FILE__ ); ?>cron.php</li>
		</ul>
	</div>
	<div class="notice notice-warning is-dismissible">
		<h2>wp_mail() is needed</h2>
		<p>If you don't receive UpdateAlert emails, be sure the PHP mail() function is active on your hosting server.</p>
	</div>

</div>
		<?php
	}
}
$updateAlertAdmin = new UpdateAlertAdmin();