# Release Notes for 1.x

## [v1.2.0 (2021-02-03)](https://github.com/payment-gateways/paypal-sdk/compare/v1.1.0...v1.2.0)

### Added
- Added support for PHP 8.0 ([#38](https://github.com/payment-gateways/paypal-sdk/pull/38))

## [v1.1.0 (2021-01-17)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.5...v1.1.0)

### Added
- Added `createSubscription()` method in Subscriptions API ([#36](https://github.com/payment-gateways/paypal-sdk/pull/36))
- Added `getSubscription()` method in Subscriptions API ([#37](https://github.com/payment-gateways/paypal-sdk/pull/37))

## [v1.0.5 (2021-01-06)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.4...v1.0.5)

### Fixed
- Separate PayPalApiMock in its own project ([#35](https://github.com/payment-gateways/paypal-sdk/pull/35))

## [v1.0.4 (2020-12-30)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.3...v1.0.4)

### Fixed
- Properties accessed before initialization in UpdatePlanRequest ([#34](https://github.com/payment-gateways/paypal-sdk/pull/34))

## [v1.0.3 (2020-12-30)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.2...v1.0.3)

### Fixed
- setupFee can be optional for plan update ([#32](https://github.com/payment-gateways/paypal-sdk/pull/32))

## [v1.0.2 (2020-12-29)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.1...v1.0.2)

### Fixed
- Properties accessed before initialization in UpdateProductRequest ([#30](https://github.com/payment-gateways/paypal-sdk/pull/30))

## [v1.0.1 (2020-12-28)](https://github.com/payment-gateways/paypal-sdk/compare/v1.0.0...v1.0.1)

### Fixed
- Properties accessed before initialization in StoreProductRequest ([#28](https://github.com/payment-gateways/paypal-sdk/pull/28))

## [v1.0.0 (2020-12-21)](https://github.com/payment-gateways/paypal-sdk/compare/v0.2.0...v1.0.0)

### Added
- Added response object to handle HttpClientResponse ([#23](https://github.com/payment-gateways/paypal-sdk/pull/23))

### Changed
- Changed all response types in PayPalService ([#23](https://github.com/payment-gateways/paypal-sdk/pull/23))

# Release Notes for 0.x

## [v0.2.0 (2020-12-20)](https://github.com/payment-gateways/paypal-sdk/compare/v0.1.1...v0.2.0)

### Added
- Added `getProduct()` method in Catalog Products API ([#20](https://github.com/payment-gateways/paypal-sdk/pull/20))
- Added Subscriptions API integration ([#20](https://github.com/payment-gateways/paypal-sdk/pull/20))

## [v0.1.1 (2020-12-18)](https://github.com/payment-gateways/paypal-sdk/compare/v0.1.0...v0.1.1)

### Fixed
- Fixed request overlapping ([#18](https://github.com/payment-gateways/paypal-sdk/pull/19))