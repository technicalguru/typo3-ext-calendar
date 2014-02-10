<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Administrator <jrt@ralph-schuster.eu>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_pibase.php');

/**
 * Plugin 'Calendar' for the 'rscal' extension.
 *
 * @author	Administrator <typo3@ralph-schuster.eu>
 * @package	TYPO3
 * @subpackage	tx_rscal
 */
class tx_rscal_pi1 extends tx_rscal_pibase {
	
	var $relPath       = 'pi1';
	var $prefixId      = 'tx_rscal_pi1';
	var $scriptRelPath = 'pi1/class.tx_rscal_pi1.php';
	
	/**
	 * Returns the HTML content.
	 */
	function getPluginContent() {		
		if ($this->config['mode'] == 'CALENDAR') {
			$content = $this->getCalendarView();
		}	
		return $this->pi_wrapInBaseClass($content);
	}

	function getCalendarView() {
		// What type of calendar do we display?
		$year   = $this->getGPvar('default', 'year');
		$month  = $this->getGPvar('default', 'month');
		$day    = $this->getGPvar('default', 'day');
		$week   = $this->getGPvar('default', 'week');
		$event  = $this->getGPvar('default', 'event');
		$action = $this->getGPvar('default', 'action');
		$time   = $this->getGPvar('default', 'time');
		
		if ($action == 'create') {
			// Create an event
			$className = $this->config['createEventClass'];
		} else if ($action == 'edit') {
			// Edit this event
			$className = $this->config['editEventClass'];
		} else if ($action == 'delete') {
			// Edit this event
			$className = $this->config['deleteEventClass'];
		} else if ($event) {
			// Display this event
			$className = $this->config['viewEventClass'];
		} else if ($year) {
			if ($month) {
				if ($day) {
					// Display the day only
					$className = $this->config['viewDayClass'];
				} else {
					// Display the month
					$className = $this->config['viewMonthClass'];
				}
			} else if ($week) {
				// Display the week
				$className = $this->config['viewWeekClass'];
			} else {
				// Display the year
				$className = $this->config['viewYearClass'];
			}
		} else {
			// Display current month
			$className = $this->config['viewMonthClass'];
		}
		
		// Create the class for the required action
		$viewClass = t3lib_div::getUserObj($className); // EXT:rscal/res/class.tx_rscal_XXX.php:&tx_rscal_XXX
		$viewClass->cObj = $this->cObj;
		$viewClass->init($this->conf);
		
		// initialize this view with params
		$params = array(
			'year'  => $year,
			'month' => $month,
			'week'  => $week,
			'day'   => $day,
			'event' => $event,
			'time'  => $time,
		);
		
		// Now fill and display the calendar
		$rc = $viewClass->renderView($params);
		
		return $rc;
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rscal/pi1/class.tx_rsccal_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rscal/pi1/class.tx_rscal_pi1.php']);
}

?>
