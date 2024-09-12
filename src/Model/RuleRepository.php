<?php
declare(strict_types=1);

namespace Mvenghaus\OrderPrevent\Model;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleInterfaceFactory;
use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterfaceFactory;
use Mvenghaus\OrderPrevent\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class RuleRepository implements RuleRepositoryInterface
{
    private RuleInterfaceFactory              $ruleFactory;
    private RuleCollectionFactory             $ruleCollectionFactory;
    private RuleSearchResultsInterfaceFactory $ruleSearchResultsFactory;
    private SearchCriteriaBuilder             $searchCriteriaBuilder;
    private CollectionProcessorInterface      $collectionProcessor;

    public function __construct(
        RuleInterfaceFactory $ruleFactory,
        RuleCollectionFactory $ruleCollectionFactory,
        RuleSearchResultsInterfaceFactory $ruleSearchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionProcessorInterface $collectionProcessor)
    {
        $this->ruleFactory = $ruleFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->ruleSearchResultsFactory = $ruleSearchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(RuleInterface $rule)
    {
        return $this->getById($rule->getId())->setData($rule->getData())->save();
    }

    public function getById($id)
    {
        return $this->ruleFactory->create()->load($id);
    }

    public function delete(RuleInterface $rule)
    {
        return $this->getById($rule->getId())->delete();
    }

    public function getList(SearchCriteriaInterface $searchCriteria): RuleSearchResultsInterface
    {
        /** @var \Mvenghaus\OrderPrevent\Model\ResourceModel\Rule\Collection $collection */
        $collection = $this->ruleCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var RuleSearchResultsInterface $searchResult */
        $searchResult = $this->ruleSearchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
