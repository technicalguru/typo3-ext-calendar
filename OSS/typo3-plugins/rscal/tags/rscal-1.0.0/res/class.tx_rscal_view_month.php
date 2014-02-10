<?php

require_once(t3lib_extMgm::extPath('rscal').'res/class.tx_rscal_view_base.php');

class tx_rscal_view_month extends tx_rscal_view_base {
	
	/**
	 * Renders the monthly view.
	 */
	function renderView($params) {
		$params = $this->getPeriod($params);
		
		$template = $this->getSubTemplate('MONTH_VIEW');
		
		$rc = $this->fillTemplate($template, 'month_single', $params);

		return $rc;
	}
	
	/**
	 * Loops over a single week and renders the content.
	 * @param object $caller
	 * @param string $template
	 * @param array $singleMarkers
	 * @param array $subpartMarkers
	 * @param array $wrapped
	 * @param string $mode
	 * @param mixed $info
	 */
	function getLoopWeekdaysMarkers($caller, $template, &$singleMarkers, &$subpartMarkers, $wrapped, $mode, $info) {
		$rc = '';
		$today = getdate(time());
		
		$weekdays = Date_Calc::getWeekDays();
		$weekdays[7] = $weekdays[0]; unset($weekdays[0]);
		$time = $info['week_start'];
		
		foreach ($weekdays AS $id => $name) {
			$info['weekday'] = $name;
			$info['time'] = $time;
			
			if ($time) {
				$dinfo = getdate($time);
				$info['mday'] = $dinfo['mday'];
				$info['style'] = 'monthLargeBasic';
				if ($dinfo['mon'] != $info['month']) {
					$info['style'] .= " monthOff";
				}
				if (($dinfo['mday'] == $today['mday']) && ($dinfo['mon'] == $today['mon']) && ($dinfo['year'] == $today['year'])) {
					$info['style'] .= " monthToday";
				} else if (($info['week_start'] <= time()) && (time() < $info['week_end'])) {
					$info['style'] .= " monthSelectedWeek";
				}
				$info['day_start'] = $time;
				
				$time += 26*3600;
				// Correct end date in case of DST switch inbetween
				$dinfo = getdate($time);
				$time  = mktime(0, 0, 0, $dinfo['mon'], $dinfo['mday'], $dinfo['year']);
				$info['day_end'] = $time;
				
				// Select the events of this day and pass it on
				$info['events'] = $this->db->getEvents("(event_start >= $info[day_start]) AND (event_start < $info[day_end])");
				
				// canEdit info
				$info['canEdit'] = $this->canEdit();
			}
			
			$rc .= $this->fillTemplate($template, 'month_weekday', $info);
		}
		$subpartMarkers['###LOOP_WEEKDAYS###'] = $rc;
	}

	/**
	 * Loops over a weeks in a month and renders the content.
	 * @param object $caller
	 * @param string $template
	 * @param array $singleMarkers
	 * @param array $subpartMarkers
	 * @param array $wrapped
	 * @param string $mode
	 * @param mixed $info
	 */
	function getLoopWeeksMarkers($caller, $template, &$singleMarkers, &$subpartMarkers, $wrapped, $mode, $info) {
		$rc = '';
		$time = $info['begin'];
		while ($time < $info['end']) {
			$dinfo = getdate($time);
			$info['week_num'] = Date_Calc::weekOfYear($dinfo['mday'], $dinfo['mon'], $dinfo['year']);
			$info['week_start'] = $time;
			$time += 7*24*3600+7200;
			// Correct end date in case of DST switch inbetween
			$dinfo = getdate($time);
			$time  = mktime(0, 0, 0, $dinfo['mon'], $dinfo['mday'], $dinfo['year']);
			$info['week_end'] = $time;
			
			$info['style'] = 'month-weeknums monthWeekWithEvent';
			if (($info['week_start'] <= time()) && (time() < $info['week_end'])) {
				$info['style'] .= " monthSelectedWeek";
			}
			$rc .= $this->fillTemplate($template, 'month_week', $info);
			
		}
		$subpartMarkers['###LOOP_WEEKS###'] = $rc;
	}
	
	/**
	 * Loops over events of a single day and renders the content.
	 * @param object $caller
	 * @param string $template
	 * @param array $singleMarkers
	 * @param array $subpartMarkers
	 * @param array $wrapped
	 * @param string $mode
	 * @param mixed $info
	 */
	function getAllDayMarkers($caller, $template, &$singleMarkers, &$subpartMarkers, $wrapped, $mode, $info) {
		$rc = "";
		foreach ($info['events'] AS $event) {
			if ($event['combined']['allday']) {
				// TODO Mark the event as editable if user can do so
				$rc .= $this->fillTemplate($template, 'month_allday', $event['rendering']);
			}
		}
		$subpartMarkers['###ALL_DAY###'] = $rc;
	}
	
	/**
	 * Loops over events of a single day and renders the content.
	 * @param object $caller
	 * @param string $template
	 * @param array $singleMarkers
	 * @param array $subpartMarkers
	 * @param array $wrapped
	 * @param string $mode
	 * @param mixed $info
	 */
	function getEventMarkers($caller, $template, &$singleMarkers, &$subpartMarkers, $wrapped, $mode, $info) {
		$rc = "";
		foreach ($info['events'] AS $event) {
			if (!$event['combined']['allday']) {
				// TODO Mark the event as editable if user can do so
				$event['rendering']['canEdit'] = $this->canEdit($event);
				$rc .= $this->fillTemplate($template, 'month_event', $event['rendering']);
			}
		}
		$subpartMarkers['###EVENT###'] = $rc;
	}
	
	/**
	 * Returns the first and the last timestamps.
	 * @param array $params the initial parameters
	 */
	function getPeriod($params) {
		if (!$params['year']) {
			$now = time();
			$nowDate = getdate($now);
			$params['year']  = $nowDate['year'];
			$params['month'] = $nowDate['mon'];
		}
		
		// Compute the timestamps 1. of month 00:00:00 / last day of month 23:59:59
		$params['beginPeriod'] = mktime(0, 0, 0, $params['month'], 1, $params['year']);
		$params['endPeriod']   = $params['beginPeriod'] + Date_Calc::daysInMonth($params['month'], $params['year'])*24*3600+7200;
		
		// Correct end date in case of DST switch inbetween
		$info = getdate($params['endPeriod']);
		$params['endPeriod']  = mktime(0, 0, 0, $info['mon'], 1, $info['year'])-1;
		
		// As we display in weeks, roll down begin to previous monday
		$time = $params['beginPeriod'];
		$info = getdate($time);
		while ($info['wday'] != 1) {
			$time -= 22*3600;
			$info = getdate($time);
			// Fix the time in case of a DST change
			$time = mktime(0, 0, 0, $info['mon'], $info['mday'], $info['year']);
		}
		$params['begin'] = $time;
		
		// As we display in weeks, roll up end to next monday
		$time = $params['endPeriod'];
		$info = getdate($time);
		while ($info['wday'] != 0) {
			$time += 22*3600;
			$info = getdate($time);
			// Fix the time in case of a DST change
			$time = mktime(23, 59, 59, $info['mon'], $info['mday'], $info['year']);
		}
		$params['end'] = $time;
		
		return $params;
	}
}

?>