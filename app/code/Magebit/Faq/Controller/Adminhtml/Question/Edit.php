<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\QuestionRepository;
use Magento\Backend\App\{Action, Action\Context};
use Magento\Framework\Controller\{Result\Redirect, ResultFactory, ResultInterface};
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

/**
 * Edit Controller
 */
class Edit extends Action
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magebit_Faq::page_edit';

    /**
     * @var QuestionRepository
     */
    private QuestionRepository $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $question = $this->questionRepository->get((int)$id);

                /** @var Page $result */
                $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
                $result->setActiveMenu('Magebit_Faq::question')->addBreadcrumb(__('Edit question'), __('Question'));
                $result->getConfig()->getTitle()->prepend(__('Edit Question: %question', ['question' => $question->getQuestion()]));
            } catch (NoSuchEntityException $e) {
                /** @var Redirect $result */
                $result = $this->resultRedirectFactory->create();
                $this->messageManager->addErrorMessage(__('Question with id %value does not exist', ['value' => $id]));
                $result->setPath('*/*');
            }
        }

        return $result;
    }
}
