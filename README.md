# GameShop Magento 2 Extension

## Overview
GameShop is a custom Magento 2 extension that provides an interactive **game marketplace**. It includes **frontend pages, API endpoints, and SEO optimizations**, allowing users to browse and manage gaming-related products.

## Features
- 🛒 **Cart Management API**: Retrieve and add products to the cart.
- 📂 **Category API**: Fetch active product categories.
- 🎮 **Product API**: Get product details, including salable quantities.
- 🏗 **Custom Frontend Page (`/game-shop`)**:
   - SEO-optimized meta tags for social media previews (Facebook, Twitter, WhatsApp).
   - Structured data (`JSON-LD`) for improved **Google search ranking**.
   - Includes TailwindCSS & Vue.js for dynamic interactions.

## Installation

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

## Uninstallation
To remove the extension, run:
```sh
bin/magento module:disable Werules_GameShop
rm -rf app/code/Werules/GameShop/
bin/magento setup:upgrade
bin/magento cache:flush
```

---

## License
This extension is licensed under **MIT**.

---

🚀 **Developed by Werules**
