<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Question\Grid;

use Magento\Framework\Data\Collection\{Db\FetchStrategyInterface as FetchStrategy,
    EntityFactoryInterface as EntityFactory};
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param $mainTable
     * @param $resourceModel
     * @throws LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger        $logger,
        FetchStrategy $fetchStrategy,
        EventManager  $eventManager,
                      $mainTable = 'magebit_faq',
                      $resourceModel = 'Magebit\Faq\Model\ResourceModel\Question',
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel,
        );
    }
}
