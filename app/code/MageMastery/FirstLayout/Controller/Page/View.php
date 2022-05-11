<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageMastery\FirstLayout\Controller\Page;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class View implements ActionInterface
{
    private $resultFactory;

    public function __construct(ResultFactory $resultFactory){
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        /** @var Template $block */
        $block = $page->getLayout()->getBlock('magemastery.first.layout.example');
        $block->setData('custom_parameter', 'Данные от контроллера');
        $block->setData('second_parameter', 'Данные от контроллера2');

        $data = [
            "page1",
            "page2",
            "page3"
        ];

        $block->setData('data', $data);

        return $page;
    }
}
