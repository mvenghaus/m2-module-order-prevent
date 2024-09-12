<?php

namespace Mvenghaus\OrderPrevent\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RuleSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get items list.
     *
     * @return RuleInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
