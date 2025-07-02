# GameShop Module Structure

## 📂 app/code/Werules/GameShop
The GameShop module is structured to follow Magento's best practices, ensuring maintainability and scalability. Below is a detailed breakdown of the module's directory structure and its contents.

### 📁 Api/
API service contracts (interfaces) that define the module's web services.
- `CartManagementInterface.php` - Defines cart-related operations (get count, add items)
- `CategoryManagementInterface.php` - Defines methods to retrieve product categories
- `ProductManagementInterface.php` - Defines product-related operations

### 📁 Controller/
Magento controllers that handle HTTP requests.
- `Index/Index.php` - Main controller for the game shop frontend

### 📁 etc/
Module configuration files.

#### 📁 adminhtml/
- `system.xml` - Admin panel configuration for the module

#### 📁 frontend/
- `routes.xml` - Defines frontend routes (e.g., /game-shop)
- `di.xml` - Dependency injection configuration
- `module.xml` - Module declaration and version
- `webapi.xml` - REST API endpoint configurations

### 📁 i18n/
Internationalization files for multiple languages.
- `de_DE.csv` - German translations
- `en_GB.csv` - British English translations
- `en_US.csv` - US English translations
- `es_ES.csv` - Spanish translations
- `fr_FR.csv` - French translations
- `it_IT.csv` - Italian translations
- `nl_NL.csv` - Dutch translations
- `pt_PT.csv` - Portuguese translations

### 📁 Model/
Business logic implementations.
- `CartManagement.php` - Implements cart operations
- `CategoryManagement.php` - Implements category retrieval logic
- `ProductManagement.php` - Implements product-related operations

### 📁 view/frontend/
Frontend view components.

#### 📁 layout/
- `werules_gameshop_index_index.xml` - Layout definition for the main game shop page

#### 📁 page_layout/
- `customs_blank.xml` - Custom blank page layout template

#### 📁 templates/
- `index.phtml` - Main template file for the game shop
- `seo/head.phtml` - SEO meta tags and structured data template

#### 📁 web/
Static assets.

##### 📁 css/
- `gameshop.css` - Custom CSS styles for the game shop
- `tailwind.min.css` - Minified Tailwind CSS framework

##### 📁 images/
- `shopkeeper.png` - Shopkeeper avatar image used in the UI

##### 📁 js/
- `tailwind.min.js` - Tailwind CSS JavaScript (if using JIT mode)
- `vue.global.js` - Vue.js framework for reactive UI components

### 📄 registration.php
Module registration file that tells Magento about the module's existence.

## 🔄 Module Dependencies
- Magento_Backend - For admin panel functionality
- Magento_Catalog - For product and category management
- Magento_Checkout - For cart operations
- Magento_Store - For multi-store support
