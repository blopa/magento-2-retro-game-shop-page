# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Split the original GameShop extension into two independent modules:
  - `Werules_RestApi`: Handles all API endpoints and business logic
  - `Werules_GameShop`: Handles the frontend UI and user experience
- Added Composer support for both modules
- Comprehensive API documentation
- Improved error handling and validation

### Changed
- Updated API endpoints to use the new `/rest/V1/werules/restapi/` base path
- Refactored frontend JavaScript to work with the new API responses
- Improved code organization and separation of concerns

### Removed
- Removed API-related code from the GameShop module
- Removed frontend-related code from the RestApi module

## [1.0.0] - 2023-07-02
### Added
- Initial release of the GameShop extension
