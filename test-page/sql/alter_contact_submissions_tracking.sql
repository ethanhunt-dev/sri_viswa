-- Run once if you already created contact_submissions from an older schema.sql
USE srinivasa_site;

ALTER TABLE contact_submissions
  ADD COLUMN ip_address VARCHAR(45) DEFAULT NULL AFTER remarks,
  ADD COLUMN user_agent VARCHAR(512) DEFAULT NULL AFTER ip_address,
  ADD COLUMN geo_city VARCHAR(128) DEFAULT NULL AFTER user_agent,
  ADD COLUMN geo_state VARCHAR(128) DEFAULT NULL AFTER geo_city,
  ADD COLUMN geo_country VARCHAR(128) DEFAULT NULL AFTER geo_state,
  ADD COLUMN utm_source VARCHAR(128) DEFAULT NULL AFTER geo_country,
  ADD COLUMN utm_campaign VARCHAR(128) DEFAULT NULL AFTER utm_source,
  ADD COLUMN utm_medium VARCHAR(128) DEFAULT NULL AFTER utm_campaign,
  ADD COLUMN utm_term VARCHAR(256) DEFAULT NULL AFTER utm_medium;
