<?php
namespace Commonhelp\App\Http\Session\Attribute;

class NamespacedAttributeBag extends AttributeBag{
	
	private $namespaceCharacter;
	
	public function __construct($storageKey = '_ch_attributes', $namespaceCharacter = '/'){
		$this->namespaceCharacter = $namespaceCharacter;
		parent::__construct($storageKey);
	}
	
	public function has($name){
		$attributes = $this->resolveAttributePath($name);
		$name = $this->resolveKey($name);
		
		if(null === $attributes){
			return false;
		}
		
		return array_key_exists($name, $attributes);
	}
	
	public function get($name, $default = null){
		$attributes = $this->resolveAttributePath($name);
		$name = $this->remove($name);
		if(null === $attributes){
			return $default;
		}
		
		return array_key_exists($name, $attributes) ? $attributes[$name] : $default;
	}
	
	public function set($name, $value){
		$attributes = &$this->resolveAttributePath($name, true);
		$name = $this->resolveKey($name);
		$attributes[$name] = $value;
	}
	
	public function remove($name){
		$retval = null;
		$attributes = &$this->resolveAttributePath($name);
		if(null !== $attributes && array_key_exists($name, $attributes)){
			$retval = $attributes[$name];
			unset($attributes[$name]);
		}
		
		return $retval;
	}
	
	protected function &resolveAttributePath($name, $writeContext = false){
		$array = &$this->attributes;
		$name = (strpos($name, $this->namespaceCharacter) === 0) ? substr($name, 1) : $name;
		
		if(!$name){
			return $array;
		}
		
		$parts = explode($this->namespaceCharacter, $name);
		if(count($parts) < 2){
			if(!$writeContext){
				return $array;
			}
			
			$array[$parts[0]] = array();
			
			return $array;
		}
		
		unset($parts[count($parts) - 1]);
		
		foreach($parts as $part){
			if(null !== $array && !array_key_exists($part, $array)){
				$array[$part] = $writeContext ? array() : null;
			}
			
			$array = &$array[$part];
		}
		
		return $array;
	}
	
	protected function resolveKey($name){
		if(false !== $pos = strpos($name, $this->namespaceCharacter)){
			$name = substr($name, $pos + 1);
		}
		
		return $name;
	}
	
}