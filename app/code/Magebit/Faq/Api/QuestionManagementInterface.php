<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Api;

interface QuestionManagementInterface
{
    /**
     * @param int $id
     * @return bool
     */
    function enableQuestion (int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    function disableQuestion (int $id): bool;
}
