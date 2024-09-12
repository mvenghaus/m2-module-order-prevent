<?php

namespace Mvenghaus\OrderPrevent\Ui\Component\Listing\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;

class Rule extends AbstractDataProvider
{

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Mvenghaus\OrderPrevent\Model\ResourceModel\Rule\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
