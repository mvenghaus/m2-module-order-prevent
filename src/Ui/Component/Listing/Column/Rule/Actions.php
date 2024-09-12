<?php

namespace Mvenghaus\OrderPrevent\Ui\Component\Listing\Column\Rule;

use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $name = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$rule) {
                $rule[$name]['edit'] = [
                    'href' => $this->getContext()->getUrl('mvenghaus_orderprevent/rule/edit', ['id' => $rule['id']]),
                    'label' => __('Edit')
                ];

                $rule[$name]['delete'] = [
                    'href' => $this->getContext()->getUrl('mvenghaus_orderprevent/rule/delete', ['id' => $rule['id']]),
                    'label' => __('Delete')
                ];
            }
        }

        return $dataSource;
    }
}
