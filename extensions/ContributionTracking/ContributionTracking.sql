CREATE TABLE IF NOT EXISTS /*_*/contribution_tracking (
  id int(10) unsigned NOT NULL PRIMARY KEY auto_increment,
  contribution_id int(10) unsigned default NULL,
  form_amount varchar(20) default NULL,
  usd_amount decimal(20,2) default NULL,
  note text,
  referrer varchar(4096) default NULL,
  anonymous tinyint(1) unsigned default NULL,
  utm_source varchar(128) default NULL,
  utm_medium varchar(128) default NULL,
  utm_campaign varchar(128) default NULL,
  utm_key varchar(128) default NULL,
  payments_form varchar(50) default NULL,
  optout tinyint(1) unsigned default NULL,
  language varchar(8) default NULL,
  country varchar(2) default NULL,
  ts char(14) default NULL,
  owa_session varbinary(255) default NULL,
  owa_ref int(11) default NULL
) /*wgDBTableOptions*/; 

CREATE UNIQUE INDEX /*i*/contribution_id ON /*_*/contribution_tracking (contribution_id);
CREATE INDEX /*i*/ts ON /*_*/contribution_tracking (ts);
