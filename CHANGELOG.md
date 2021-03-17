# Release Notes for 2.x

## [v2.0.0 (2021-03-14)](https://github.com/payment-gateways/paypal-sdk/compare/v1.2.0...v2.0.0)

### Fixed
- Fixed required values for `toArray()` in ShippingDetailAddressPortable ([#47](https://github.com/payment-gateways/paypal-sdk/pull/47))

### Added
- Added setters for Money ([#47](https://github.com/payment-gateways/paypal-sdk/pull/47))
- Added getter for billing cycles set ([#43](https://github.com/payment-gateways/paypal-sdk/pull/43))
- Added getters and setters for frequency and pricing schema ([#43](https://github.com/payment-gateways/paypal-sdk/pull/43))
- Added status field in store plan request ([#43](https://github.com/payment-gateways/paypal-sdk/pull/43)) 
- Added id field in store product request ([#40](https://github.com/payment-gateways/paypal-sdk/pull/40))

### Changed
- Changed `Frequency` by `IntervalUnit` ([#47](https://github.com/payment-gateways/paypal-sdk/pull/47))
- Changed `getId()` by `getPlanId()` ([#46](https://github.com/payment-gateways/paypal-sdk/pull/46))
- Changed `getId()` by `getProductId()` ([#44](https://github.com/payment-gateways/paypal-sdk/pull/44))
- Changed `setDescription()` by `setPlanDescription()` ([#42](https://github.com/payment-gateways/paypal-sdk/pull/42))
- Changed `setName()` by `setPlanName()` ([#42](https://github.com/payment-gateways/paypal-sdk/pull/42))
- Now APIs are separated ([#41](https://github.com/payment-gateways/paypal-sdk/pull/41))
- Changed `setDescription()` by `setProductDescription()` ([#39](https://github.com/payment-gateways/paypal-sdk/pull/39))
- Changed `setCategory()` by `setProductCategory()` ([3e6d2a](https://github.com/payment-gateways/paypal-sdk/commit/61c545ae6f9be2b2f8412bfece8c696d4e3e6d2a))
- Changed `setName()` by `setProductName()` ([3e6d2a](https://github.com/payment-gateways/paypal-sdk/commit/61c545ae6f9be2b2f8412bfece8c696d4e3e6d2a))
- Changed `setType()` by `setProductType()` ([3e6d2a](https://github.com/payment-gateways/paypal-sdk/commit/61c545ae6f9be2b2f8412bfece8c696d4e3e6d2a))
