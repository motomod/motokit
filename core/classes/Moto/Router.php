<?php

/**
 * Author: Matt De'Ath
 * Date: 22/09/12
 * Package: motoroute
 * Description: Router for motokit
 *
 * $routes is an array of regex routes in order of priority.
 */

class Moto_Router
{
	/* Regex used to find variables */
	protected $var_regex = "#\(.*?\)#";

	/* Regex to replace variables with */
	protected $var_replace = "(.*?)";

	protected $values = array();

	public static function direct($routes)
	{
		$mr = new self;
		/* Iterate through the routes we have */
		foreach($routes as $route => $destination)
		{
			/* Strip route of uri and replace with regex */
			$rt_regex = $mr->route_regex($route);
			/* If the regex tests as true direct to the correct class */
			if ($mr->test($rt_regex) == TRUE)
			{
				$dparts = explode(":", $destination);
				$class = $dparts[0];
				$method = $dparts[1];
				$c = new $class;
				$c->uri = $mr->route_vars($route);
				$c->$method();
				return;
			}
		}
		
		throw new Route_Exception('Route unmatched');
	}

	/* Check URI against regex */
	private function test($route)
	{
		/* Add trailing slash if needed */
		$uri = $_SERVER['REQUEST_URI'] . (substr($_SERVER['REQUEST_URI'], -1) != "/" ? "/" : "");

		return (bool) preg_match("#^" . $route . "$#", $uri, $this->values);
	}

	/* Replace vars with regex */
	private function route_regex($route)
	{
		$rr = preg_replace($this->var_regex, $this->var_replace, $route);
		return $rr . (substr($rr, -1) != "/" ? "/" : "");
	}

	/* Return array of URI names and values */
	public function route_vars($route)
	{
		preg_match_all($this->var_regex, $route, $key);
		unset($this->values[0]);
		$this->values = array_values($this->values);

		if (count($key[0]) > 0)
		{
			foreach ($key[0] as $k => $v)
			{
				$uri[str_replace(array('(', ')'), '', $v)] = $this->values[$k];
			}

			return $uri;
		}

		return array();
	}

}

?>
