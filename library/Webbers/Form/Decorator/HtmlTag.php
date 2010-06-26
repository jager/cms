<?php
class Webbers_Form_Decorator_HtmlTag extends Zend_Form_Decorator_HtmlTag {
	/**
     * Render content wrapped in an HTML tag
     *
     * @param  string $content
     * @return string
     */
    public function render( $content ) {
    	$classes = array( 'captcha'     => 'for="captcha"',
                          'text'        => 'type="text"',
    	                  'file'        => 'type="file"',
                          'submit'	=> 'type="submit"',
                          'radios'      => 'type="radio"',
                          'password'    => 'type="password"',
                          'checkbox'    => 'type="checkbox"',   // checkbox MUST be before hidden
                          'hidden'      => 'type="hidden"',
                          'textarea'    => '<textarea',
                          'multiselect' => 'multiple="multiple"',
                          'select'      => '<select',
                          'link'        => '<a ',
                          'strong'      => '<strong ' );
    	foreach( $classes as $className => $pattern ) {
    		if ( strpos( $content, $pattern ) === false ) {
    			continue;
    		}
                $class = $this->getOption( 'class' );
    		if ( $class != '' ) {
    			$class .= ' ' . $className;
    		} else {
    			$class = $className;
    		}
    		$this->setOption( 'class', $class );
    		break;
    	}
    	return parent::render( $content );
    }
}
?>