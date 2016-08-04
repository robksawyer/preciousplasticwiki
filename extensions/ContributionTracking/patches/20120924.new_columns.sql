-- Update to add a few new columns for analytics information

-- In addition to the language, it is also helpful to go ahead and store the country
-- in contribution_tracking to avoid the 3-level join to get it from CiviCRM
-- This also means that we track country for the 2nd-step abandons
ALTER TABLE /*_*/contribution_tracking ADD COLUMN country VARCHAR(2) DEFAULT NULL AFTER language;

-- Store the amount that was specified on the contribution form a la
-- civicrm.civicrm_contribution.source (e.g. "USD 20.00" or "EUR 15.50")
ALTER TABLE /*_*/contribution_tracking ADD COLUMN form_amount VARCHAR(20) DEFAULT NULL AFTER contribution_id;

-- For analytics it is useful to have an approximation of the USD amount of the donation
-- especially since donations can settle in multiple currencies.
ALTER TABLE /*_*/contribution_tracking ADD COLUMN usd_amount DECIMAL(20,2) DEFAULT NULL AFTER form_amount;

-- Store the paymentswiki form through which the donation was made.
ALTER TABLE /*_*/contribution_tracking ADD COLUMN payments_form VARCHAR(128) DEFAULT NULL AFTER utm_key;



-- Add a few indicies that will be useful
CREATE INDEX /*i*/language ON /*$wgDBprefix*/contribution_tracking (language);
CREATE INDEX /*i*/country ON /*$wgDBprefix*/contribution_tracking (country);
CREATE INDEX /*i*/payments_form ON /*$wgDBprefix*/contribution_tracking (payments_form);
