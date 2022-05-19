<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\{QuestionFactory, QuestionRepository};
use Magento\Backend\{App\Action, App\Action\Context, Model\View\Result\Redirect};
use Magento\Framework\{App\Request\DataPersistorInterface, Controller\ResultInterface, Exception\LocalizedException};

class Save extends Action
{

    protected DataPersistorInterface $dataPersistor;
    private QuestionRepository $questionRepository;
    private QuestionFactory $questionFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionRepository $questionRepository
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        QuestionRepository $questionRepository,
        QuestionFactory $questionFactory
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $model = $this->questionFactory->create();
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                try {
                    $model = $this->questionRepository->get((int)$id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $res = $this->questionRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the question "%question".', ['question' => $model->getData('question')]));
                $this->dataPersistor->clear('faq_question');

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $res->getData('id')]);
                }

                return $resultRedirect->setPath('*/*');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Question.'));
            }

            $this->dataPersistor->set('faq_question', $data);

            return $resultRedirect->setPath('*/*');
        }
        return $resultRedirect->setPath('*/*/');
    }
}
