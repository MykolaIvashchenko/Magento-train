<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionManagementInterface;
use Magento\Framework\Exception\{AlreadyExistsException, NoSuchEntityException};

class QuestionManagement implements QuestionManagementInterface
{
    /**
     * @var QuestionRepository
     */
    private QuestionRepository $questionRepository;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param int $id
     * @return bool
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function enableQuestion(int $id): bool
    {
        $model = $this->questionRepository->get($id);
        $model->setStatus(true);
        $this->questionRepository->save($model);

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function disableQuestion(int $id): bool
    {
        $model = $this->questionRepository->get($id);
        $model->setStatus(false);
        $this->questionRepository->save($model);

        return true;
    }
}
