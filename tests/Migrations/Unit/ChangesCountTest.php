<?php

declare(strict_types=1);

namespace Cycle\Schema\Generator\Migrations\Tests\Unit;

use Cycle\Database\Schema\AbstractColumn;
use Cycle\Database\Schema\AbstractForeignKey;
use Cycle\Database\Schema\AbstractIndex;
use Cycle\Database\Schema\AbstractTable;
use Cycle\Database\Schema\ComparatorInterface;
use Cycle\Migrations\Atomizer\Atomizer;
use Cycle\Migrations\Atomizer\RendererInterface;
use Cycle\Schema\Generator\Migrations\ChangesCountNameGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Cycle\Schema\Generator\Migrations\ChangesCountNameGenerator
 */
final class ChangesCountTest extends TestCase
{
    /**
     * @covers ::generate
     */
    public function testGenerate(): void
    {
        $atomizer = new Atomizer(
            $this->createMock(RendererInterface::class),
        );

        $create = $this->createMock(AbstractTable::class);
        $create->method('getName')->willReturn('creates');
        $create->method('getStatus')->willReturn(AbstractTable::STATUS_NEW);

        $drops = $this->createMock(AbstractTable::class);
        $drops->method('getName')->willReturn('drops');
        $drops->method('getStatus')->willReturn(AbstractTable::STATUS_DECLARED_DROPPED);

        $renamesCmp = $this->createMock(ComparatorInterface::class);
        $renamesCmp->method('isRenamed')->willReturn(true);
        $renames = $this->createMock(AbstractTable::class);
        $renames->method('getName')->willReturn('renames');
        $renames->method('getStatus')->willReturn(AbstractTable::STATUS_EXISTS);
        $renames->method('getComparator')->willReturn($renamesCmp);
        $renames->method('getInitialName')->willReturn('old_name');

        // Comparator
        $changeCmp = $this->createMock(ComparatorInterface::class);
        $changeCmp->method('isRenamed')->willReturn(false);
        //// Column
        $columnAdd = $this->createMock(AbstractColumn::class);
        $columnAdd->method('getName')->willReturn('c1');
        $columnDrop = $this->createMock(AbstractColumn::class);
        $columnDrop->method('getName')->willReturn('c2');
        $columnAlter = $this->createMock(AbstractColumn::class);
        $columnAlter->method('getName')->willReturn('c3');
        $changeCmp->method('addedColumns')->willReturn([$columnAdd]);
        $changeCmp->method('droppedColumns')->willReturn([$columnDrop]);
        $changeCmp->method('alteredColumns')
            ->willReturn([
                [$columnAlter, $this->createMock(AbstractColumn::class)],
            ]);
        //// Index
        $indexAdd = $this->createMock(AbstractIndex::class);
        $indexAdd->method('getName')->willReturn('i1');
        $indexDrop = $this->createMock(AbstractIndex::class);
        $indexDrop->method('getName')->willReturn('i2');
        $indexAlter = $this->createMock(AbstractIndex::class);
        $indexAlter->method('getName')->willReturn('i3');
        $changeCmp->method('addedIndexes')->willReturn([$indexAdd]);
        $changeCmp->method('droppedIndexes')->willReturn([$indexDrop]);
        $changeCmp->method('alteredIndexes')
            ->willReturn([
                [$indexAlter, $this->createMock(AbstractIndex::class)],
            ]);
        //// FK
        $fkAdd = $this->createMock(AbstractForeignKey::class);
        $fkAdd->method('getName')->willReturn('fk1');
        $fkDrop = $this->createMock(AbstractForeignKey::class);
        $fkDrop->method('getName')->willReturn('fk2');
        $fkAlter = $this->createMock(AbstractForeignKey::class);
        $fkAlter->method('getName')->willReturn('fk3');
        $changeCmp->method('addedForeignKeys')->willReturn([$fkAdd]);
        $changeCmp->method('droppedForeignKeys')->willReturn([$fkDrop]);
        $changeCmp->method('alteredForeignKeys')
            ->willReturn([
                [$fkAlter, $this->createMock(AbstractForeignKey::class)],
            ]);

        // Table
        $change = $this->createMock(AbstractTable::class);
        $change->method('getStatus')->willReturn(AbstractTable::STATUS_EXISTS);
        $renames->method('getName')->willReturn('changes');
        $change->method('getComparator')->willReturn($changeCmp);

        $atomizer
            ->addTable($create)
            ->addTable($drops)
            ->addTable($renames)
            ->addTable($change);
        $generator = new ChangesCountNameGenerator();
        self::assertSame(
            'ct1_dt1_t2_c3_i3_fk3',
            $generator->generate($atomizer),
        );
    }
}
