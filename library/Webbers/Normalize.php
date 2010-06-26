<?php
class Webbers_Normalize {
	
	static public function Name( $name ) {
		return ucfirst( preg_replace("/[^a-zążźćśęłóń ]/ui","", strtolower( trim( $name ) ) ) );
	}

        static public function Email( $email ) {
            return strtolower( trim( $email ) );
        }

        static public function Link( $string ) {
            $aReplacement = array( 'ą' => 'a',
                                   'ś' => 's',
                                   'ć' => 'c',
                                   'ź' => 'z',
                                   'ż' => 'z',
                                   'ę' => 'e',
                                   'ó' => 'o',
                                   'ł' => 'l',
                                   'ń' => 'n',
                                   ' ' => '_');
            return preg_replace('/[^a-z0-9_]/u', '', strtr( strtolower( $string ), $aReplacement )) . '.html';
        }
}