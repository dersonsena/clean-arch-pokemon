<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Adapters\Gateways\QueryBuilder\MySQL;

use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\QueryBuilder\MySQL\Select;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    private function makeQuery()
    {
        $connection = $this->getMockBuilder(DatabaseDriver::class)
            ->disableOriginalConstructor()
            ->getMock();

        return new Select($connection);
    }

    public function testIfSimpleQueryIsCreatedCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName');

        $this->assertSame('SELECT * FROM `tableName`', (string)$sql);
    }

    public function testIfQueryWithColumnsIsCreatedCorrectly()
    {
        $sql = $this->makeQuery()
            ->select(['column1', 'column2', 'column3'])
            ->from('tableName');

        $this->assertSame('SELECT `column1`, `column2`, `column3` FROM `tableName`', (string)$sql);
    }

    public function testIfOrderByIsCreatedCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->orderBy(['column1 ASC', 'column2 DESC']);

        $this->assertSame('SELECT * FROM `tableName` ORDER BY column1 ASC, column2 DESC', (string)$sql);
    }

    public function testIfGroupByIsCreatedCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->groupBy(['column1', 'column2']);

        $this->assertSame('SELECT * FROM `tableName` GROUP BY column1, column2', (string)$sql);
    }

    public function testIfLimitIsCreatedWithoutOffsetCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->limit(10);

        $this->assertSame('SELECT * FROM `tableName` LIMIT 10', (string)$sql);
    }

    public function testIfLimitIsCreatedWithOffsetCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->limit(10, 20);

        $this->assertSame('SELECT * FROM `tableName` LIMIT 10 OFFSET 20', (string)$sql);
    }

    public function testIfSimpleWhereIsCreatedCorrectly()
    {
        $sql = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column', 'any_value');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column` = ?', (string)$sql);
    }

    public function testIfWhereOperatorQueryIsCreatedCorrectly()
    {
        $select = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column', 'any_value', '<=');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column` <= ?', (string)$select);
        $this->assertCount(1, $select->getValues());
        $this->assertSame('any_value', $select->getValues()[0]);
    }

    public function testIfAndWhereClauseQueryIsCreatedCorrectly()
    {
        $select = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column', 'any_value', '<')
            ->andWhere('other_column', 'other_value', '>');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column` < ? AND `other_column` > ?', (string)$select);
        $this->assertCount(2, $select->getValues());
        $this->assertSame('any_value', $select->getValues()[0]);
        $this->assertSame('other_value', $select->getValues()[1]);
    }

    public function testIfOrWhereClauseQueryIsCreatedCorrectly()
    {
        $select = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column', 'any_value', '>')
            ->orWhere('other_column', 'other_value', '>=');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column` > ? OR `other_column` >= ?', (string)$select);
        $this->assertCount(2, $select->getValues());
        $this->assertSame('any_value', $select->getValues()[0]);
        $this->assertSame('other_value', $select->getValues()[1]);
    }

    public function testIfCompoundWhereIsCreatedCorrectly()
    {
        $select = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column_1', 'any_value_1')
            ->andWhere('any_column_2', 'any_value_2')
            ->andWhere('any_column_3', 'any_value_3')
            ->orWhere('any_column_4', 'any_value_4')
            ->orWhere('any_column_5', 'any_value_5')
            ->whereLike('any_column_6', '%any_value_6%')
            ->orWhereLike('any_column_7', '%any_value_7%');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column_1` = ? AND `any_column_2` = ? AND `any_column_3` = ? OR `any_column_4` = ? OR `any_column_5` = ? AND `any_column_6` LIKE ? OR `any_column_7` LIKE ?', (string)$select);
        $this->assertCount(7, $select->getValues());
        $this->assertSame('any_value_1', $select->getValues()[0]);
        $this->assertSame('any_value_2', $select->getValues()[1]);
        $this->assertSame('any_value_3', $select->getValues()[2]);
        $this->assertSame('any_value_4', $select->getValues()[3]);
        $this->assertSame('any_value_5', $select->getValues()[4]);
        $this->assertSame('%any_value_6%', $select->getValues()[5]);
        $this->assertSame('%any_value_7%', $select->getValues()[6]);
    }

    public function testShouldGenerateAndWhereClauseIfHasTwoWhereCalls()
    {
        $select = $this->makeQuery()
            ->select()
            ->from('tableName')
            ->where('any_column_1', 'any_value_1')
            ->where('any_column_2', 'any_value_2')
            ->where('any_column_3', 'any_value_3');

        $this->assertSame('SELECT * FROM `tableName` WHERE `any_column_1` = ? AND `any_column_2` = ? AND `any_column_3` = ?', (string)$select);
        $this->assertCount(3, $select->getValues());
        $this->assertSame('any_value_1', $select->getValues()[0]);
        $this->assertSame('any_value_2', $select->getValues()[1]);
        $this->assertSame('any_value_3', $select->getValues()[2]);
    }
}
