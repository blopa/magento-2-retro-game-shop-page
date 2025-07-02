<?php
namespace Werules\RestApi\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Werules\RestApi\Api\CategoryManagementInterface;
use Werules\RestApi\Model\Api\BaseModel;

class CategoryManagement extends BaseModel implements CategoryManagementInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Quote\Model\QuoteIdToMaskedQuoteId $quoteIdToMaskedQuoteId
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        \Magento\Framework\Webapi\Rest\Request $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Model\QuoteIdToMaskedQuoteId $quoteIdToMaskedQuoteId,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        parent::__construct(
            $request,
            $storeManager,
            $productRepository,
            $categoryRepository,
            $cart,
            $customerSession,
            $quoteRepository,
            $quoteIdMaskFactory,
            $quoteIdToMaskedQuoteId
        );
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveCategories()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $categories = [];

        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'is_active'])
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('level', ['gt' => 1])
            ->setStoreId($storeId);

        foreach ($collection as $category) {
            try {
                $categoryModel = $this->categoryRepository->get($category->getId(), $storeId);
                if ($categoryModel->getIsActive() && $categoryModel->getLevel() > 1) {
                    $categories[] = [
                        'id' => $category->getId(),
                        'name' => $category->getName(),
                        'url_key' => $category->getUrlKey(),
                        'path' => $category->getPath(),
                        'level' => $category->getLevel(),
                        'children_count' => $category->getChildrenCount()
                    ];
                }
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }

        return $categories;
    }
}
