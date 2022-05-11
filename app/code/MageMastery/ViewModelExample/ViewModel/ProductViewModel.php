<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MageMastery\ViewModelExample\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductViewModel implements ArgumentInterface
{
    public function getTitle()
    {
        return 'Text from ViewModel';
    }
}
