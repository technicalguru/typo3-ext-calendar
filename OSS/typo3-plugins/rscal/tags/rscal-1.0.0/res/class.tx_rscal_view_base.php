<?php

require_once(t3lib_extMgm::extPath('rsextbase').'res/class.tx_rsextbase_pibase.php');
require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_database.php');

class tx_rscal_view_base extends tx_rsextbase_pibase {

	var $extKey        = 'rscal';	// The extension key.
	var $relPath       = 'pi1';
	var $prefixId      = 'tx_rscal_pi1';
	var $scriptRelPath = 'pi1/class.tx_rscal_pi1.php';
	
	/**
	 * Always call this function before starting
	 * @param $conf configuration
	 */
	function init($config) {
		parent::init($config);
	
		$this->setConfiguration('storagePid');
	}

	/**
	 * Creates the database object
	 */
	function createDatabaseObject() {
		$this->db = t3lib_div::makeInstance('tx_rscal_database');
		$this->db->init($this);
	}
	
	function canEdit($event) {
		return 1;
	}
	
}

?>