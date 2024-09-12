<?php

namespace Mvenghaus\OrderPrevent\Test\Integration;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;
use Mvenghaus\OrderPrevent\Api\Data\RuleInterfaceFactory;
use Mvenghaus\OrderPrevent\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\TestFramework\ObjectManager;

class RuleEntityTest extends \PHPUnit\Framework\TestCase
{
    /** @var ObjectManager */
    private $objectManager;
    /** @var RuleInterfaceFactory */
    private $ruleFactory;
    /** @var RuleRepositoryInterface */
    private $ruleRepository;

    public function setUp(): void
    {
        $this->objectManager = ObjectManager::getInstance();
        $this->ruleFactory = $this->objectManager->get(RuleInterfaceFactory::class);
        $this->ruleRepository = $this->objectManager->get(RuleRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        $tableName = $this->objectManager->get(\Mvenghaus\OrderPrevent\Model\ResourceModel\Rule::class)->getMainTable();
        $dbConnection = $this->objectManager->get(\Magento\Framework\App\ResourceConnection::class)->getConnection();

        $dbConnection->truncateTable($tableName);
    }

    public function testSaveAndLoad()
    {
        $rule = $this->createRule();
        $loadedRule = $this->ruleRepository->getById($rule->getId());

        $this->assertGreaterThan(0, $rule->getId());
        $this->assertSame($rule->getId(), $loadedRule->getId());
        $this->assertSame($rule->getCompany(), $loadedRule->getCompany());
        $this->assertSame($rule->getFirstname(), $loadedRule->getFirstname());
        $this->assertSame($rule->getLastname(), $loadedRule->getLastname());
        $this->assertSame($rule->getPostcode(), $loadedRule->getPostcode());
        $this->assertSame($rule->getCity(), $loadedRule->getCity());
        $this->assertSame($rule->getEmail(), $loadedRule->getEmail());
    }

    public function testLoadMultiple()
    {
        $this->createRule();
        $this->createRule();

        $this->assertTotalCountIs(2);
    }

    public function testDelete()
    {
        $rule = $this->createRule();

        $this->assertTotalCountIs(1);

        $this->ruleRepository->delete($rule);

        $this->assertTotalCountIs(0);
    }

    /**
     * @return RuleInterface
     */
    private function createRule()
    {
        $rule = $this->ruleFactory->create()
            ->setCompany(uniqid('company'))
            ->setFirstname(uniqid('firstname'))
            ->setLastname(uniqid('lastname'))
            ->setPostcode(uniqid('postcode'))
            ->setCity(uniqid('city'))
            ->setEmail(uniqid('email'));

        return $this->ruleRepository->save($rule);
    }


    private function assertTotalCountIs($expected)
    {
        $searchCriteria = ObjectManager::getInstance()->create(SearchCriteriaBuilder::class);
        $this->assertSame($expected, $this->ruleRepository->getList($searchCriteria->create())->getTotalCount());
    }
}
