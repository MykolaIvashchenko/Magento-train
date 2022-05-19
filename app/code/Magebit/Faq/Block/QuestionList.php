<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * Block for displaying frequently asked questions.
 */

declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\View\Element\{Template, Template\Context};
use Magento\Framework\Api\{SearchCriteriaBuilderFactory, SortOrderBuilder};

class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepository;
    private SearchCriteriaBuilderFactory $searchCriteriaBuilder;
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context                      $context,
        QuestionRepositoryInterface  $questionRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array|null
     * This method returns a list of active FAQs
     * If there are no active FAQs, the method returns nothing.
     */
    public function getQuestions(): ?array
    {
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('ASC')->create();
        $searchCriteriaBuilder = $this->searchCriteriaBuilder->create();
        $searchCriteria = $searchCriteriaBuilder->addFilter('status', 1)->setSortOrders([$sortOrder])->create();
        $questions = $this->questionRepository->getList($searchCriteria)->getItems();


        if(is_countable($questions) && count($questions) > 0){
            return $questions;
        }

        return null;
    }
}
