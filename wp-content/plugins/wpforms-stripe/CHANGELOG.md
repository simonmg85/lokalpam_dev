# Change Log
All notable changes to this project will be documented in this file, formatted via [this recommendation](http://keepachangelog.com/).

## [1.1.1] - 2017-08-24
### Changed
- Remove JS functionality adopted in core plugin

## [1.1.0] - 2017-06-13
### Changed
- Use settings API for WPForms v1.3.9.

## [1.0.9] - 2017-08-01
### Changed
- Improved performance when checking for credit card fields in the form builder

## [1.0.8] - 2017-03-30
### Changed
- Updated Stripe API PHP library
- Improved Stripe class instance accessibility

## [1.0.7] - 2017-01-17
### Changed
- Check for charge object before firing transaction completed hook

## [1.0.6] - 2016-12-08
### Added
- Support for Dropdown Items payment field
- New hook for completed transactions, `wpforms_stripe_process_complete`
- New filter stored credit card information, `wpforms_stripe_creditcard_value`

## [1.0.5] - 2016-10-07
### Fixed
- Javascript processing method to avoid conflicts with core duplicate submit prevention feature

## [1.0.4] - 2016-08-22
### Added
- Expanded support for additional currencies

### Fixed
- Localization issues/bugs

### Changed

## [1.0.3] - 2016-07-07
### Added
- Conditional logic for payments

### Changed
- Improved error logging

## [1.0.2] - 2016-06-23
### Changed
- Prevent plugin from running if WPForms Pro is not activated

## [1.0.1] - 2016-04-01
### Fixed
- PHP notices with some configurations

## [1.0.0] - 2016-03-28
### Added
- Initial release
