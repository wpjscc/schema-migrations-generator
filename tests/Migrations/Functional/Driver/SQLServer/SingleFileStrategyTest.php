<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Schema\Generator\Migrations\Tests\Functional\Driver\SQLServer;

use Cycle\Schema\Generator\Migrations\Tests\Functional\SingleFileStrategyTest as CommonTestCase;

/**
 * @group driver
 * @group driver-sqlserver
 */
final class SingleFileStrategyTest extends CommonTestCase
{
    public const DRIVER = "sqlserver";
}
