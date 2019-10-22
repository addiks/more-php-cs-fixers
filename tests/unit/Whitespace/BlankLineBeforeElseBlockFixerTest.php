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
        $this->assertEquals(
            new FixerDefinition(
                'An empty line feed must precede any else or elseif codeblock.',
                [
                    new CodeSample(
                        '<?php
if ($a) {
    foo();

} elseif ($b) {
    bar();

} else {
    baz();
}
'
                    ),
                ]
            ),
            $this->createFixer()->getDefinition()
        );
    }

    /**
     * @test
     */
    public function shouldHaveTheRightPriority()
    {
        $this->assertEquals(-26, $this->createFixer()->getPriority());
    }

    protected function createFixer()
    {
        return new BlankLineBeforeElseBlockFixer();
    }

}
