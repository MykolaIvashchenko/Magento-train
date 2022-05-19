<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\{QuestionInterface, QuestionSearchResultsInterface, QuestionSearchResultsInterfaceFactory};
use Magebit\Faq\Model\ResourceModel\{Question as QuestionResource, Question\CollectionFactory};
use Magento\Framework\Api\{SearchCriteria\CollectionProcessorInterface, SearchCriteriaInterface};
use Magento\Framework\Exception\{AlreadyExistsException, NoSuchEntityException, StateException};

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var QuestionResource
     */
    private QuestionResource $questionResource;

    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var QuestionSearchResultsInterfaceFactory
     */
    private QuestionSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @param QuestionFactory $questionFactory
     * @param CollectionFactory $collectionFactory
     * @param QuestionResource $questionResource
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct
    (
        QuestionFactory $questionFactory,
        CollectionFactory $collectionFactory,
        QuestionResource $questionResource,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->questionFactory = $questionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->questionResource = $questionResource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return QuestionInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id): QuestionInterface
    {
        $object = $this->questionFactory->create();
        $this->questionResource->load($object, $id);
        if( !$object->getId() ){
            throw new NoSuchEntityException(__('Unable to find question with ID %1', $id));
        }

        return $object;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws AlreadyExistsException
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        $this->questionResource->save($question);
        return $question;
    }

    /**
     * @param QuestionInterface $question
     * @return bool
     * @throws StateException
     */
    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->questionResource->delete($question);
        } catch (Exception $e) {
          throw new StateException(__('Unable to remove question %1', $question->getId()));
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById($id): bool
    {
        $question = $this->get((int) $id);
        try {
            $this->questionResource->delete($question);
        } catch (Exception $e) {
            throw new StateException(__('Unable to remove question "$1"', $question->getId()));
        }

        return true;
    }
}
