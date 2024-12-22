<?php

declare(strict_types=1);

namespace Cycle\Schema\Generator\Migrations;

use Cycle\Migrations\Atomizer\Atomizer;
use Cycle\Schema\Generator\Migrations\Changes\ChangeType;
use Cycle\Schema\Generator\Migrations\Changes\Collector;

final class ChangesCountGenerator implements NameGeneratorInterface
{
    public function generate(Atomizer $atomizer): string
    {
        $collector = new Collector();
        $map = [];
        foreach ($collector->collect($atomizer) as $pair) {
            $key = $this->changeToString($pair[0]);
            $map[$key] ??= 0;
            $map[$key]++;
        }

        $result = [];
        foreach ($map as $key => $cnt) {
            $result[] = "{$key}{$cnt}";
        }

        return \implode('_', $result);
    }

    private function changeToString(ChangeType $change): string
    {
        return match ($change) {
            ChangeType::CreateTable => 'tc',
            ChangeType::DropTable => 'td',
            ChangeType::RenameTable => 'tr',
            ChangeType::ChangeTable => 'tc',
            ChangeType::AddColumn => 'ca',
            ChangeType::DropColumn => 'cd',
            ChangeType::AlterColumn => 'cl',
            ChangeType::AddIndex => 'ia',
            ChangeType::DropIndex => 'id',
            ChangeType::AlterIndex => 'il',
            ChangeType::AddFk => 'fa',
            ChangeType::DropFk => 'fd',
            ChangeType::AlterFk => 'fl',
        };
    }
}
