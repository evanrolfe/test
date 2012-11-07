<?php

namespace Evan;

class Model extends \Orm\Model
{
	//protected static $_computed_properties = array();

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);
	}

	/**
	 * Set
	 *
	 * Sets a property or
	 * relation of the
	 * object
	 *
	 * @access  public
	 * @param   string  $property
	 * @param   string  $value
	 * @return  Orm\Model
	 */
	public function set($property, $value)
	{
		if ($this->_frozen)
		{
			throw new FrozenObject('No changes allowed.');
		}

		if (in_array($property, static::primary_key()) and $this->{$property} !== null)
		{
			throw new \FuelException('Primary key cannot be changed.');
		}
		if (array_key_exists($property, static::properties()))
		{
			$this->_data[$property] = $value;
		}
		elseif (static::relations($property))
		{
			$this->is_fetched($property) or $this->_reset_relations[$property] = true;
			$this->_data_relations[$property] = $value;
		}
		elseif (in_array($property, static::computed_properties()))
		{
			$this->$property = $value;
		}
		else
		{
			throw new \OutOfBoundsException('Property "'.$property.'" not found for '.get_called_class().'.');
		}
		return $this;
	}

	/**
	 * Get the computed properties of this class
	 *
	 * @return  array
	 */
	public static function computed_properties()
	{
		return static::$_computed_properties;
	}
}
