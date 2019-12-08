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

namespace Addiks\MorePhpCsFixers\Tests\Unit\DocComment;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\CodeSample;
use Addiks\MorePhpCsFixers\DocComment\CorrectOrderInVarDocCommentFixer;

/**
 * @internal
 */
final class CorrectOrderInVarDocCommentFixerTest extends AbstractFixerTestCase
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
/** @var int $foo */
/** @var Foo $foo */
/** @var Foo\Bar $foo */
/** @var \Foo $foo */
/**
 * @var Foo $foo
 */
',
            ],
            [
                '<?php
/** @var string $foo */
/** @var int $foo */
/** @var Foo $foo */
/** @var Foo\Bar $foo */
/** @var \Foo $foo */
/**
 * @var Foo $foo
 */
',
                '<?php
/** @var $foo string */
/** @var $foo int */
/** @var $foo Foo */
/** @var $foo Foo\Bar */
/** @var $foo \Foo */
/**
 * @var $foo Foo
 */
',
            ],
            [
                '<?php
    /** @var string $foo */
    /** @var int $foo */
    /** @var Foo $foo */
    /** @var Foo\Bar $foo */
    /** @var \Foo $foo */
    /**
     * @var Foo $foo
     */
',
                '<?php
    /** @var $foo string */
    /** @var $foo int */
    /** @var $foo Foo */
    /** @var $foo Foo\Bar */
    /** @var $foo \Foo */
    /**
     * @var $foo Foo
     */
',
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
                'Corrects the order of variable and typedeclaration in a @var doccomment.',
                [
                    new CodeSample(
                        '<?php

/** @var string $foo */
'
                    ),
                ]
            ),
            $this->createFixer()->getDefinition()
        );
    }

    protected function createFixer()
    {
        return new CorrectOrderInVarDocCommentFixer();
    }

}
