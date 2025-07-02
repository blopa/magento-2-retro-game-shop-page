# Werules_RestApi

A Magento 2 module that provides REST API endpoints for the GameShop frontend.

## Features

- Provides REST API endpoints for product, category, and cart management
- Follows Magento 2 coding standards and best practices
- Supports guest and customer sessions
- Implements proper error handling and validation

## Installation

1. Install the module using Composer:
   ```
   composer require werules/magento2-restapi
   ```

2. Enable the module:
   ```
   bin/magento module:enable Werules_RestApi
   ```

3. Run setup upgrade:
   ```
   bin/magento setup:upgrade
   ```

4. Deploy static content (if needed):
   ```
   bin/magento setup:static-content:deploy
   ```

5. Flush cache:
   ```
   bin/magento cache:flush
   ```

## API Endpoints

### Get Categories
- **URL**: `/rest/V1/werules/restapi/categories`
- **Method**: `GET`
- **Response**: Array of active categories with id, name, url_key, path, level, and children_count

### Get Products by Category
- **URL**: `/rest/V1/werules/restapi/products?categoryId={categoryId}`
- **Method**: `GET`
- **Parameters**:
  - `categoryId` (required): The category ID to filter products by
- **Response**: Array of products in the specified category

### Get Cart Item Count
- **URL**: `/rest/V1/werules/restapi/cart/count`
- **Method**: `GET`
- **Response**: Integer representing the number of items in the cart

### Add Item to Cart
- **URL**: `/rest/V1/werules/restapi/cart/add`
- **Method**: `POST`
- **Request Body**:
  ```json
  {
    "productId": 123,
    "qty": 1,
    "couponCode": "DISCOUNT10"
  }
  ```
- **Response**: Object containing success status, message, and updated cart count

## Dependencies

- Magento_Catalog
- Magento_Checkout
- Magento_Store

## Versioning

This module follows [Semantic Versioning](https://semver.org/).

## License

[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)
