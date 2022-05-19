<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\{App\Action, Model\View\Result\Redirect, App\Action\Context, Model\View\Result\RedirectFactory};
use Magento\Framework\{App\Action\HttpPostActionInterface,
    App\ResponseInterface,
    Controller\ResultInterface,
    Exception\AlreadyExistsException,
    Exception\LocalizedException,
    Exception\NoSuchEntityException};
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\{ResourceModel\Question\CollectionFactory, QuestionManagement};

/**
 * Class MassDisable
 */
class MassEnable extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magebit_Faq::save';

    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var QuestionManagement
     */
    private QuestionManagement $questionManagement;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QuestionManagement $questionManagement
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QuestionManagement $questionManagement,
        RedirectFactory $redirectFactory,
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->questionManagement = $questionManagement;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     * @throws LocalizedException
     * @throws AlreadyExistsExceptiongit
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $question) {
            $this->questionManagement->enableQuestion((int)$question->getId());
        }
        $this->messageManager->addSuccessMessage(__('A total of %count record(s) have been enabled.', ['count' => $collection->getSize()]));
        return $this->redirectFactory->create()->setPath('*/*/');
    }
}
