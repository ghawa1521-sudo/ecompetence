<?php

namespace Ediligence\EdiligenceBundle\DoctrineExtensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
	Doctrine\ORM\Query\Lexer;

/**
 * @author Giulia Santoiemma <giuliaries@gmail.com>
 */
class Right extends FunctionNode
{
	public $column = null;
    public $regexp = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->column = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->regexp = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf('RIGHT(%s, %s)', $this->column->dispatch($sqlWalker), $this->regexp->dispatch($sqlWalker));
    }
}
