<?php

namespace Commonhelp\Util\Expression\Boolean;
use Commonhelp\Util\Expression\Visitor;
use Commonhelp\Util\Expression\BTreeExpression;
use Commonhelp\Util\Expression\BinaryExpression;

class OrExpression extends NonTerminalExpression implements BinaryExpression{
	
	public function __construct(BTreeExpression $left, BTreeExpression $right){
		$this->left = $left;
		$this->right = $right;
		$this->value = 'or';
	}
	
	public function accept(Visitor $visitor){
		return $visitor->visit($this);
	}
	
}