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

namespace Addiks\MorePhpCsFixers\Whitespace;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;

final class BlankLineBeforeElseBlockFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
    public function __construct()
    {
        parent::__construct();

        # Fixes psalm: PropertyNotSetInConstructor
        $this->whitespacesConfig = new WhitespacesFixerConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
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
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        // should run after no_blank_lines_after_phpdoc
        return -26;
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isTokenKindFound(T_ELSEIF) || $tokens->isTokenKindFound(T_ELSE);
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {
        /** @var string $lineEnding */
        $lineEnding = $this->whitespacesConfig->getLineEnding();

        foreach ($tokens as $index => $token) {
            /** @var Token $token */

            if ($token->isGivenKind([T_ELSE, T_ELSEIF])) {
                $index = (int)$tokens->getPrevMeaningfulToken($index);

                if ($tokens[$index]->equals('}')) {
                    --$index;

                    while ($tokens[$index]->isGivenKind([T_COMMENT, T_DOC_COMMENT])) {
                        --$index;
                    }

                    /** @var Token $whitespace */
                    $whitespace = $tokens[$index];

                    /** @var int $presentNewlines */
                    $presentNewlines = substr_count($whitespace->getContent(), $lineEnding);

                    if ($whitespace->isWhitespace() && $presentNewlines < 2) {
                        $tokens[$index] = $this->convertWhitespaceToken($whitespace);
                    }
                }
            }
        }
    }

    private function convertWhitespaceToken(Token $whitespace): Token
    {
        /** @var string $lineEnding */
        $lineEnding = $this->whitespacesConfig->getLineEnding();

        return new Token([
            T_WHITESPACE,
            substr_replace(
                $whitespace->getContent(),
                $lineEnding.$lineEnding,
                strpos($whitespace->getContent(), $lineEnding),
                1
            ),
        ]);
    }
}
