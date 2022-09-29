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
use Addiks\MorePhpCsFixers\DocComment\NullableInDocCommentFixer;
use PhpCsFixer\AbstractFixer;

/**
 * @internal
 */
final class NullableInDocCommentFixerTest extends AbstractFixerTestCase
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
/** @var string|null $foo */
/** @var int|null $foo */
/** @var Foo|null $foo */
/** @var Foo\Bar|null $foo */
/** @var \Foo|null $foo */
/**
 * @var Foo|null $foo
 */
',
            ],
            [
                '<?php
/** @var string|null $foo */
/** @var int|null $foo */
/** @var Foo|null $foo */
/** @var Foo\Bar|null $foo */
/** @var \Foo|null $foo */
/**
 * @var Foo|null $foo
 */
',
                '<?php
/** @var ?string $foo */
/** @var ?int $foo */
/** @var ?Foo $foo */
/** @var ?Foo\Bar $foo */
/** @var ?\Foo $foo */
/**
 * @var ?Foo $foo
 */
',
            ],
            [
                '<?php
    /** @var string|null $foo */
    /** @var int|null $foo */
    /** @var Foo|null $foo */
    /** @var Foo\Bar|null $foo */
    /** @var \Foo|null $foo */
    /**
     * @var Foo|null $foo
     */
',
                '<?php
    /** @var ?string $foo */
    /** @var ?int $foo */
    /** @var ?Foo $foo */
    /** @var ?Foo\Bar $foo */
    /** @var ?\Foo $foo */
    /**
     * @var ?Foo $foo
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
        /** @var FixerDefinitionInterface $definition */
        $definition = $this->createFixer()->getDefinition();
        
        $this->assertSame(
            'Normalizes nullable-notations in doccomments.',
            $definition->getSummary()
        );
        
        $this->assertSame(<<<CODE
            <?php

            /** @var ?string \$foo */
            CODE . "\n",
            $definition->getCodeSamples()[0]->getCode()
        );
    }

    /**
     * @test
     */
    public function shouldHaveTheRightPriority()
    {
        $this->assertSame(-10, $this->createFixer()->getPriority());
    }

    protected function createFixer(): AbstractFixer
    {
        return new NullableInDocCommentFixer();
    }
}
