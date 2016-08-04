-- Update to add a column to store utm_key information

-- Store utm_key information that uniquely identifies an utm tracking instance
-- along with utm_source, utm_medium, and utm_campaign
ALTER TABLE /*_*/contribution_tracking ADD utm_key varchar(128) default NULL AFTER utm_campaign;

-- Add an index on utm_key since we will be doing lookups and joins
CREATE INDEX /*i*/utmkey ON /*$wgDBprefix*/contribution_tracking (utm_key);
