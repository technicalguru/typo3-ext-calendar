<?php

require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_view_base.php');

class tx_rscal_view_event extends tx_rscal_view_base {

	/**
	 * Renders the event.
	 */
	function renderView($params) {
		$event = $this->db->getEvent($params['event']);
		$template = $this->getSubTemplate('EVENT_VIEW');

		$event['rendering']['canEdit'] = $this->canEdit($event);
		$rc = $this->fillTemplate($template, 'event_view', $event['rendering']);
		
		return $rc;
	}
}

?>