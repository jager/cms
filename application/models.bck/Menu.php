<?php

/**
 * Menu
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Menu extends BaseMenu
{
    public static function getMenus() {
        return Doctrine_Core::getTable( 'Menu' )->findAll();
    }

    public static function getMenusByPageId( $pageID ) {
        return Doctrine_Core::getTable( 'Menu' )->findOneByPages_id( $pageID );
    }

    private static function getMenuFullStructureSql( $active = '' ) {
        $sql = Doctrine_Query::create()
                    ->select( 'id, mname, link')
                    ->from( 'Menu' )                    
                    ->orderBy( 'ord' );
       if ( $active != '' ) {
           $sql->where( 'active = ? and parent_id = 0', $active );
       } else {
           $sql->where( 'parent_id = 0' );
       }
       return $sql->execute();
    }

    private static function getFullObjectStructure( $query ) {
        $oReturn = array();
        foreach( $query as $main ) {
            $oReturn[ $main->id ] = new stdClass();
            $oReturn[ $main->id ]->name = $main->mname;
            $oReturn[ $main->id ]->id = $main->id;
            $oReturn[ $main->id ]->ord = $main->ord;
            $oReturn[ $main->id ]->parent = $main->parent_id;
            $oReturn[ $main->id ]->active = $main->active;
            $oReturn[ $main->id ]->pages = self::getFullObjectStructure( $main->getChildren() );
        }
        return $oReturn;
    }
    private static function getFullXmlStructure( $query ) {
        $xReturn = new SimpleXMLElement( '<configdata />');
        $xNav = $xReturn->addChild( 'nav' );
        foreach( $query as $s ) {
            $xNode = $xNav->addChild( "page_{$s->id}" );
            $xNode->addChild( 'label', $s->mname );
            $xNode->addChild( 'uri', $s->link );
            $children = $s->getChildren( '1' );
            if ( sizeof( $children ) > 0 ) {
                //$xPages = $xNode->addChild( 'pages' );
                foreach( $children as $child ) {
                    $xChild = $xNav->addChild( "page_{$child->id}" );
                    $xChild->addChild( 'label', $child->mname );
                    $xChild->addChild( 'uri', $child->link );
                    $children1 = $child->getChildren( '1' );
                    if ( sizeof( $children1 ) > 0 ) {
                        $xSubPages = $xChild->addChild( 'pages' );
                        foreach ( $children1 as $child1 ) {
                            $xChild1 = $xSubPages->addChild( "page_{$child1->id}" );
                            $xChild1->addChild( 'label', $child1->mname );
                            $xChild1->addChild( 'uri', $child1->link );
                        }
                    }
                }
            }
        }
        return $xReturn->asXML();
    }

    private function getChildren( $active = '' ) {
        $sql = Doctrine_Query::create()
                    ->select( 'id, mname, link' )
                    ->from( 'Menu' )

                    ->orderBy( 'ord' );
        if ( $active != '' ) {
            $sql->where( 'active = :active and parent_id = :parent_id', array(':active' => $active, ':parent_id' => $this->id ) );
        } else {
            $sql->where( 'parent_id = :parent_id', array( ':parent_id' => $this->id ) );
        }
        return $sql->execute();
    }

    public static function getStructure( $structure = null, $mode = null ) {
        switch( $structure ) {            
            case "full":
            default:
               if ( $mode == 'object') {
                    return self::getFullObjectStructure( self::getMenuFullStructureSql() );
               } else {
                    return self::getFullXmlStructure( self::getMenuFullStructureSql('1') );
               }
        }
    }

    public static function getMenusInArray( $filter ) {
        $menus = self::getMenus();

        if ( sizeof( $menus ) == 0 ) {
            return array();
        }
        $aReturn = array();
        foreach( $menus as $menu ) {
            if ( !is_null( $filter ) ) {
                foreach( $filter as $key => $value ) {
                    if ( $menu->$key != $value ) {
                        continue(2);
                    }
                }
            }
            $aReturn[ $menu->id ] = $menu->mname;
        }
        return $aReturn;
    }

    public static function getMenu( $id ) {
        return Doctrine_Core::getTable( 'Menu' )->find( $id );
    }

    public static function getElementByParent( $parent_id ) {
        return Doctrine_Core::getTable( 'Menu' )->findByParent_id( $parent_id );
    }

    public function updateMenu( $aData ) {
        if ( isset( $aData['id'] ) ) {
            $this->id = $aData['id'];
        }
        $link = '';
        switch ( $aData['type'] ) {
            case 'gallery':
                $link = '/galerie';
            break;
            case 'tournaments':
                $link = '/turnieje';
            break;
            case 'ranks':
                $link = '/turnieje/ranking';
            break;
            case 'actuals':
                $link = '/aktualnosci';
            break;
            case 'static':
            default:
                $link = '/pages/' . Webbers_Normalize::Link( $aData['mname'] );
            break;
        }
        $parentId = (int)$aData['parent_id'];
        if ( $parentId == 0 ) {
            $aElements = self::getElementByParent( 0 );
            if ( $aElements->count() == 1 ) {
                $element = $aElements->getFirst();
                $parentId = (int)$element->id;
            } else if ( $aElements->count() > 1 ) {
                $element = $aElements->getFirst();
                $parentId = (int)$element->id;
                foreach( $aElements as $elem ) {
                    if ( $elem->id != $element->id ) {
                        $elem->parent_id = (int)$element->id;
                        $elem->save();
                    }
                }
            }
        }
   
        $this->mname = $aData['mname'];
        $this->type = $aData['type'];
        $this->link = $link;
        $this->active = $aData['active'];
        $this->parent_id = $parentId;
        $this->Pages_id = (int)$aData['Pages_id'];
        $this->ord = $this->getOrder( $parentId );
        $this->save();
        $this->setOrder( $this->id, $this->ord );
        return $this->id;
    }

    private function getOrder( $id ) {
        if ( $id == 0 ) {
            $maxOrd = Doctrine_Query::create()
                    ->select( new Doctrine_Expression( 'max(ord) as ord' ) )
                    ->from( 'Menu' )
                    ->execute( array(), DOCTRINE_CORE::HYDRATE_SINGLE_SCALAR );
           
        } else {
            $maxOrd = Doctrine_Query::create()
                    ->select( new Doctrine_Expression( 'max(ord) as ord' ) )
                    ->from( 'Menu' )
                    ->where( 'parent_id = ?', $id )
                    ->execute( array(), DOCTRINE_CORE::HYDRATE_SINGLE_SCALAR );
        }
        
        if ( $maxOrd == null ) {
            $parent = $this->getTable()->find( $id );
            return ( $parent->ord + 1);
        } else {
            return ( $maxOrd + 1 );
        }
    }

    private function setOrder( $id, $order ) {
        return Doctrine_Query::create()
                ->update( 'Menu' )
                ->set( 'ord', 'ord + 1' )
                ->where( ' ord >= '. $order . ' and id != ' . $id )
                ->execute();
    }
    
    public static function changeOrder( $currentId ) {}
}