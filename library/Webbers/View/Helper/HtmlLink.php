<?php
class Webbers_View_Helper_HtmlLink extends Zend_View_Helper_HtmlElement {
    /**
     * URL of current action
     *
     * @var string
     */
    protected static $currentUrl  = null;
    /**
     * Instance of router
     *
     * @var Zend_Controller_Request_Abstract
     */
    protected static $request     = null;
    /**
     * Markup for active link
     */
    protected static $activeTag   = '<a %1$s>%2$s</a>';
    /**
     * Markup for inactive link
     */
    protected static $inactiveTag = '<strong %1$s>%2$s</strong>';
    /**
     * Markup for denied link
     */
    protected static $deniedTag   = '<em %1$s>%2$s</em>';
    /**
     * Name of class that is added to all "current" links (on both 1 and 2 level)
     *
     * @var string
     */
    protected $currentItemClass   = 'currentLink';
    /**
     * Name of class that is added to all links user is denied
     *
     * @var string
     */
    protected $deniedItemClass    = 'deniedLink';
	/**
	 * Method generates link tag for given params
	 *
	 * @param string $url
	 * @param string $label
	 * @param string $title
	 * @param array  $attribs
	 * @param bool   $reset
	 * @param bool   $encode
	 * @return string
	 * @throws Zend_View_Exception
	 */
	public function htmlLink( $url, $label, $title, array $attribs = array(), $reset = true, $encode = false ) {
        // check if given URL is string
        if ( !is_string( $url ) ) {
        	// if not- instantinate stdClass object
            $data = new stdClass();
            // cast given url values into strings and set whole array as params
            $data->params = array_map( 'strval', $url );
            // set routeName to "null"
            $data->routeName = null;
        // otherwise
        } else {
            // parse string into URL params and route name
            $data  = Webbers_Link::parseInput( $url );
        }
        if ( !isset( $data->params['module'] ) ) {
            $data->params['module'] = $this->getCurrentUrl()->module;
        }
        if ( !isset( $data->params['controller'] ) ) {
            $data->params['controller'] = $this->getCurrentUrl()->controller;
        }
        if ( !isset( $data->params['action'] ) ) {
            $data->params['action'] = $this->getCurrentUrl()->action;
        }
		// prepare URL
		$url       = $this->view->url( $data->params, $data->routeName, $reset, $encode );
        // check if encoding has been requested
        if ( $encode ) {
            // if yes- escape label
            $label     = $this->view->escape( $label );
        }
		// check level of similarity with current URL
		$current   = self::isCurrent( $url, $data->params );
		// check if current user is allowed to perform given action
		$allowed   = Webbers_Controller_Plugin_Auth::isAllowed( $data->params['module'],
		                                                    $data->params['controller'],
		                                                    $data->params['action'] );
		// check if given URL is similar to current url
		if ( $current || !$allowed ) {
            // check if 'class' attribute has been given
			if ( !isset( $attribs['class'] ) ) {
                // if not- create it
				$attribs['class'] = '';
			}
			if ( $current ) {
                // append "current" class
                $attribs['class'] .= ' ' . $this->currentItemClass;
            }
            if ( !$allowed ) {
                // append "denied" class
                $attribs['class'] .= ' ' . $this->deniedItemClass;
            }
		}
		// check if given link is current one
		if ( $current === 2 ) {
            // if yes - generate and return inactive link
            return sprintf( self::$inactiveTag, $this->_htmlAttribs( $attribs ), $label );
		}
        // check if current user is not permitted to given link
        if ( !$allowed ) {
            // Ticket #186
            return '';
            // if yes - generate and return inactive link
            return sprintf( self::$deniedTag, $this->_htmlAttribs( $attribs ), $label );
        }
        // append title to attributes array
        $attribs['title'] = $title;
        // prepare URL and append result to attribs array
        $attribs['href']  = $url;
        // generate active link
        $output= sprintf( self::$activeTag,
                          $this->_htmlAttribs( $attribs ),
                          $label );
        // return generated markup
		return $output;
	}
	protected function getCurrentUrl() {
        // check if current URL has been discovered
        if ( null !== self::$currentUrl ) {
            return self::$currentUrl;
        }
        // generate current URL string from received params
        $request                      = Zend_Controller_Front::getInstance()->getRequest();
        self::$currentUrl             = new stdClass();
        self::$currentUrl->module     = $request->getModuleName();
        self::$currentUrl->controller = $request->getControllerName();
        self::$currentUrl->action     = $request->getActionName();
        self::$currentUrl->url        = $this->view->url( Zend_Controller_Front::getInstance()->getRouter()->getParams() );
        return self::$currentUrl;
	}
	/**
	 * Method checks if given URL is similar as current URL
	 * Returns:
	 * 2 - for same URLs
	 * 1 - for similar URLs (same module)
	 * 0 - for different url
	 * @param string $url
	 * @return integer
	 */
    public function isCurrent( $url, $urlParams ) {
        $currentUrl = $this->getCurrentUrl();
	    // check if module is the same
	    if ( $currentUrl->module != array_shift( $urlParams ) ) {
            // if yes- return "0" (different)
	    	return 0;
	    }
        // check if controller is the same
        if ( $currentUrl->controller != array_shift( $urlParams ) ) {
            // if yes- return "0" (different)
            return 0;
        }
        // check if controller is the same as action
        if ( $currentUrl->action != array_shift( $urlParams ) ) {
            // if yes - return "1" (similar to)
            return 1;
        }
        // check if current URL is same as given one
        if ( $currentUrl->url == $url ) {
            // if yes - return "2" (same as)
            return 2;
        }
        return 1;
    }
}

?>