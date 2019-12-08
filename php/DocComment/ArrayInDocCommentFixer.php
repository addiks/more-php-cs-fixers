<?php
/**
 * Copyright (C) 2019 Gerrit Addiks.
 * This package (including this file) was released under the terms of the GPL-3.0.
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/> or send me a mail so i can send you a copy.
 *
 * @license GPL-3.0
 *
 * @author Gerrit Addiks <gerrit@addiks.de>
 */

namespace Addiks\MorePhpCsFixers\DocComment;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\Token;

final class ArrayInDocCommentFixer extends AbstractFixer
{

    public function getName()
    {
        return 'Addiks/array_in_doccomment';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new FixerDefinition(
            'Normalizes array-notations in doccomments.',
            [
                new CodeSample(
                    '<?php

/** @var array<string> $foo */
'
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    public function getPriority()
    {
        return -10;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {

        /** @var string $pattern */
        $pattern = "/(\@var )([a-zA-Z0-9_\\\\]+)(\[\])/is";

        $pattern = str_replace('*', '\\*', $pattern);
        $pattern = str_replace(' ', '\s+', $pattern);

        foreach ($tokens as $index => $token) {
            /** @var Token $token */

            if ($token->isGivenKind([T_DOC_COMMENT])) {
                /** @var string $content */
                $content = $token->getContent();

                $content = preg_replace_callback($pattern, function(array $matches) {
                    array_shift($matches);
                    $matches[1] = "array<" . $matches[1] . ">";
                    $matches[2] = "";
                    return implode('', $matches);
                }, $content);

                $tokens[$index] = new Token([T_DOC_COMMENT, $content]);
            }
        }
    }

}
