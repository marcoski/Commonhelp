<?php

namespace Commonhelp\Form\Builders;

use Commonhelp\Form\FormBuilder;
use Commonhelp\Form\FormElement;
use Commonhelp\Form\Types\ButtonType;
use Commonhelp\Form\Types\ResetType;
use Commonhelp\Form\Types\SubmitType;
use Commonhelp\Event\EventDispatcherInterface;

class Button extends FormBuilder{
	
	public function __construct(EventDispatcherInterface $eventDispatcher){
		parent::__construct($eventDispatcher);
		$this->element = new FormElement('button');
	}
	
}

?>