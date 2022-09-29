<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Addiks\MorePhpCsFixers\Tests\Unit\Whitespace;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeDocCommentFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\AbstractFixer;

/**
 * @internal
 */
final class BlankLineBeforeDocCommentFixerTest extends AbstractFixerTestCase
{
    /**
     * @param string      $expected
     * @param null|string $input
     *
     * @dataProvider provideFixCases
     */
    public function testFix($expected, $input = null)
    {
        $this->doTest($expected, $input);
    }

    public function provideFixCases()
    {
        return [
            [
                '<?php
/** @var string $foo */
$foo = "Lorem ipsum";

/** @var string $bar */
$bar = "dolor sit";

/** @var string $baz */
$baz = "amet";
',
            ],
            [
                '<?php
/** @var string $foo */
$foo = "Lorem ipsum";

/** @var string $bar */
$bar = "dolor sit";

/** @var string $baz */
$baz = "amet";
',
                '<?php
/** @var string $foo */
$foo = "Lorem ipsum";
/** @var string $bar */
$bar = "dolor sit";
/** @var string $baz */
$baz = "amet";
',
            ],
            [
                '<?php
    /** @var string $foo */
    $foo = "Lorem ipsum";

    /** @var string $bar */
    $bar = "dolor sit";

    /** @var string $baz */
    $baz = "amet";
    ',
                '<?php
    /** @var string $foo */
    $foo = "Lorem ipsum";
    /** @var string $bar */
    $bar = "dolor sit";
    /** @var string $baz */
    $baz = "amet";
    ',
            ],
            [
                '<?php
function foo() {
    /** @var string $foo */
    $foo = "Lorem ipsum";

    /** @var string $bar */
    $bar = "dolor sit";
}
',
                '<?php
function foo() {
    /** @var string $foo */
    $foo = "Lorem ipsum";
    /** @var string $bar */
    $bar = "dolor sit";
}
',
            ],
        ];
    }

    /**
     * @test
     */
    public function shouldHaveAFixerDefinition()
    {
        /** @var FixerDefinitionInterface $definition */
        $definition = $this->createFixer()->getDefinition();
        
        $this->assertSame(
            'An empty line feed must precede any doc-comment.',
            $definition->getSummary()
        );
        
        $this->assertSame(<<<CODE
            <?php
            /** @var string \$foo */
            \$foo = "Lorem ipsum";
            /** @var string \$bar */
            \$bar = "dolor sit amet";
            CODE . "\n",
            $definition->getCodeSamples()[0]->getCode()
        );
    }

    /**
     * @test
     */
    public function shouldHaveTheRightPriority()
    {
        $this->assertSame(-26, $this->createFixer()->getPriority());
    }

    protected function createFixer(): AbstractFixer
    {
        return new BlankLineBeforeDocCommentFixer();
    }
}
