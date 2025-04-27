<?php
namespace Werules\GameShop\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Werules\GameShop\Api\ProductManagementInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

class ProductManagement implements ProductManagementInterface
{
    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var GetSalableQuantityDataBySku
     */
    protected $getSalableQuantity;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param ProductCollectionFactory $productCollectionFactory
     * @param StoreManagerInterface     $storeManager
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        GetSalableQuantityDataBySku $getSalableQuantity,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        $this->getSalableQuantity = $getSalableQuantity;
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
     * Return products by category ID.
     *
     * Each product includes id, sku, name, price, image_url
     *
     * @param int $categoryId
     * @return array
     */
    public function getProductsByCategoryId($categoryId)
    {
        if (!$this->isModuleEnabled()) {
            return [];
        }

        $store = $this->storeManager->getStore();
        $mediaUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $collection = $this->productCollectionFactory->create();
        $collection->addCategoriesFilter(['in' => $categoryId]);
        $collection->addAttributeToSelect(['name', 'price', 'sku', 'image', 'short_description', 'special_price', 'special_from_date', 'special_to_date']);
        $collection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->addAttributeToFilter('visibility', ['neq' => \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE]);
        $collection->setStoreId($store->getId());
        $collection->setOrder('position', 'ASC');

        $products = [];
        foreach ($collection as $product) {
            $sku = $product->getSku();
            $salableQuantityData = $this->getSalableQuantity->execute($sku);

            $totalSalableQty = 0;
            foreach ($salableQuantityData as $stockData) {
                $totalSalableQty += $stockData['qty'];
            }

            if ($totalSalableQty > 0) {
                // Get the image URL
                $imagePath = $product->getImage();
                if ($imagePath && $imagePath != 'no_selection') {
                    $imageUrl = $mediaUrl . 'catalog/product' . $imagePath;
                } else {
                    // Use Magento's placeholder image
                    $imageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product/placeholder/image.jpg';
                }

                $price = (float) $product->getPrice();
                $specialPrice = $product->getSpecialPrice();

                if ($specialPrice) {
                    $from = $product->getSpecialFromDate();
                    $to = $product->getSpecialToDate();
                    $today = (new \DateTime('today'))->format('Y-m-d H:i:s');

                    $fromOk = !$from || $from <= $today;
                    $toOk = !$to || $to >= $today;

                    if ($fromOk && $toOk) {
                        $price = (float) $specialPrice;
                    }
                }

                $products[] = [
                    'id'           => $product->getId(),
                    'sku'          => $sku,
                    'name'         => $product->getName(),
                    'price'        => $price,
                    'image_url'    => $imageUrl,
                    'description'  => $product->getData('short_description'),
                ];
            }
        }

        return $products;
    }
}
