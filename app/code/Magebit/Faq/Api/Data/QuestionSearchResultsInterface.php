<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return QuestionInterface[]
     */
    public function getItems();

    /**
     * @param QuestionInterface[]
     * @return void
     */
    public function setItems(array $items);
}
