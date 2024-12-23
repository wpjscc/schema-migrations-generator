<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Schema\Generator\Migrations\Tests\Functional\Driver\Postgres;

use Cycle\Schema\Generator\Migrations\Tests\Functional\SingleFileStrategyTest as CommonTestCase;

/**
 * @group driver
 * @group driver-postgres
 */
final class SingleFileStrategyTest extends CommonTestCase
{
    public const DRIVER = "postgres";
}
