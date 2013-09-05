<?php

require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_view_base.php');

class tx_rscal_view_week extends tx_rscal_view_base {

	/**
	 * Renders the weekly view.
	 */
	function renderView($params) {
		return "WEEK";
	}
}

?>