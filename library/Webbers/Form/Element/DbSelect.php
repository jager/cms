<?php
class Webbers_Form_Element_DbSelect extends Zend_Form_Element_Select {
	protected $_adapter;
	protected $_table;
	protected $_valueColumn = 'id';
	protected $_labelColumn = 'name';
	protected $_condition   = null;
	protected $_selected    = false;
	protected $_attribsKeys = array();
	/**
	 * Set the database adapter used
	 *
	 * @param Zend_Db_Adapter_Abstract|string $adapter instance of adapter or key from registry that points to adapter
	 * @return Webbers_Form_Element_DbSelect
	 */
	public function setAdapter( $adapter ) {
		$this->_adapter = $adapter;
		return $this;
	}
	/**
	 * Retrieves database adapter
	 *
	 * @return Zend_Db_Adapter_Abstract
	 */
	public function getDbAdapter() {
		if ( is_string( $this->_adapter ) ) {
			if ( Zend_Registry::isRegistered( $this->_adapter ) ) {
				$this->_adapter = Zend_Registry::get( $this->_adapter );
			} else {
				$this->_adapter = null;
			}
		}
		if( null === $this->_adapter ) {
			$this->_adapter = Zend_Db_Table::getDefaultAdapter();
		}
		return $this->_adapter;
	}
	/**
	 * Set the table name for query
	 *
	 * @param string $table
	 * @return Webbers_Form_Element_DbSelect
	 */
	public function setTable( $table ) {
		$this->_table = $table;
		return $this;
	}
	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getTable() {
		if ( null === $this->_table ) {
			throw new Zend_Form_Element_Exception( 'Missing table name', 1 );
		}
		return $this->_table;
	}
	/**
	 * Set the column where the identifiers for the options are fetched
	 *
	 * @param string $name
	 * @return Webbers_Form_Element_DbSelect
	 */
	public function setValueColumn( $value ) {
		$this->_valueColumn = $value;
		return $this;
	}
	public function getValueColumn() {
		if ( null === $this->_valueColumn ) {
			throw new Zend_Form_Element_Exception( 'Missing value column name', 1 );
		}
		return $this->_valueColumn;
	}
	/**
	 * Set the column where the identifiers for the options are fetched
	 *
	 * @param string $name
	 * @return Webbers_Form_Element_DbSelect
	 */
	public function setLabelColumn( $label ) {
		$this->_labelColumn = $label;
		return $this;
	}
	public function getLabelColumn() {
		if ( null === $this->_labelColumn ) {
			throw new Zend_Form_Element_Exception( 'Missing label column name', 2 );
		}
		return $this->_labelColumn;
	}
	public function setAttribsKeys( $keys ) {
		if ( is_string( $keys ) ) {
			$keys = Webbers_Util::explode( $keys );
		} elseif( $keys instanceof Zend_Config ) {
			$keys = $keys->toArray();
		}
		$this->_attribsKeys = (array) $keys;
		return $this;
	}
    public function getAttribsKeys( $keys ) {
        return $this->_attribsKeys;
    }
	public function setCondition( $condition ) {
		$this->_condition = $condition;
		return $this;
	}
	protected function _performSelect() {
		if ( $this->_selected ) {
			return;
		}
		$this->_selected = true;
		$adapter = $this->getDbAdapter();
		// fetchPairs
		$labelQuoted = $adapter->quoteIdentifier( 'label' );
		$select = $adapter->select()->from( array( 't' => $this->getTable() ),
                                            array( $adapter->quoteIdentifier( 'id' ) => $this->getValueColumn(),
												   $labelQuoted                      => $this->getLabelColumn() ) )
												 ->order( $labelQuoted . ' ASC' );
        if ( null !== $this->_condition ) {
            $select->where( $this->_condition );
        }
		if ( $this->_attribsKeys ) {
			$output = array();
	        foreach( $this->_attribsKeys as $alias => $column ) {
	        	if ( is_array( $column ) && count( $column ) == 2 ) {
	        		$alias  = $column['key'];
                    $column = $column['value'];
	        	}
	        	if ( !is_numeric( $alias ) ) {
	        		$alias = $adapter->quoteIdentifier( $alias );
	        	}
	        	$output[$alias] = (string) $column;
	        }
            $select->columns( $output, 't' );
	        $tmp = $this->getDbAdapter()->fetchAll( $select, array(), Zend_Db::FETCH_ASSOC );
	        foreach( $tmp as $row ) {
	        	$id    = $row['id'];
	        	$label = $row['label'];
	        	unset( $row['id'], $row['label'] );
                $this->addMultiOption( $id, array( 'label' => $label, 'attribs' => $row ) );
	        }
		} else {
            $this->setMultiOptions( $this->getDbAdapter()->fetchPairs( $select ) );
		}
	}
	public function getMultiOptions() {
		$this->_performSelect();
		return parent::getMultiOptions();
	}
    /**
     * Is the value provided valid?
     *
     * Autoregisters InArray validator if necessary.
     *
     * @param  string $value
     * @param  mixed $context
     * @return bool
     */
    public function isValid($value, $context = null) {
        if ($this->registerInArrayValidator()) {
            if (!$this->getValidator('InArray')) {
                $multiOptions = $this->getMultiOptions();
                $options      = array();

                foreach ($multiOptions as $opt_value => $opt_label) {
		            // check if it`s array
		            if ( is_array( $opt_label ) ) {
		                $isGroup = !self::isArrayStyleLabel( $opt_label );
		            } else {
		                $isGroup = false;
		            }
                    // optgroup instead of option label
                    if ( $isGroup ) {
                        $options = array_merge($options, array_keys($opt_label));
                    }
                    else {
                        $options[] = $opt_value;
                    }
                }

                $this->addValidator(
                    'InArray',
                    true,
                    array($options)
                );
            }
        }
        return parent::isValid($value, $context);
    }
	protected function _translateOption( $option, $value ) {
		if ( !isset( $value['label'] ) ) {
            return parent::_translateOption( $option, $value );
		}
		$return = parent::_translateOption( $option, $value['label'] );
        if ( !is_string( $this->options[$option] ) ) {
        	return $return;
        }
        $value['label']         = $this->options[$option];;
        $this->options[$option] = $value;
        return $return;
	}
    public static function isArrayStyleLabel( $input ) {
        return count( $input ) == 2 &&
               array_key_exists( 'attribs', $input ) &&
               array_key_exists( 'label', $input );
    }
}
?>