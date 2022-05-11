<?php

/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;


class PageList extends Template implements BlockInterface
{
    private array $activePages;
    protected PageRepositoryInterface $_pageRepository;
    protected SearchCriteriaBuilderFactory $_searchCriteriaBuilder;

    /**
     * @param Context $context
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilder
     * @param array $data
     * @throws LocalizedException
     */
    public function __construct(
        Context                      $context,
        PageRepositoryInterface      $pageRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilder,
        array                        $data = []
    )
    {
        $this->_pageRepository = $pageRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->activePages = $this->getAllAboutActivePages();
        $this->setTemplate('page-list.phtml');
        parent::__construct($context, $data);
    }


    /**
     * @throws LocalizedException
     * get a list of active cms pages
     */

    public function getCmsPageCollection(): array
    {
        $searchCriteriaBuilder = $this->_searchCriteriaBuilder->create();
        $searchCriteriaBuilder->addFilter('is_active', 1, 'eq');
        $searchCriteria = $searchCriteriaBuilder->create();
        $cmsPages = $this->_pageRepository->getList($searchCriteria)->getItems();

        return $cmsPages;
    }

    /**
     * @param array|null $links
     * @return array
     * compose an array of links with information about them by their id
     * If $links is not equal to null, we make an array with only those pages whose ids are in the $links
     */

    private function getNamedLinksArray(array $links = null): array
    {
        $res = array();
        foreach ($this->activePages as $page) {
            if (is_array($links)) {
                if (in_array($page["page_id"], $links)) {
                    $data["link"] = $page["link"];
                    $data["title"] = $page["title"];
                    $res[] = $data;
                }
            } else {
                $data["link"] = $page["link"];
                $data["title"] = $page["title"];
                $res[] = $data;
            }
        }

        return $res;
    }

    /**
     * @param string $displayMode
     * @return bool
     * check widget settings to know how to create list pages
     */

    private function checkDisplayMode(string $displayMode): bool
    {
        if ($displayMode === "all") {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     * @throws LocalizedException
     * get all info about active cms pages
     */

    private function getAllAboutActivePages(): array
    {
        $res = array();
        $collection = $this->getCmsPageCollection();

        foreach ($collection as $page) {
            $data['page_id'] = $page->getData('page_id');
            $data['title'] = $page->getData('title');
            $data['link'] = $page->getData('identifier');
            $res[] = $data;
        }

        return $res;
    }

    /**
     * @return array
     * pass an array of pages to the template
     */

    public function getLinksArray(): array
    {
        if ($this->checkDisplayMode($this->getData("display_mode"))) {
            $link_options = $this->getData("pages");
            $arr_options = explode(",", $link_options);
            $linksArray = $this->getNamedLinksArray($arr_options);
        } else {
            $linksArray = $this->getNamedLinksArray();
        }

        return $linksArray;
    }
}
