--
-- Make two things default to NULL
--
alter table /*_*/contribution_tracking modify anonymous tinyint(1) unsigned default null, modify optout tinyint(1) unsigned default null;
