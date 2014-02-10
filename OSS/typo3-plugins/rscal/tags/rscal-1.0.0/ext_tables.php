<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// TypoScript Template
t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'RS Calendar Extension');

/***********************************************************************************************
 * DATABASE EXTENSIONS
 ***********************************************************************************************/
$TCA['tx_rscal_categories'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_categories',
		'label'     => 'title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'default_sortby' => 'ORDER BY UPPER(title)',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'/res/icons/tx_rscal_categories.gif',
	),
);
$TCA['tx_rscal_series'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series',
		'label'     => 'title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'default_sortby' => 'ORDER BY crdate',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'/res/icons/tx_rscal_series.gif',
	),
);
$TCA['tx_rscal_events'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events',
		'label'     => 'title',
		'label_alt' => 'series',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'default_sortby' => 'ORDER BY crdate',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'/res/icons/tx_rscal_events.gif',
	),
);

/***********************************************************************************************
 * PLUGINS
 ***********************************************************************************************/
$i = 1;
while (file_exists(t3lib_extMgm::extPath($_EXTKEY).'pi'.$i.'/class.tx_'.$_EXTKEY.'_pi'.$i.'.php')) {
	$piId = 'pi'.$i;
	$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_'.$piId] = 'layout,select_key';
	$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_'.$piId] = 'pi_flexform';
	t3lib_extMgm::addPlugin(array('LLL:EXT:'.$_EXTKEY.'/'.$piId.'/locallang.xml:tt_content.list_type', $_EXTKEY.'_'.$piId), 'list_type');
	t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_'.$piId, 'FILE:EXT:'.$_EXTKEY.'/'.$piId.'/flexform.xml');
	$i++;
}

?>