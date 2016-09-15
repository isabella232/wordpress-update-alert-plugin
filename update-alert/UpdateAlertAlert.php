<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 14/09/2016
 * Time: 15:07
 */

class UpdateAlertAlert {
	/** @var int $firstAlert */
	private $firstAlert;
	/** @var int $lastAlert */
	private $lastAlert;
	/** @var string $moduleName */
	private $moduleName;
	/** @var string $version */
	private $version;

	function __construct($moduleName, $version, $firstAlert) {
		$this->firstAlert = $firstAlert;
		$this->lastAlert = $firstAlert;
		$this->moduleName = $moduleName;
		$this->version = $version;
	}

	/**
	 * @return int
	 */
	public function getFirstAlert() {
		return $this->firstAlert;
	}

	/**
	 * @return int
	 */
	public function getLastAlert() {
		return $this->lastAlert;
	}

	/**
	 * @return string
	 */
	public function getModuleName() {
		return $this->moduleName;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	public function alertSent() {
		$this->lastAlert = time();
	}
}