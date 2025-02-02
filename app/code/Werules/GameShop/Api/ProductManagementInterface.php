<?php
namespace Werules\GameShop\Api;

interface ProductManagementInterface
{
    /**
     * Return products by category ID.
     *
     * @param int $categoryId
     * @return array
     */
    public function getProductsByCategoryId($categoryId);
}
