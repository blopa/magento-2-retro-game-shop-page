# GameShop Module Structure

## 📦 Module Split Overview

The functionality has been split into two independent modules:

1. **Werules_RestApi** - Handles all API endpoints and business logic
2. **Werules_GameShop** - Frontend interface that consumes the API

## 📂 1. Werules_RestApi Module

### 📁 Api/
API service contracts (interfaces) that define the web services.
- `CartManagementInterface.php` - Defines cart-related operations
- `CategoryManagementInterface.php` - Defines category retrieval methods
- `ProductManagementInterface.php` - Defines product-related operations

### 📁 etc/
#### 📁 adminhtml/
- `system.xml` - Admin configuration for API settings

#### 📄 di.xml
Dependency injection configuration for API services

#### 📄 webapi.xml
REST API endpoint configurations:
- `GET /rest/V1/werules/restapi/categories`
- `GET /rest/V1/werules/restapi/products/{categoryId}`
- `GET /rest/V1/werules/restapi/cart/count`
- `POST /rest/V1/werules/restapi/cart/add`

### 📁 i18n/
API-specific translations (error messages, validation messages)
- `en_US.csv` - Base translations (add other languages as needed)

### 📁 Model/
Business logic implementations.
- `CartManagement.php` - Cart operations implementation
- `CategoryManagement.php` - Category retrieval implementation
- `ProductManagement.php` - Product operations implementation

### 📄 registration.php
Module registration file

## 📂 2. Werules_GameShop Module

### 📁 Controller/
- `Index/Index.php` - Main controller for the game shop frontend

### 📁 etc/
#### 📁 adminhtml/
- `system.xml` - Frontend-specific configurations

#### 📁 frontend/
- `routes.xml` - Defines frontend routes (e.g., /game-shop)
- `di.xml` - Frontend dependency injection
- `module.xml` - Module declaration

### 📁 i18n/
Frontend translations (UI text, labels, buttons)
- `de_DE.csv` - German
- `en_GB.csv` - British English
- `en_US.csv` - US English
- `es_ES.csv` - Spanish
- `fr_FR.csv` - French
- `it_IT.csv` - Italian
- `nl_NL.csv` - Dutch
- `pt_PT.csv` - Portuguese

### 📁 view/frontend/
#### 📁 layout/
- `werules_gameshop_index_index.xml` - Main layout definition

#### 📁 page_layout/
- `customs_blank.xml` - Custom blank page layout

#### 📁 templates/
- `index.phtml` - Main template (updated API endpoints)
- `seo/head.phtml` - SEO meta tags

#### 📁 web/
##### 📁 css/
- `gameshop.css` - Custom styles
- `tailwind.min.css` - Tailwind CSS

##### 📁 images/
- `shopkeeper.png` - Shopkeeper avatar

##### 📁 js/
- `tailwind.min.js` - Tailwind JS
- `vue.global.js` - Vue.js framework

### 📄 registration.php
Module registration

## 🔄 API Endpoint Updates in GameShop

All API URLs in the frontend templates have been updated to use the new RestApi module:

In `index.phtml`:
```php
data-categories-url="<?= $block->getUrl('rest/V1/werules/restapi/categories'); ?>"
data-products-url="<?= $block->getUrl('rest/V1/werules/restapi/products'); ?>"
data-cart-count-url="<?= $block->getUrl('rest/V1/werules/restapi/cart/count'); ?>"
data-cart-add-url="<?= $block->getUrl('rest/V1/werules/restapi/cart/add'); ?>"
```

## 🚀 Module Dependencies

### Werules_RestApi
- Magento_Catalog
- Magento_Checkout
- Magento_Store

### Werules_GameShop
- Werules_RestApi (as a service, not a hard dependency)
- Magento_Store
- Magento_Theme