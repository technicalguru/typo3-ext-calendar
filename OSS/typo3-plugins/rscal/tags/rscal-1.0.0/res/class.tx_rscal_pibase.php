<?php

require_once(t3lib_extMgm::extPath('rsextbase').'res/class.tx_rsextbase_pibase.php');
require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_database.php');
require_once(t3lib_extMgm::extPath('rscal').'res/pearLoader.php');

class tx_rscal_pibase extends tx_rsextbase_pibase {

	var $extKey        = 'rscal';	// The extension key.
	
	/**
	 * Always call this function before starting
	 * @param $conf configuration
	 */
	function init($config) {
		parent::init($config);
	
		$this->setConfiguration('storagePid');
		$this->setConfiguration('createEventClass');
		$this->setConfiguration('editEventClass');
		$this->setConfiguration('deleteEventClass');
		$this->setConfiguration('viewEventClass');
		$this->setConfiguration('viewDayClass');
		$this->setConfiguration('viewWeekClass');
		$this->setConfiguration('viewMonthClass');
		$this->setConfiguration('viewYearClass');
	}

	/**
	 * Creates the database object
	 */
	function createDatabaseObject() {
		$this->db = t3lib_div::makeInstance('tx_rscal_database');
		$this->db->init($this);
	}
	
}

?>