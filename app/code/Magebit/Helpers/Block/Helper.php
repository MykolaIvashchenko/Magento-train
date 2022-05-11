<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magebit\Helpers\Block;

use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\App\Helper\Context;

class Helper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $stockState;

    /**
     * Output constructor.
     * @param Context $context
     * @param StockStateInterface $stockState
     */
    public
    function __construct(
        Context             $context,
        StockStateInterface $stockState
    )
    {
        $this->stockState = $stockState;
        parent::__construct($context);
    }

    /**
     * Retrieve stock qty whether product
     *
     * @param int $productId
     * @param int|null $websiteId
     * @return float
     */
    public function getStockQty(int $productId, int $websiteId = null): float
    {
        return $this->stockState->getStockQty($productId, $websiteId);
    }
}
