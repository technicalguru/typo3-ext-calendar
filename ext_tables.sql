#
# Table structure for table 'tx_rscal_categories'
#
CREATE TABLE tx_rscal_categories (
        uid int(11) unsigned NOT NULL auto_increment,
        pid int(11) unsigned DEFAULT '0' NOT NULL,
        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(1) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(1) unsigned DEFAULT '0' NOT NULL,
        title varchar(255) DEFAULT '' NOT NULL,
		image varchar(255) DEFAULT '' NOT NULL,		
        PRIMARY KEY (uid),
        KEY parent (pid),
);

#
# Table structure for table 'tx_rscal_series'
#
CREATE TABLE tx_rscal_series (
        uid int(11) unsigned NOT NULL auto_increment,
        pid int(11) unsigned DEFAULT '0' NOT NULL,
        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(1) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(1) unsigned DEFAULT '0' NOT NULL,
        title varchar(100) DEFAULT '' NOT NULL,
		category int(11) DEFAULT 0 NOT NULL,
		bodytext text NOT NULL,
		location varchar(30),
		repeat_start int(11) unsigned DEFAULT 0 NOT NULL,
		repeat_end int(11) unsigned DEFAULT 0 NOT NULL,
		time_start int(11) unsigned DEFAULT 0 NOT NULL,
		time_length int(11) unsigned DEFAULT 0 NOT NULL,
		repeat_type varchar(30) DEFAULT '' NOT NULL,
		repeat_info varchar(255) DEFAULT '' NOT NULL,
		
        PRIMARY KEY (uid),
        KEY parent (pid),
);

#
# Table structure for table 'tx_rscal_events'
#
CREATE TABLE tx_rscal_events (
        uid int(11) unsigned NOT NULL auto_increment,
        pid int(11) unsigned DEFAULT '0' NOT NULL,
        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(1) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(1) unsigned DEFAULT '0' NOT NULL,
        series int(11) unsigned DEFAULT 0 NOT NULL,
        series_number int(11) unsigned DEFAULT 0 NOT NULL,
        title varchar(100),
		category int(11),
		bodytext text,
		location varchar(30),
		event_start int(11) unsigned DEFAULT 0 NOT NULL,
		event_end int(11) unsigned DEFAULT 0 NOT NULL,
        allday tinyint(1) unsigned DEFAULT '0' NOT NULL,
		
        PRIMARY KEY (uid),
        KEY parent (pid),
);

