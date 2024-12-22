<?php

declare(strict_types=1);

namespace Cycle\Schema\Generator\Migrations;

use Cycle\Migrations\Atomizer\Atomizer;
use Cycle\Schema\Generator\Migrations\Changes\ChangeType;
use Cycle\Schema\Generator\Migrations\Changes\Collector;

/**
 * @psalm-import-type TChange from Collector
 */
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
            ChangeType::CreateTable => 'ct',
            ChangeType::DropTable => 'dt',
            ChangeType::RenameTable => 'rt',
            ChangeType::ChangeTable => 'c',
            ChangeType::AddColumn => 'ac',
            ChangeType::RemoveColumn => 'rc',
            ChangeType::AlterColumn => 'alc',
            ChangeType::AddIndex => 'ai',
            ChangeType::RemoveIndex => 'ri',
            ChangeType::AlterIndex => 'ali',
            ChangeType::AddFk => 'afk',
            ChangeType::RemoveFk => 'ffk',
            ChangeType::AlterFk => 'alfk',
        };
    }
}
