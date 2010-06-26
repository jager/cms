<?php
class Webbers_Search extends Zend_Paginator {


    public static function factory( $select ) {
        if ( !$select instanceof Doctrine_Query ) {
            return false;
        }

        self::setPagination();

        $adapter = new Webbers_Paginator_Adapter_DoctrineQuery( $select );
        //$adapter->setRowCount( $select );
        return new Zend_Paginator( $adapter );
    }

    private static function setPagination() {
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
                'elements/pagination.inc'
        );
    }

}