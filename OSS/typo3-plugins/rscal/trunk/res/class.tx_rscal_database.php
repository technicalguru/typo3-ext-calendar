<?php

require_once(t3lib_extMgm::extPath('rsextbase').'res/class.tx_rsextbase_database.php');


class tx_rscal_database extends tx_rsextbase_database {

	/**
	 * The series attributes that will be overridden by events.
	 * @var array
	 */
	var $overridingKeys = array('title', 'category', 'location', 'bodytext');
	/**
	 * Already loaded category records (key = UID).
	 * @var array
	 */
	var $categoryCache  = array();
	/**
	 * Already loaded series records (key = UID).
	 * @var array
	 */
	var $seriesCache  = array();
	
	/**
	 * Returns the category.
	 * The method will check the categoryCache first to avoid unncessary calls.
	 * @param mixed $value series/event record or uid of category
	 */
	function getCategory($value) {
		if (is_array($value)) $value = $value['category'];
		if (!$this->categoryCache[$value]) {
			$this->categoryCache[$value] = $this->getRecordByUid('tx_rscal_categories', $value);
		}
		return $this->categoryCache[$value];
	}
	
	/**
	 * Returns the series record.
	 * The method will check the internal seriesCache first.
	 * @param mixed $value event record or uid of series
	 */
	function getSeries($value) {
		if (is_array($value)) $value = $value['series'];
		if (!$this->seriesCache[$value]) {
			$this->seriesCache[$value] = $this->getRecordByUid('tx_rscal_series', $value);
		}
		return $this->seriesCache[$value];
	}
	
	/**
	 * Returns the event with given UID
	 * @param int $uid
	 */
	function getEvent($uid) {
		$where = "uid=$uid";
		$arr = $this->getEvents($where);
		return $arr[0];
	}
	
	/**
	 * Returns the events.
	 * @param string $whereClause additional where clause (without pid, hidden and deleted)
	 */
	function getEvents($whereClause) {
		$rc = array();
		$where = "pid=".$this->config['storagePid'];
		if ($whereClause) $where .= " AND $whereClause";
		$where .= " AND hidden=0 AND deleted=0";
		$events = $this->getRecords('tx_rscal_events', $where);
		foreach ($events AS $event) {
			$item['event'] = $event;
			if ($event['series'] > 0) {
				$item['series'] = $this->getSeries($event['series']);
				$item['combined'] = $this->getCombinedRecord($item['series'], $event);
				$item['series_category'] = $this->getCategory($item['series']['category']);
				$item['event_category'] = $this->getCategory($item['combined']['category']);
				$tmp = $item['combined'];
				tx_rsextbase_pibase::addArray($tmp, 'category', $item['event_category']);
				$item['rendering'] = $tmp;
			} else {
				$item['event_category'] = $this->getCategory($event['category']);
				$tmp = $item['event'];
				tx_rsextbase_pibase::addArray($tmp, 'category', $item['event_category']);
				$item['rendering'] = $tmp;
			}
			$rc[] = $item;
		}
		return $rc;
	}
	
	/**
	 * Returns the combined record (replacing unset event properties by
	 * their counterparts in the series record).
	 * @param array $series
	 * @param array $event
	 */
	function getCombinedRecord($series, $event) {
		foreach ($this->overridingKeys AS $key) {
			$value = $event[$key];
						
			// INT values must be negative for override, Strings are empty
			if (is_int($value)) {
				if ($value < 0) $event[$key] = $series[$key];
			} else if (!$value) {
				$event[$key] = $series[$key];
			}
		}
		return $event;
	}
}

?>