<?php

/**
 * Author: Matt De'Ath
 * Date: 19/10/12
 * Package: View
 * Description: Generic view class for motokit
 */

class View {

	protected $_view_model = NULL;
	protected $_template_name = NULL;
	protected $_template_loc = NULL;
	protected $_data = NULL;

	public function __construct($data = NULL)
	{
		$this->_data = $data;
	}

	public static function factory($template, $data = NULL)
	{
		$view = new View($template, $data);
		$model_class = "View_" . $template;
		$view->_view_model = new $model_class($data);
		$view->_template_name = $template;
		$view->_find_template();
		return $view;
	}

	public function template($name)
	{
		$this->_template_name = $name;
	}

	private function _find_template()
	{
		$loc = find::search('template', $this->_template_name);

		if ($loc != FALSE)
		{
			return $this->_template_loc = $loc;
		}
		
		throw new Exception('Cannot find template: ' . $this->_template_name . '.php');
	}

        public function __call($method, $args)
        {
                return $this->_data->$method($args);
        }

	public function __get($property)
	{
		return $this->_data->$property;
	}




	public function __tostring()
	{
		$data = $this->_view_model;
		ob_start();
		require $this->_template_loc;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

?>
