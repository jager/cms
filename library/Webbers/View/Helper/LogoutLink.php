<?php
class Webbers_View_Helper_LogoutLink {
	public function logoutLink() {
		if ( !Zend_Auth::getInstance()->hasIdentity() ) {
			return;
		}
		$adminuser = Zend_Auth::getInstance()->getIdentity();
		$links = "<ul id='user'>
                    <li class='first'><a href=''>Witaj, {$adminuser->fname} {$adminuser->sname}</a></li>
                    <li><a href='/admin/index/edit'>Konto</a></li>
                    <li><a href='/admin/index/message'>Wiadomości (0)</a></li>
                    <li><a href='/admin/index/logout'>Wyloguj</a></li>
                    <li class='last highlight'><a href='/'>Zobacz stronę</a></li>
                    </ul>";
		return $links;
	}
}