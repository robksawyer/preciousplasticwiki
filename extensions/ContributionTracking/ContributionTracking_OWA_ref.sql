--
-- Schema for OWA_ref
--
-- Used to normalize target pages for OWA "conversions"
--

CREATE SEQUENCE contribution_tracking_owa_ref_seq;

CREATE TABLE IF NOT EXISTS /*_*/contribution_tracking_owa_ref (
	-- URL of event
	url BYTEA unique,

	-- event ID
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL ('contribution_tracking_owa_ref_seq')
) /*$wgDBTableOptions*/;
