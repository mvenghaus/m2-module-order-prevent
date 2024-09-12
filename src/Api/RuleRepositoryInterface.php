<?php

namespace Mvenghaus\OrderPrevent\Api;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface RuleRepositoryInterface
{

    public function save(RuleInterface $rule);

    /**
     * @param $id
     * @return RuleInterface
     */
    public function getById($id);

    public function delete(RuleInterface $rule);

    public function getList(SearchCriteriaInterface $searchCriteria): RuleSearchResultsInterface;
}
