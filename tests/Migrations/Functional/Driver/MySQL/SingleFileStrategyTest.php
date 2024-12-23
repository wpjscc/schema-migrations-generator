<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Schema\Generator\Migrations\Tests\Functional\Driver\MySQL;

use Cycle\Schema\Generator\Migrations\Tests\Functional\SingleFileStrategyTest as CommonTestCase;

/**
 * @group driver
 * @group driver-mysql
 */
final class SingleFileStrategyTest extends CommonTestCase
{
    public const DRIVER = "mysql";
}
