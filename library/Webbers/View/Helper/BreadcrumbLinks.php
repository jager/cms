<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BreadcrumbLinks
 *
 * @author mjagusia
 */
class Webbers_View_Helper_BreadcrumbLinks {

    protected  $_linkElement = "<a href='%s'>%s</a>";
    protected  $_spanElement = "<span>%s</span>";
    public function BreadcrumbLinks( $links, $separator = '>', $lastActive = false ) {
        $returnString = '';
        if ( is_string( $links ) ) {
            return $links;
        } else if ( is_array( $links ) ) {
            $count = sizeof( $links ) - 1;
            foreach( $links as $index => $link ) {
                if ( is_array( $link ) ) {
                    $href = isset( $link['href'] ) ? $link['href'] : '';
                    $text = isset( $link['text'] ) ? $link['text'] : '';
                } else {
                    $href = $link;
                    $text = $link;
                }
                if ( $index == $count ) {
                    $returnString .= !$lastActive ? sprintf( $this->_spanElement, $text ) : sprintf( $this->_linkElement, $href, $text);
                } else {
                    $returnString .= sprintf( $this->_linkElement, $href, $text) . " {$separator} ";
                }
            }
        }
        return $returnString;
    }
}
?>
