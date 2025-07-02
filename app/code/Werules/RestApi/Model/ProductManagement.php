<?php
namespace Werules\RestApi\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Werules\RestApi\Api\ProductManagementInterface;
use Werules\RestApi\Model\Api\BaseModel;

class ProductManagement extends BaseModel implements ProductManagementInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

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
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
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
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
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
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductsByCategoryId($categoryId)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $products = [];

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addCategoriesFilter(['in' => $categoryId])
            ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
            ->addAttributeToFilter('visibility', ['in' => [
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH,
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH
            ]]);

        foreach ($collection as $product) {
            try {
                $productModel = $this->productRepository->getById($product->getId(), false, $storeId, true);
                $products[] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'sku' => $product->getSku(),
                    'price' => $product->getPrice(),
                    'final_price' => $product->getFinalPrice(),
                    'image' => $product->getImage() ? $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/product' . $product->getImage() : null,
                    'url_key' => $product->getUrlKey(),
                    'is_salable' => $product->isSalable(),
                    'qty' => $product->getQty() ?: 0
                ];
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }

        return $products;
    }
}
