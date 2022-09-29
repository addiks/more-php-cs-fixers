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
use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeCatchBlockFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\AbstractFixer;

/**
 * @internal
 */
final class BlankLineBeforeCatchBlockFixerTest extends AbstractFixerTestCase
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
try {
    foo();

} catch (\Exception $b) {
    bar();

} finally {
    baz();
}',
            ],
            [
                '<?php
try {
    foo();

} catch (\Exception $b) {
    bar();

} finally {
    baz();
}',
                '<?php
try {
    foo();
} catch (\Exception $b) {
    bar();
} finally {
    baz();
}',
            ],
            [
                '<?php
    try {
        foo();

    } catch (\Exception $b) {
        bar();

    } finally {
        baz();
    }',
                '<?php
    try {
        foo();
    } catch (\Exception $b) {
        bar();
    } finally {
        baz();
    }',
            ],
            [
                '<?php
try {
    foo();

/* Lorem ipsum */} catch (\Exception $b) {
    bar();

} finally {
    baz();
}',
                '<?php
try {
    foo();
/* Lorem ipsum */} catch (\Exception $b) {
    bar();
} finally {
    baz();
}',
            ],
            [
                '<?php try {foo();} catch (\Exception $b) {bar();} finally {baz();}',
            ],
        ];
    }

    /**
     * @test
     */
    public function shouldHaveTheRightPriority()
    {
        $this->assertSame(-26, $this->createFixer()->getPriority());
    }

    /**
     * @test
     */
    public function shouldHaveAFixerDefinition()
    {
        /** @var FixerDefinitionInterface $definition */
        $definition = $this->createFixer()->getDefinition();
        
        $this->assertSame(
            'An empty line feed must precede any catch or finally codeblock.',
            $definition->getSummary()
        );
        
        $this->assertSame(<<<CODE
            <?php
            try {
                foo();
            } catch (\Exception \$b) {
                bar();
            } finally {
                baz();
            }
            CODE . "\n",
            $definition->getCodeSamples()[0]->getCode()
        );
    }

    protected function createFixer(): AbstractFixer
    {
        return new BlankLineBeforeCatchBlockFixer();
    }
}
