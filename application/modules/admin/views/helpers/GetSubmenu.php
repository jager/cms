<?php
class Webbers_View_Helper_GetSubmenu extends Zend_View_Helper_Abstract {

    public $view;

    public function GetSubmenu( $menuitem, $lp, $sublevel = 1 ) {
        $returnString = '';
        if ( $menuitem->parent_id == 0 ) {
            return $returnString;
        }
        $submenu = Menu::getElementByParent( $menuitem->id );
        $subLevelString = str_repeat("&nbsp;&nbsp;", $sublevel );
        foreach( $submenu as $submenuitem ) {
            $returnString .= "<tr " . $this->view->cycle( array( "class='light'", "class='dark'") )->next() . ">
			<td class='selected'>" . ++$lp . "</td>
                        <td class='title'>{$subLevelString}<a href='/admin/pages/edit/{$submenuitem->id}' class='noBox'>{$submenuitem->mname}</a></td>
                        <td>{$submenuitem->type}</td>
                        <td>{$submenuitem->link}</td>
                        <td class='selected'>" . ( $submenuitem->active == '1' ? "<input type='checkbox' name='publish' id='publish_{$submenuitem->id}' class='publish' />" : "<input type='checkbox' name='unpublish' id='unpublish_{$submenuitem->id}' class='unpublish' />" ) . "</td>
                        <td class='last'>
                            <a class=='edit listMenu' href='/admin/pages/edit/{$submenuitem->Pages_id}'>Edytuj</a>
                            <a class='delete listMenu asBox' href='/admin/pages/delete/{$submenuitem->Pages_id}'>Usuń</a>
			</td>
		</tr>";
            $returnString .= $this->GetSubmenu($submenuitem, $lp, $sublevel + 1 );
        }
        return $returnString;
    }

    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
}
?>
