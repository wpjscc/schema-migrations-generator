<?php

declare(strict_types=1);

namespace Cycle\Schema\Generator\Migrations\Changes;

/**
 * @internal
 */
enum ChangeType
{
    case CreateTable;
    case DropTable;
    case RenameTable;
    case ChangeTable;
    case AddColumn;
    case RemoveColumn;
    case AlterColumn;
    case AddIndex;
    case RemoveIndex;
    case AlterIndex;
    case AddFk;
    case RemoveFk;
    case AlterFk;
}
