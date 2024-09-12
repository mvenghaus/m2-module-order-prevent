<?php

namespace Mvenghaus\OrderPrevent\Ui\Component\Form\DataProvider;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Rule extends AbstractDataProvider
{
    private $loadedData;

    /** @var DataPersistorInterface */
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Mvenghaus\OrderPrevent\Model\ResourceModel\Rule\CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $rules = $this->collection->getItems();
        $this->loadedData = [];
        foreach ($rules as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('orderprevent_rule');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyRule();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('orderprevent_rule');
        }

        return $this->loadedData;
    }
}
