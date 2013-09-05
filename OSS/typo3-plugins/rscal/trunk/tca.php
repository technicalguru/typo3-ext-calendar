<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_rscal_categories'] = array (
	'ctrl' => $TCA['tx_rscal_categories']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,image'
	),
	'feInterface' => $TCA['tx_rscal_categories']['feInterface'],
	'columns' => array (
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		// TITLE
		'title' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_categories.title',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'required,trim',
			),
		),
		// IMAGE
		'image' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_categories.image',
			'config' => array (
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => 'gif,png,jpeg,jpg',	
				'show_thumbs'   => 1,	
				'size'          => 1,	
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden,title,image'),
	),
	'palettes' => array (
	)
);


$TCA['tx_rscal_series'] = array (
	'ctrl' => $TCA['tx_rscal_categories']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'title,category'
	),
	'feInterface' => $TCA['tx_rscal_series']['feInterface'],
	'columns' => array (
		'hidden' => array (	
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		// TITLE
		'title' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.title',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'required,trim',
			),
		),
		// LOCATION
		'location' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.location',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'required,trim',
			),
		),
		// CATEGORY
		'category' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.category',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_rscal_categories',
				'foreign_table_where' => 'AND tx_rscal_categories.pid=###CURRENT_PID###',
			)
		),
		// BODYTEXT
		'bodytext' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.bodytext',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '20',
				'wrap' => 'virtual',
				'eval' => 'required,trim',
			),
			'defaultExtras' => 'richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/user_upload/]',
		),
		// REPEAT START
		'repeat_start' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.repeat_start',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date,required',
				'default'  => '0',
			),
		),
		// REPEAT END
		'repeat_end' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.repeat_end',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'default'  => '0',
				'eval' => 'required,trim',
			),
		),
		// START TIME
		'time_start' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.time_start',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'default'  => '0',
				'eval'     => 'required,trim,int',
			),
		),
		// DURATION
		'time_length' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.time_length',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'default'  => '0',
				'eval'     => 'required,trim,int',
			),
		),
		// RECURRENCE TYPE
		'repeat_type' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.repeat_type',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'required,trim',
			),
		),
		// RECURRENCE INFO
		'repeat_info' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_series.repeat_info',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'required,trim',
			),
		),
	),
	'types' => array(
		0 => array('showitem' => 'hidden;;;;;;;;2-2-2,title;;;;3-3-3,location,category,bodytext;;;;5-5-5,repeat_type,repeat_info,repeat_start,repeat_end,time_start,time_length'),
	),
);

// EVENTS
$TCA['tx_rscal_events'] = array (
	'ctrl' => $TCA['tx_rscal_events']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'title,category'
	),
	'feInterface' => $TCA['tx_rscal_events']['feInterface'],
	'columns' => array (
		'hidden' => array (	
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		// SERIES
		'series' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.series',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_rscal_series',
				'foreign_table_where' => 'AND tx_rscal_series.pid=###CURRENT_PID###',
			)
		),
		// SERIES COUNTER
		'series_number' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.series_number',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'default'  => '0',
				'eval'     => 'trim,int',
			),
		),
		// TITLE
		'title' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.title',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'trim',
			),
		),
		// LOCATION
		'location' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.location',
			'config' => array (
				'type' => 'input',
				'size' => '48',
				'eval' => 'trim',
			),
		),
		// CATEGORY
		'category' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.category',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_rscal_categories',
				'foreign_table_where' => 'AND tx_rscal_categories.pid=###CURRENT_PID###',
			)
		),
		// BODYTEXT
		'bodytext' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.bodytext',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '20',
				'wrap' => 'virtual',
				'eval' => 'trim',
			),
			'defaultExtras' => 'richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/user_upload/]',
		),
		// START
		'event_start' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.event_start',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'datetime,required',
				'default'  => '0',
			),
		),
		// END
		'event_end' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:rscal/locallang_db.xml:tx_rscal_events.event_end',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'datetime,required',
				'default'  => '0',
			),
		),
	),
	'types' => array(
		0 => array('showitem' => 'hidden;;;;;;;;2-2-2,title;;;;3-3-3,series,series_number,location,category,bodytext;;;;5-5-5,event_start,event_end'),
	),
);

?>
