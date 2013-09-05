<?php

require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_view_base.php');

class tx_rscal_create_event extends tx_rscal_view_base {

	/**
	 * Creates the event.
	 */
	function renderView($params) {
		$arr = array();
		$template = $this->getSubTemplate('EVENT_CREATE');

		if ($this->canEdit()) {
			$arr = array (
				'allday' => 0,
				'startdate' => $params['time'],
				'enddate' => $params['time']+3600,
			);
			print_r($arr);
			$rc = $this->fillTemplate($template, 'event_create', $arr);
		} else {
			// TODO: Redirect to view
			$rc = "ERROR";
		}
		
		return $rc;
	}
}

?>