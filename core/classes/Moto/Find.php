<?

/*
 * Class to iterate through available
 *
 */

class Moto_Find {

	private $_search_directories = array(
		"", "core"
	);

	private $_sub_directories = array(
		"class" => "classes",
		"template" => "template"
	);

	static $instance;

	/* Create as singleton */
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
			/* Set new search paths with first directory still being main classes folder */
			$search_paths[0] = array_shift($this->_search_directories);

			/* Iterate through modules and add them to our search directories */
			foreach($modules as $module)
			{
				$search_paths[] = 'modules/' . $module;
			}

			/* Add the rest of the folders to the array */
			$search_paths = array_merge($search_paths, $this->_search_directories);

			/* Overwrite default folders with all folders */
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
