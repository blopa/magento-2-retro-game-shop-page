<?php
namespace Werules\GameShop\Api;

interface CartManagementInterface
{
    /**
     * Return the current cart item count for this session/user.
     *
     * @return int
     */
    public function getCartItemCount();

    /**
     * Add a product (by ID) to the cart with a given quantity.
     *
     * @param int $productId
     * @param float|int $qty
     * @param string|null $couponCode
     * @return array
     *
     * Example response structure:
     * [
     *   'success' => true|false,
     *   'message' => 'Some message',
     *   'cart_count' => int
     * ]
     */
    public function addItemToCart($productId, $qty = 1, $couponCode = null);
}
