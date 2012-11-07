<?php

class Model_Formfieldbuyer extends Evan\Model
{
	protected static $_computed_properties = array(
		'are_options_linked',
		'linked_formfield',
	);

	protected static $_table_name = 'formfields_buyer';

	protected static $_properties = array(
		'id',
		'label',
		'tag',
		'type',
		'search_field',
		'order',
		'description',
		'options',
		'belongs_to',
		'validation',
		'public',
	);

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);

		if($new == false)
		{
			$this->are_options_linked = preg_match('/ID:[0-9]+/i',$this->options);

			if($this->type == 'dropdown' and $this->are_options_linked)
			{
				$options_arr = explode(":",$this->options);
				$id = $options_arr[1];

				$other_formfield = Model_Formfieldbuyer::find($id);
				//Set the options property, the options will have already been json_decoded since we are calling the options property and a formfield_model that is not linked
				$this->options = $other_formfield->options;	

				//Set the linked option
				$this->linked_formfield = $other_formfield;			
			}else{
				$this->options = json_decode($this->options, true);
			}		
		}else{
			$this->are_options_linked = false;

			//Leave the options property as it is		
		}
	}

	public function sconstruct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);


		if($new == false)
		{
			$this->are_options_linked = preg_match('/ID:[0-9]+/i',$this->options);

			//If this is a dropdown and the options are linked to come from another another drop down
			if($this->type == 'dropdown' and $this->are_options_linked)
			{
				$options_arr = explode(":",$this->options);
				$this->linked_formfield = Model_Formfieldbuyer::find($options_arr[1]);
				$options = '["asdf","jkl;","zxcv"]';//$this->linked_formfield->options;
			}else{
				$options = $this->options;
			}

			$fields = json_decode($options, true);
			$this->options = ($fields) ? $fields : array();
			echo $this->options;
		}
	}
}
