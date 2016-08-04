--
-- create contribution_tracking.owa_session and owa_ref
--
-- BEGIN
-- 	ALTER TABLE /*_*/contribution_tracking ADD owa_session VARCHAR(255) default NULL;
-- EXCEPTION
-- 	WHEN owa_session THEN RAISE NOTICE 'column <owa_session> already exists in contribution_tracking.';
-- END;
-- BEGIN
-- 	ALTER TABLE /*_*/contribution_tracking ADD owa_ref INTEGER default NULL;
-- EXCEPTION
-- 	WHEN owa_ref THEN RAISE NOTICE 'column <owa_session> already exists in contribution_tracking.';
BEGIN
END;
