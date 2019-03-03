# Change Log
All notable changes to this project will be documented in this file, formatted via [this recommendation](http://keepachangelog.com/).

## [1.1.1] - 2018-03-15
### Changed
- IPN callback URLs to new URLs PayPal recommends (previous ones are being deprecated/removed).
- Processing hook order (decreased priority) to avoid conflicts with the User Registration addon.

## [1.1.0] - 2017-09-27
### Added
- Donation payments include description from payment items.

### Changed
- All HTTP requests now validate target sites SSL certificates with WP bundled certificates (since 3.7).

### Fixed
- Email validation issue by converting all email addresses to lowercase first.

## [1.0.9] - 2017-01-17
### Added
- New action for completed transactions, `wpforms_paypal_standard_process_complete`.

## [1.0.8] - 2016-12-08
### Added
- Support for Dropdown Items payment field.

## [1.0.7] - 2016-08-25
### Added
- Expanded support for additional currencies.

### Changed
- Removed setting to disable IPN verification.
- Improved IPN verification.

### Fixed
- Localization issues/bugs.

## [1.0.6] - 2016-08-04
### Changed
- Multiple payment items now also include label of selected choice in item description.
- PayPal BN code.

## [1.0.5] - 2016-07-07
### Added
- Conditional logic for payments.

### Changed
- Improved error logging.

## [1.0.4] - 2016-06-23
### Changed
- Prevent plugin from running if WPForms Pro is not activated.

## [1.0.3] - 2016-03-28
### Changed
- IPN setting has been moved to the new "Payments" settings tab.

## [1.0.2] - 2016-03-16
### Fixed
- Issue with donation transaction types.

## [1.0.1] - 2016-03-16
### Fixed
- Issue posting to PayPal due to incorrect URL.
