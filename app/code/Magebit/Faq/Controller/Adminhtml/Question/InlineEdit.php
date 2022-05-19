<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\{Action, Action\Context};
use Magento\Framework\Controller\Result\JsonFactory;
use Magebit\Faq\Model\{QuestionFactory, ResourceModel\Question as QuestionResource};

class InlineEdit extends Action
{
    protected JsonFactory $jsonFactory;
    private QuestionFactory $dataFactory;
    private QuestionResource $questionResource;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        QuestionFactory $dataFactory,
        QuestionResource $questionResource)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->dataFactory = $dataFactory;
        $this->questionResource = $questionResource;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax'))
        {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems))
            {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }
            else
            {
                foreach (array_keys($postItems) as $modelId)
                {
                    $model = $this->dataFactory->create();
                    $this->questionResource->load($model, $modelId);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$modelId]));
                        $this->questionResource->save($model);
                    }
                    catch (Exception $e)
                    {
                        $messages[] = "[Error : {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
