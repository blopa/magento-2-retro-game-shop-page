<?php
namespace Werules\RestApi\Model\Api;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask;

class BaseModel
{
    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var \Magento\Quote\Model\QuoteIdToMaskedQuoteId
     */
    protected $quoteIdToMaskedQuoteId;

    /**
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Customer\Model\Session $customerSession
     * @param CartRepositoryInterface $quoteRepository
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Quote\Model\QuoteIdToMaskedQuoteId $quoteIdToMaskedQuoteId
     */
    public function __construct(
        \Magento\Framework\Webapi\Rest\Request $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Customer\Model\Session $customerSession,
        CartRepositoryInterface $quoteRepository,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Model\QuoteIdToMaskedQuoteId $quoteIdToMaskedQuoteId
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->cart = $cart;
        $this->customerSession = $customerSession;
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->quoteIdToMaskedQuoteId = $quoteIdToMaskedQuoteId;
    }

    /**
     * Get current quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    protected function getQuote()
    {
        return $this->cart->getQuote();
    }

    /**
     * Get masked quote ID
     *
     * @param int $quoteId
     * @return string
     */
    protected function getMaskedQuoteId($quoteId)
    {
        try {
            return $this->quoteIdToMaskedQuoteId->execute($quoteId);
        } catch (NoSuchEntityException $e) {
            $quoteIdMask = $this->quoteIdMaskFactory->create();
            $quoteIdMask->setQuoteId($quoteId)->save();
            return $quoteIdMask->getMaskedId();
        }
    }
}
