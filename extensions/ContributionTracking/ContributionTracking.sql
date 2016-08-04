CREATE SEQUENCE contribution_tracking_seq;

CREATE TABLE IF NOT EXISTS /*_*/contribution_tracking (
  id int check (id > 0) NOT NULL PRIMARY KEY default nextval ('contribution_tracking_seq'),
  contribution_id int check (contribution_id > 0) default NULL,
  form_amount varchar(20) default NULL,
  usd_amount decimal(20,2) default NULL,
  note text,
  referrer varchar(4096) default NULL,
  anonymous smallint check (anonymous > 0) default NULL,
  utm_source varchar(128) default NULL,
  utm_medium varchar(128) default NULL,
  utm_campaign varchar(128) default NULL,
  utm_key varchar(128) default NULL,
  payments_form varchar(50) default NULL,
  optout smallint check (optout > 0) default NULL,
  language varchar(8) default NULL,
  country varchar(2) default NULL,
  ts char(14) default NULL,
  owa_session bytea default NULL,
  owa_ref int default NULL
) /*wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/contribution_id ON /*_*/contribution_tracking (contribution_id);
CREATE INDEX /*i*/ts ON /*_*/contribution_tracking (ts);
