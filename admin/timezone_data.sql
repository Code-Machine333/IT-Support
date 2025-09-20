-- =====================================================
-- US Timezone Data for ICS Generator
-- =====================================================
-- This file contains SQL INSERT statements for US timezones only
-- Run these queries in Navicat or your preferred database tool

-- =====================================================
-- US Timezones Only
-- =====================================================
INSERT INTO tbltimezone (Name, Description, UTC_Offset, DST_Offset) VALUES 
('US/Eastern', 'Eastern Time (EST/EDT)', '-05:00', '-04:00'),
('US/Central', 'Central Time (CST/CDT)', '-06:00', '-05:00'),
('US/Mountain', 'Mountain Time (MST/MDT)', '-07:00', '-06:00'),
('US/Pacific', 'Pacific Time (PST/PDT)', '-08:00', '-07:00'),
('US/Alaska', 'Alaska Time (AKST/AKDT)', '-09:00', '-08:00'),
('US/Hawaii', 'Hawaii Time (HST)', '-10:00', '-10:00'),
('UTC', 'Coordinated Universal Time', '+00:00', '+00:00');

-- =====================================================
-- Verification Queries
-- =====================================================

-- Check all US timezones
SELECT * FROM tbltimezone ORDER BY Name;

-- Check US timezones only
SELECT * FROM tbltimezone WHERE Name LIKE 'US/%' ORDER BY Name;

-- Count total timezones
SELECT COUNT(*) as Total_Timezones FROM tbltimezone;

-- =====================================================
-- Update User Timezone References (Optional)
-- =====================================================

-- Set default timezone for users who don't have one
-- UPDATE tbluser SET fk_timezone = (SELECT id FROM tbltimezone WHERE Name = 'US/Eastern') WHERE fk_timezone IS NULL;

-- =====================================================
-- Notes
-- =====================================================
-- 1. UTC_Offset: Standard time offset from UTC
-- 2. DST_Offset: Daylight saving time offset from UTC (if different)
-- 3. Hawaii doesn't observe daylight saving time (DST_Offset = UTC_Offset)
-- 4. The ICS generator will automatically handle DST transitions
-- 5. All timezone names follow PHP DateTimeZone format
-- 6. This includes all 6 major US timezones + UTC
