<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    const ID = 'id';
    const QUESTION = 'question';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @param string $question
     * @return void
     */
    public function setQuestion(string $question): void;

}
