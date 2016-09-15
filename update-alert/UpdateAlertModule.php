<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 14/09/2016
 * Time: 14:52
 */

class UpdateAlertModule {
	private $name;
	private $moduleName;
	private $currentVersion;
	private $availableVersion;

	function __construct($name, $moduleName, $currentVersion, $availableVersion) {
		$this->name = $name;
		$this->moduleName = $moduleName;
		$this->currentVersion = $currentVersion;
		$this->availableVersion = $availableVersion;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getModuleName() {
		return $this->moduleName;
	}

	/**
	 * @return mixed
	 */
	public function getCurrentVersion() {
		return $this->currentVersion;
	}

	/**
	 * @return mixed
	 */
	public function getAvailableVersion() {
		return $this->availableVersion;
	}
}