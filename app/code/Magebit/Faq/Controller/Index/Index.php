<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Index;

use Magento\Framework\App\{Action\Context, ActionInterface, ResponseInterface};
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\{Result\Page, Result\PageFactory};

class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Frequently Asked Questions'));

        return $resultPage;
    }
}
