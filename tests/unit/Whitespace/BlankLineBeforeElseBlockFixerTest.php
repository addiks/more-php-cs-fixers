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
use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeElseBlockFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;

/**
 * @internal
 */
final class BlankLineBeforeElseBlockFixerTest extends AbstractFixerTestCase
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
if ($a) {
    foo();

} elseif ($b) {
    bar();

} else {
    baz();
}',
            ],
            [
                '<?php
if ($a) {
    foo();

} elseif ($b) {
    bar();

} else {
    baz();
}',
                '<?php
if ($a) {
    foo();
} elseif ($b) {
    bar();
} else {
    baz();
}',
            ],
            [
                '<?php
    if ($a) {
        foo();

    } elseif ($b) {
        bar();

    } else {
        baz();
    }',
                '<?php
    if ($a) {
        foo();
    } elseif ($b) {
        bar();
    } else {
        baz();
    }',
            ],
            [
                '<?php
if ($a) {
    foo();

/* Lorem ipsum */} elseif ($b) {
    bar();

} else {
    baz();
}',
                '<?php
if ($a) {
    foo();
/* Lorem ipsum */} elseif ($b) {
    bar();
} else {
    baz();
}',
            ],
            [
                '<?php if ($a) {foo();} elseif ($b) {bar();} else {baz();}',
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
            'An empty line feed must precede any else or elseif codeblock.',
            $definition->getSummary()
        );
        
        $this->assertSame(<<<CODE
            <?php
            if (\$a) {
                foo();
            } elseif (\$b) {
                bar();
            } else {
                baz();
            }
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
        return new BlankLineBeforeElseBlockFixer();
    }
}
