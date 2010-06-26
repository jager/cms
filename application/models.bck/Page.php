<?php

/**
 * Page
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Page extends BasePage
{
    public static function findList() {
        return Doctrine_Query::create()
                ->select( 'id, pname, created, edited, active')
                ->from( 'Page' );
    }

    public static function getById( $id ) {
        return Doctrine_Core::getTable( 'Page' )->find( $id );
    }

    public static function getByLink( $link = '' ) {
        if ( $link == '' ) {
            $menuItem = Doctrine_Core::getTable( 'Menu' )->findOneByParent_id( 0 );
            if ( is_object( $menuItem ) and isset( $menuItem->Pages_id ) ) {
                return self::getById( $menuItem->Pages_id );
            } else {
                throw new Exception( 'Taka strona nie istnieje.' );
            }
        }
        return Doctrine_Core::getTable( 'Page' )->findOneByLink( $link );
    }

    public function existsByName( $pname ) {
        return Doctrine_Core::getTable( 'Page' )->findByPname( $pname )->count() > 0 ? true : false;
    }

    public function updatePage( $aData, $aMenuData ) {
        $content = trim( stripslashes( $aData['content'] ) );
        if ( isset( $aData['id'] ) ) {
            $this->id = $aData['id'];
            $this->edited = new Doctrine_Expression( "now()" );
            if ( $this->content != $content ) {
                $this->backupPage();
            }
        } else {
            $this->created = new Doctrine_Expression( "now()" );
            $this->edited = new Doctrine_Expression( "now()" );
        }
        $this->pname = $aData['pname'];
        $this->link = Webbers_Normalize::Link( $aData['pname'] );
        $this->hd_title = $aData['hd_title'];
        $this->hd_keywords = $aData['hd_keywords'];
        $this->content = $content;
        $this->active = $aData['active'];
        $this->owner = Zend_Auth::getInstance()->getIdentity()->username;
        $this->save();
        
        if ( $aData['menuitem'] == '0' ) {
            if ( is_array( $aMenuData ) and ( $aMenuData['mname'] != '' ) ) {
                $aMenuData['active'] = $aData['active'];
                $aMenuData['Pages_id'] = $this->id;
                $aMenuData['link'] = '/pages/' . $this->link;
                $menu = new Menu();
                $menu->updateMenu( $aMenuData );
            }
        } else {
            $menu = Menu::getMenu( $aData['menuitem'] );
            if ( $menu->Pages_id > 0 ) {
                $oldMenu = Menu::getMenusByPageId( $this->id );
                if ( $oldMenu ) {
                    $oldMenu->Pages_id = $menu->Pages_id;
                    $oldMenu->save();
                }
            }
            $menu->mname = $this->pname;
            $menu->active = $aData['active'];
            $menu->Pages_id = $this->id;
            $menu->link = '/pages/' . $this->link;
            $menu->save();
        }

        return $this->id;
    }

    private function backupPage() {
        $backup = new Pageshistory();
        $backup->createBackup( $this->id, $this->content );
    }
}