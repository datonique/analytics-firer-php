<?php

namespace datonique;

use datonique\AnalyticsFirer;
/**
 * Base Class for an application module that instantiates analytics firer
 * Reference to https://github.com/silverorange/site/blob/master/Site/SiteAnalyticsModule.php
 */

 class ApplicationModuleAnalyticsFirer 
 {
    /**
	 * Reference to the application object that contains this module
	 *
	 * @var SiteApplication
	 */
    protected $app;
    
    public $firer;

	// }}}
	// {{{ public function __construct()

	public function __construct(SiteApplication $app)
	{
		$this->app = $app;
	}

	// }}}
	// {{{ public function depends()

	/**
	 * Gets the module features this module depends on
	 *
	 * By default, modules do not depend on other module features.
	 *
	 * @return array an array of {@link SiteApplicationModuleDependency}
	 *                        objects defining the features this module
	 *                        depends on.
	 */
	public function depends()
	{
		return array();
	}

	// }}}
	// {{{ public function provides()

	/**
	 * Gets the features this module provides
	 *
	 * By defualt, this is the class inheritance path up to and excluding
	 * SiteApplicationModule. This is normally all that is required but
	 * subclasses may specify additional features.
	 *
	 * @return array an array of features this module provides.
	 */
	public function provides()
	{
		static $provides = null;

		if ($provides === null) {
			$provides = array();
			$reflector = new ReflectionObject($this);
			while ($reflector->getName() != __CLASS__) {
				$provides[] = $reflector->getName();
				$reflector = $reflector->getParentClass();
			}
		}

		return $provides;
    }
    

    /**
     * 
     */
    public function init()
    {
        // TODO: exception if app doesn't exist
        $config = $this->app->getModule('SiteConfigModule');
        // TODO: exception if config doen't exist

        
        $this->firer = new AnalyticsFirer([
            'api_key' => $config->datonique->api_key,
            'base_uri' => $config->datonique->base_uri
        ]);
    }
 }