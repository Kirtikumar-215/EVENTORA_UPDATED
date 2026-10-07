# Eventora Verification Report

Date: 2026-10-04

## Automated checks completed
- PHP syntax lint: **PASS** for all PHP files.
- PHP runtime: **PASS** on PHP 8.4.23.
- Public homepage: **HTTP 200**.
- Login page: **HTTP 200**.
- Registration page: **HTTP 200**.
- Static public assets are present.
- MySQL schema and seed data are included in `setup.sql`.

## Database-dependent checks
The execution environment used for packaging does not contain a MySQL/MariaDB server or client, so authenticated workflows could not be executed end-to-end here. The application intentionally returns a clear database-configuration message for those routes until `setup.sql` is imported and `includes/config.php` is configured.

## Expected first-run validation after MySQL setup
1. Import `setup.sql`.
2. Sign in as HOD: `hod@eventora.local` / `Eventora@123`.
3. Open Admin → Event Requests.
4. Register a student account.
5. Submit an event proposal.
6. Approve it from the HOD panel.
7. Register as participant / volunteer / coordinator.
8. Approve the applications from HOD → Team Applications.
