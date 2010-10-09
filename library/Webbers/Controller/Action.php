<?php
class Webbers_Controller_Action extends Zend_Controller_Action {

        protected $_log;
        protected $_bootstrap;
        protected $_model;
        private   $_entity;
        protected $_messages = array();
        protected $_limit;
        private   $_filePath = '/tmp';
        
	public function init() {
		parent::init();
		$accessBroker = new Webbers_AccessBroker( $this->getRequest() );
                Zend_Registry::set( 'AccessBroker', $accessBroker );
		if ( !$accessBroker->isAllowed() ) {
                    throw new Exception( 'You are not allowed to see this stuff!');
		}
		$path = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri( $path );
		$activeNav->active = true;

                $this->_bootstrap = $this->getInvokeArg( 'bootstrap' );
                $this->_log = $this->_bootstrap->getResource( 'log' );
                $this->_messages['default'] = "Poprawnie wykonana akcja!";
                $this->_messages['noentity'] = 'Brak w bazie danych!';
                $this->view->galeryListing = $this->getGaleries();
	}

        protected function getGaleries() {
            $aGaleries = Galery::findList()
                ->where( "publishtype = 'g'" )
                ->orderby( 'id desc')
                ->limit( 4 )
                ->execute();
            $aReturn = array();
            if ( $aGaleries->count() == 0 ) {
                return array();
            }
            foreach ( $aGaleries as $galery ) {
                if ( $galery->Fotos->count() > 0 ) {
                    $g = new stdClass();
                    $g->id   = $galery->id;
                    $g->name = $galery->gname;
                    $aReturn[] = $g;
                }
            }
            return $aReturn;
        }

        protected function getList() {
            $page = (int)$this->_getParam( 'page' );
            $paginator = Webbers_Search::factory( $this->_model->findList() );
            $paginator->setCurrentPageNumber( $page );
            return $paginator;
        }

        public function create() {

            $this->view->form = $this->prepareForm( 'add' );
            
            if ( !$this->getRequest()->isPost() or !$_POST ) {
                return;
            }
            
            $Params = $this->getPostParamsToValidate();
                        
            if ( !$this->view->form->isValid( $Params ) ) {
               return;
            }

            $this->insertFile();

            $error = false;
            try {
                $Id = $this->_model->create( $_POST );
            } catch ( Exception $e ) {
                $error = true;
                $message = $e->getMessage();
            }

            if ( $error ) {
                $this->_flash( $this->getLink(), $message );
            } else {
                $this->_flash( $this->getLink(), $this->getMessage( 'add' ) );
            }
        }

        public function getFilePath() {
            return $this->_filePath;
        }

        public function setFilePath( $path ) {
            $this->_filePath = '/tmp';
            if ( !empty( $path ) ) {
                $this->_filePath = $path;
            }
        }

        public function edit() {
            $Id = (int)$this->_getParam( 'id' );
            $entity = $this->_model->getById( $Id );
            $this->setEntity( $entity );
            if ( !$Id or !$entity ) {
                $this->_flash( $this->getLink(), $this->getMessage( 'noentity' ) );
            }
            
            $this->view->form = $this->prepareForm( 'edit' );
            $this->view->form->setAction( $this->getLink() . '/edit/' . $Id );
            $this->view->form->setDefaults( (array)$entity->_data );

            $Params = $this->getPostParamsToValidate();
         
            if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $Params )) {
                return;
            }
            
            $error = false;
            try {
                $Id = $entity->create( $_POST );
            } catch ( Exception $e ) {
                $error = true;
                $message = $e->getMessage();
            }

            if ( $error ) {
                $this->_flash( $this->getLink(), $message );
            } else {
                $this->_flash( $this->getLink(), $this->getMessage( 'edit' ) );
            }
        }

        public function view() {
            $Id = (int)$this->_getParam( 'id' );
            return $this->_model->getById( $Id );
        }

        public function delete() {
            $Id = (int)$this->_getParam( 'id' );
            $entity = $this->_model->getById( $actualId );

            if ( !$Id or !$entity ) {
                $this->_flash( $this->getLink(), $this->getMessage( 'noentity' ) );
            }

            $this->view->form = $this->prepareForm( 'delete' );

            $this->view->form->setAction( $this->getLink() . '/delete/' . $Id );
            $this->view->form->setDefaults( (array)$entity->_data );

             if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST )) {
                return;
            }

            $error = false;
            try {
                //$this->view->actual->AktualsLabels->delete();
                //$this->view->actual->AktualsTags->delete();
                $entity->delete();
            } catch ( Exception $e ) {
                $error = true;
                $message = $e->getMessage();
            }

            if ( $error ) {
                $this->_flash( $this->getLink(), $message );
            } else {
                $this->_flash( $this->getLink(), $this->getMessage( 'delete' ) );
            }
        }

        protected function getPostParamsToValidate() {
            $aGroups = array_keys( $this->view->form->getDisplayGroups() );
            $aPost = array();
            if ( sizeof( $aGroups ) > 0 ) {
                foreach( $aGroups as $group ) {
                    if ( isset( $_POST[$group] ) ) {
                        $aPost = array_merge( $aPost, $_POST[$group] );
                    }
                }
            } else {
                $aPost = $_POST;
            }
            return $aPost ? $aPost : array();
        }

        protected function getBacklink() {
            $request = Zend_Controller_Front::getInstance()->getRequest();
            $backlink = $request->getServer( 'HTTP_REFERER' );
            $baseUrl = $request->getServer( 'HTTP_HOST' );
            $backlink = str_replace( 'http://','', str_replace( $baseUrl, '', $backlink ) );
            return $backlink;
        }

        protected function getLink() {
            $request = Zend_Controller_Front::getInstance()->getRequest();
            return "/{$request->getModuleName()}/{$request->getControllerName()}";
        }

        protected  function getMessage( $action ) {
            return isset( $this->_messages[$action] ) ? $this->_messages[$action] : $this->_messages['default'];
        }

        public function setEntity( $entity ) {
            $this->_entity = $entity;
        }

        public function getEntity() {
            return $this->_entity;
        }

        protected function prepareForm( $section, $factory = false, $hash = false ) {
            $formFactory = new Webbers_Form_Factory( $section );
            if ( $factory === true ) {
                return $formFactory;
            }

            $form = $formFactory->getForm();

            if ( $hash === false ) {
                $form->removeElement('hash');
            }
            
            return $form;
        }

        protected function _flash( $url, $message, $success = true ) {
            $code = $success ? 200 : 500;
            $this->_helper->flashMessenger( $message );
            $this->_helper->getHelper('Redirector')                    
                    ->gotoUrl($url);            
        }

        protected function insertFile() {
            $error = 0;
            foreach( $_FILES as $index => $value ) {
                if( $value['error'] > 0 ) {
                    $error == $value['error'];
                }
            }
            foreach( $this->view->form->getElements() as $element ) {
                if ( ( $element instanceof Zend_Form_Element_File ) and ($error == 0 ) ) {
                  $fileUploader = $this->_helper->FileUploader;
                  $fileUploader->setPath( $this->getFilePath() );
                  $aFile = $fileUploader->transferFile();
                  if ( isset( $aFile[$element->getName()]['name'] ) ) {
                      $_POST[$element->getName()] = $aFile[$element->getName()]['name'];
                  }
                  return $_POST[$element->getName()];
                }

            }
        }

        public function preDispatch() {
            $this->profiler = new Doctrine_Connection_Profiler();
            $conn = Doctrine_Manager::connection();
            $conn->setListener( $this->profiler );
        }

        public function postDispatch() {
            if ( APPLICATION_ENV != 'development' ) {
                return;
            }
            return;
            if ( $this->getRequest()->isXmlHttpRequest() ) {
                return;
            }
            echo "<div style='padding: 10px'><table class='listing' >
                    <thead>
                        <th>Event Name</th>
                        <th>Event Time</th>
                        <th>Query String</th>
                        <th>Params</th>
                    </thead><tbody>";
            $time = 0;
            foreach ( $this->profiler as $event ) {
                $time += $event->getElapsedSecs();
                $elapsed = sprintf('%f', $event->getElapsedSecs());
                echo "<tr><td>{$event->getName()}</td><td>{$elapsed}</td>";
                echo "<td>{$event->getQuery()}</td>";
                $params = $event->getParams();
                if( ! empty( $params ) ) {
                    echo "<td>";
                    print_r($params);
                    echo "</td>";
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            echo "</tbody><tfoot><tr><th colspan='8' >Total time: " . $time  . "</th></tr></tfoot></table></div>";
        }

    public static function disableLayout() {
    	// check if Zend_Layout has been instantinated
        if ( null !== ( $layout = Zend_Layout::getMvcInstance() ) ) {
        	// if so - disable it
            $layout->disableLayout();
        }
        // also disable view renderer
        Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' )->setNoRender( true );
    }

    /**
     * Method enables layout rendering
     * (enables Zend_Layout instance and turns on view renderer)
     * @return void
     */
    public static function enableLayout() {
        // check if Zend_Layout has been instantinated
        if (null !== ( $layout = Zend_Layout::getMvcInstance() ) ) {
            // if so - enable it
            $layout->enableLayout();
        }
        // also enable view renderer
        Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' )->setNoRender( false );
    }
}