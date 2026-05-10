<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated
		// by the bootstrap file to local class variables
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();

		log_message('info', 'Controller Class Initialized');
	}

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

	/**
	 * Load partial views
	 */
	public function loadPartials($view = '', $data = array())
	{
		$this->load->view('_partials/header');
		$this->load->view($view, $data);
		$this->load->view('_partials/footer');
	}
}