<?php
namespace Werules\GameShop\Api;

interface CategoryManagementInterface
{
    /**
     * Return active categories (id and name).
     *
     * @return array
     */
    public function getActiveCategories();
}
