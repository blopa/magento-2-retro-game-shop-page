<?php
namespace Werules\GameShop\Model;

use Werules\GameShop\Api\CategoryManagementInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Werules\GameShop\Api\ProductManagementInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CategoryManagement implements CategoryManagementInterface
{
    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductManagementInterface
     */
    protected $productManagement;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface     $storeManager
     * @param ProductManagementInterface $productManagement
     */
    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        ProductManagementInterface $productManagement,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productManagement = $productManagement;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if the Game Shop module is enabled.
     *
     * @return bool
     */
    private function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag('gameshop/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return active categories that contain salable products for the current store view.
     *
     * @return array
     */
    public function getActiveCategories()
    {
        if (!$this->isModuleEnabled()) {
            return [];
        }

        // Get the current store and its root category ID
        $store = $this->storeManager->getStore();
        $rootCategoryId = $store->getRootCategoryId();
        $storeId = $store->getId();

        // Build a category collection
        $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect(['name', 'is_active'])
            ->addFieldToFilter('is_active', 1)
            // Use "path" to ensure they're children of the store's root category
            ->addAttributeToFilter('path', ['like' => "1/{$rootCategoryId}/%"])
            ->addAttributeToFilter('level', ['gteq' => 2])
            ->setStoreId($storeId)
            ->setOrder('position', 'ASC');

        $categories = [];

        foreach ($collection as $category) {
            // Check if the category has at least one salable product
            $salableProducts = $this->productManagement->getProductsByCategoryId($category->getId());

            if (!empty($salableProducts)) {
                $categories[] = [
                    'id'   => $category->getId(),
                    'name' => $category->getName(),
                ];
            }
        }

        return $categories;
    }
}
