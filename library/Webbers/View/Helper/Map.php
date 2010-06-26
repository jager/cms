<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Map
 *
 * @author mjagusia
 */
class Webbers_View_Helper_Map extends Zend_View_Helper_Abstract {

    public $view;

    protected $_address;
    protected $_lat;
    protected $_lon;

    public function Map( array $mapData ) {        

        if ( isset( $mapData['address'] ) ) {
            $this->_address = $mapData['address'];
            return $this->setByAddress();
        }
    }

    protected  function setByAddress() {
        $script = '';
        $script .= '
                        var map = null;
                        var geocoder = null;
                        function initialize() {
                          if (GBrowserIsCompatible()) {
                            map = new GMap2(document.getElementById("maps_canvas"));
                            map.setCenter(new GLatLng(37.4419, -122.1419), 13);
                            geocoder = new GClientGeocoder();
                          }
                        }

                        function showAddress(address) {
                          if (geocoder) {
                            geocoder.getLatLng(
                              address,
                              function(point) {
                                if (!point) {
                                  alert(address + " not found");
                                } else {
                                  map.setCenter(point, 14);
                                  var marker = new GMarker(point);
                                  map.addOverlay(marker);
                                  marker.openInfoWindowHtml(address);
                                }
                              }
                            );
                          }
                        };
                        initialize();
                        showAddress("' . $this->_address . '");
                      ';
       // Zend_Debug::dump( $script );die();
        return $this->view->inlineScript( Zend_View_Helper_HeadScript::SCRIPT, $script, 'prepend' );
    }

    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
}
?>
