<?php
namespace Werules\RestApi\Api;

interface CategoryManagementInterface
{
    /**
     * Return active categories (id and name).
     *
     * @return array
     */
    public function getActiveCategories();
}
