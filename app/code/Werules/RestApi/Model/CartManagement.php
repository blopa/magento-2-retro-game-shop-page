<?php
namespace Werules\RestApi\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Werules\RestApi\Api\CartManagementInterface;
use Werules\RestApi\Model\Api\BaseModel;

class CartManagement extends BaseModel implements CartManagementInterface
{
    /**
     * @var \Magento\Quote\Api\CartManagementInterface
     */
    protected $cartManagement;

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
     * @param \Magento\Quote\Api\CartManagementInterface $cartManagement
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
        \Magento\Quote\Api\CartManagementInterface $cartManagement
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
        $this->cartManagement = $cartManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function getCartItemCount()
    {
        $quote = $this->getQuote();
        
        // If quote doesn't exist, create a new one
        if (!$quote->getId()) {
            $storeId = $this->storeManager->getStore()->getId();
            $customerId = $this->customerSession->getCustomerId();
            
            if ($customerId) {
                $quoteId = $this->cartManagement->createEmptyCartForCustomer($customerId);
            } else {
                $quoteId = $this->cartManagement->createEmptyCart();
            }
            
            $quote->load($quoteId);
            $quote->setStoreId($storeId);
            $quote->save();
        }

        return (int)$quote->getItemsQty();
    }

    /**
     * {@inheritdoc}
     */
    public function addItemToCart($productId, $qty = 1, $couponCode = null)
    {
        $result = [
            'success' => false,
            'message' => '',
            'cart_count' => 0
        ];

        try {
            $product = $this->productRepository->getById($productId);
            
            if (!$product->isSalable()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('This product is not available.')
                );
            }

            $quote = $this->getQuote();
            
            // If quote doesn't exist, create a new one
            if (!$quote->getId()) {
                $storeId = $this->storeManager->getStore()->getId();
                $customerId = $this->customerSession->getCustomerId();
                
                if ($customerId) {
                    $quoteId = $this->cartManagement->createEmptyCartForCustomer($customerId);
                } else {
                    $quoteId = $this->cartManagement->createEmptyCart();
                }
                
                $quote->load($quoteId);
                $quote->setStoreId($storeId);
            }

            // Apply coupon code if provided
            if ($couponCode) {
                $quote->setCouponCode($couponCode);
            }

            // Add product to cart
            $quote->addProduct($product, $qty);
            $quote->collectTotals();
            $this->quoteRepository->save($quote);

            $result['success'] = true;
            $result['message'] = __('%1 was added to your shopping cart.', $product->getName());
            $result['cart_count'] = (int)$quote->getItemsQty();
            
        } catch (NoSuchEntityException $e) {
            $result['message'] = __('The product does not exist.');
        } catch (\Exception $e) {
            $result['message'] = $e->getMessage();
        }

        return $result;
    }
}
