# GameShop Magento 2 Extension

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
![Magento 2.4.x](https://img.shields.io/badge/Magento-2.4.x-brightgreen)

## Overview
GameShop is a custom Magento 2 extension that provides an interactive **game marketplace**. It includes **frontend pages, API endpoints, and SEO optimizations**, allowing users to browse and manage gaming-related products.

![Main Screen](https://raw.githubusercontent.com/blopa/magento-2-retro-game-shop-page/refs/heads/main/screenshots/gameshop-screenshot-1.png)

## Features
- 🛒 **Cart Management API**: Retrieve and add products to the cart
- 📂 **Category API**: Fetch active product categories with localized names
- 🎮 **Product API**: Get product details including salable quantities and pricing
- 🌍 **Multi-language & Multi-currency**: Built-in support for internationalization
- 🏗 **Modern Frontend**:
   - Built with Vue.js 3 for reactive interfaces
   - Styled with TailwindCSS for responsive design
   - Retro gaming aesthetic with pixel-perfect UI
- 🔍 **SEO Optimized**:
   - Dynamic meta tags for social sharing (Facebook, Twitter, WhatsApp)
   - JSON-LD structured data for rich search results
   - Semantic HTML5 markup

## 🚀 Installation

### 🛠 System Requirements
- Magento 2.4.x
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer for dependency management
- Node.js 14+ (for development)

### ⚙️ Installation Steps

### 1️⃣ **Copy the Extension to Magento**
Place the extension files inside:
```
app/code/Werules/GameShop/
```

### 2️⃣ **Enable the Extension**
Run the following commands:
```sh
bin/magento module:enable Werules_GameShop
bin/magento setup:upgrade
bin/magento cache:flush
```

### 3️⃣ **Deploy Static Content (for production)**
```sh
bin/magento setup:static-content:deploy
```

---

## Configuration

### ✅ **Enable/Disable from Admin Panel**
Navigate to:
```
Stores > Configuration > Werules > GameShop Settings
```
- Toggle the **"Enable GameShop"** setting.

### 🔗 **Frontend Route**
The **GameShop frontend page** is accessible at:
```
https://yourmagento.com/game-shop
```

### 🔥 **API Endpoints**
| **Endpoint**                | **Method** | **Description**                |
|-----------------------------|-----------|--------------------------------|
| `/rest/V1/gameshop/cart/count` | `GET`     | Get cart item count.          |
| `/rest/V1/gameshop/cart/add`   | `POST`    | Add product to cart.          |
| `/rest/V1/gameshop/categories` | `GET`     | Get active categories.        |
| `/rest/V1/gameshop/products/{category_id}` | `GET` | Get products by category. |

---

## SEO Enhancements
- ✅ **Meta Tags for Social Sharing (Facebook, Twitter, WhatsApp)**
- ✅ **`JSON-LD` Structured Data for Google**
- ✅ **Customizable via `seo/head.phtml`**
- ✅ **Shopkeeper Avatar as Preview Image**

To update SEO content, edit:
```
app/code/Werules/GameShop/view/frontend/templates/seo/head.phtml
```
---

## Screenshots

1. **Main shop screen**:

   ![Main Screen](https://raw.githubusercontent.com/blopa/magento-2-retro-game-shop-page/refs/heads/main/screenshots/gameshop-screenshot-1.png)

2. **Product listing screen**:

   ![Product Listing Screen](https://raw.githubusercontent.com/blopa/magento-2-retro-game-shop-page/refs/heads/main/screenshots/gameshop-screenshot-2.png)

3. **Product details screen**:

   ![Product Details Screen](https://raw.githubusercontent.com/blopa/magento-2-retro-game-shop-page/refs/heads/main/screenshots/gameshop-screenshot-3.png)

---

## 🎨 Customization Guide

### Frontend Customization
1. **Styles**: Edit the main CSS file at:
   ```
   app/code/Werules/GameShop/view/frontend/web/css/gameshop.css
   ```

2. **Templates**: Modify the main template at:
   ```
   app/code/Werules/GameShop/view/frontend/templates/index.phtml
   ```

3. **SEO Meta Tags**: Update SEO settings in:
   ```
   app/code/Werules/GameShop/view/frontend/templates/seo/head.phtml
   ```

### Adding New Languages
1. Add new translation files in:
   ```
   app/code/Werules/GameShop/i18n/
   ```
   Follow the pattern `{language}_{COUNTRY}.csv` (e.g., `es_ES.csv`)

## 🐞 Troubleshooting

### Common Issues
1. **Blank Page After Installation**
   - Clear Magento cache: `bin/magento cache:flush`
   - Check PHP error logs
   - Ensure the module is enabled in Admin Panel

2. **JavaScript Errors**
   - Clear browser cache
   - Run `bin/magento setup:static-content:deploy`
   - Check browser console for specific errors

3. **API Endpoints Not Working**
   - Verify the module is enabled
   - Check Magento's Web API configuration
   - Ensure proper permissions are set

## 🔄 Upgrading
When upgrading to a new version:
1. Backup your customizations
2. Run:
   ```sh
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy
   bin/magento cache:flush
   ```

## 🚮 Uninstallation
To completely remove the extension:
```sh
bin/magento module:disable Werules_GameShop
rm -rf app/code/Werules/GameShop/
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

## 📝 License
This extension is licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 👥 Contributing
Contributions are welcome! Please read our [Contributing Guidelines](CONTRIBUTING.md) before submitting pull requests.

## 📬 Support
For support, please open an issue in the [GitHub repository](https://github.com/blopa/magento-2-retro-game-shop-page).

---

🚀 **Developed with ❤️ by blopa**

[![Werules](https://img.shields.io/badge/Visit-Werules-0078D4?style=flat&logo=github)](https://github.com/werules)
