<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * This class gets the list of active CMS pages from PageRepositoryInterface and forms an array of pages for the widget
 */

namespace Magebit\PageListWidget\Model;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Store Options for Cms Pages and Blocks
 */

class Page implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory;
    /**
     * @var PageRepositoryInterface
     */
    private PageRepositoryInterface $pageRepository;

    public function __construct(
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        PageRepositoryInterface $pageRepository
    ) {
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->pageRepository = $pageRepository;

    }

    /**
     * @return array
     * @throws LocalizedException
     */

    public function toOptionArray(): array
    {
        return $this->pageListBuilder();
    }

    /**
     * @return array
     * @throws LocalizedException
     */

    private function pageListBuilder(): array
    {
        $data = array();
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteriaBuilder->addFilter('is_active', 1, 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();
        $cmsPages = $this->pageRepository->getList($searchCriteria)->getItems();
        foreach ($cmsPages as $cmsPage) {
            $data[] = [
                'label' => $cmsPage->getTitle(),
                'value' => $cmsPage->getId()
            ];
        }

        return $data;
    }


}
