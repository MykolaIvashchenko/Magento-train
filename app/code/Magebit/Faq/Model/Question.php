<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\{DataObject\IdentityInterface, Model\AbstractModel};

class Question extends AbstractModel implements IdentityInterface, QuestionInterface
{
    const CACHE_TAG = 'magebit_faq';

    protected $_cacheTag = 'magebit_faq';

    protected $_eventPrefix = 'magebit_faq';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Magebit\Faq\Model\ResourceModel\Question');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(QuestionInterface::QUESTION);
    }

    /**
     * @param $question
     * @return void
     */
    public function setQuestion($question): void
    {
        $this->setData(QuestionInterface::QUESTION, $question);
    }

}
