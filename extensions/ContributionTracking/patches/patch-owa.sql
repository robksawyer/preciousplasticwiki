--
-- create contribution_tracking.owa_session and owa_ref
--
ALTER TABLE /*_*/contribution_tracking ADD owa_session varchar(255) default NULL;
ALTER TABLE /*_*/contribution_tracking ADD owa_ref integer(11) default NULL;
