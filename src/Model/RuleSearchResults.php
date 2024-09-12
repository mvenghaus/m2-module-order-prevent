<?php
declare(strict_types=1);

namespace Mvenghaus\OrderPrevent\Model;

use Mvenghaus\OrderPrevent\Api\Data\RuleSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class RuleSearchResults extends SearchResults implements RuleSearchResultsInterface
{

}
