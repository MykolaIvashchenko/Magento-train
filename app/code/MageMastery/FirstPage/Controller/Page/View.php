<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace MageMastery\FirstPage\Controller\Page;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

class View implements ActionInterface
{
    private $resultFactory;

    public function __construct(ResultFactory $resultFactory){
        $this->resultFactory = $resultFactory;
    }
    public function execute()
    {
        /** @var Json $jsonResult */
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $jsonResult->setData([
            'message' => 'My First Page'
        ]);
        return $jsonResult;
    }
}
