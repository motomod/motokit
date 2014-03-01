<?

/*
 * Class to iterate through available
 *
 */

class Moto_Find {

	private $_search_directories = array(
		/*"Modules",*/ "", "core"
	);

	private $_sub_directories = array(
		"class" => "classes",
		"template" => "template"
	);

	static $instance;

	public static function instance()
	{
		if (self::$instance == false)
		{
			return self::$instance = new self;
		}
		else
		{
			return self::$instance;
		}
	}

	/* Set your modules, expects array('name' => 'folder') */
	public function set_modules($modules)
	{
		if (!empty($modules))
		{
			// Set new search paths with first directory still being main classes folder
			$search_paths = array(current($this->_search_directories));

			foreach($modules as $module)
			{
				$search_paths[] = 'modules/' . $module;
			}

			$search_paths[] = end($this->_search_directories);

			$this->_search_directories = $search_paths;
		}

		return $this;
	}

	public function search($type, $name)
	{
		$find = new self;

		/* Get use remaining class bits to calculate direcoties */
		$directories = explode('_', $name);

		/* Take last array row as the filename */
		$filename = array_pop($directories);

		/* Check all directories */
		foreach($find->_search_directories as $dir)
		{
			$path = '../' . $dir . '/'. $this->_sub_directories[$type] .'/' . implode("/", $directories) . '/' . $filename . '.php';

			if (file_exists($path))
			{
				return $path;
			}
		}

		/* No files found at this point, return */
		return FALSE;
	}

	//private function

}
