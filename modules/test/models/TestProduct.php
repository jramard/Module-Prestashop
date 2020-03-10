<?php

class TestProduct extends ObjectModel
{
    public $id;
    public $product_id;
    public $commentary;
    public $is_enabled;
    public $position;

    public static $definition = array(
        'table' => 'test_testproduct',
        'primary' => 'id_testproduct',
        'multishop' => false,
        'fields' => array(
            'product_id' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => true
            ),
            'commentary' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 255,
                'required' => false
            ),
            'is_enabled' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
                'required' => true
            ),
            'position' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => true
            )
        )
    );

    const POSITION_LEFT = 1;
    const POSITION_RIGHT = 2;
    const POSITION_FOOTER = 3;

    private $errorList = array();

    /**
     * Saves data.
     * 
     * @return bool
     */
    public function save($null_values = false, $auto_date = true)
    {
        if (!(bool)parent::save($null_values, $auto_date)) {
            $this->errorList[] = 'save';
            return false;
        }

        return true;
    }

    /**
     * Tests whether the model is valid.
     */
    public function isValid() 
    {
        $is_success = true;

        if (!Validate::isInt($this->product_id)) {
            $is_success = false;
            $this->errorList[] = 'product_id';
        }

        if (!Validate::isBool($this->is_enabled)) {
            $is_success = false;
            $this->errorList[] = 'is_enabled';
        }

        if (!Validate::isInt($this->position)) {
            $is_success = false;
            $this->errorList[] = 'position';
        }

        return (bool)$is_success;
    }

    /**
     * Defines whether there is an error.
     * 
     * @return bool
     */
    public function hasError()
    {
        return !empty((array)$this->errorList);
    }

    /**
     * Gets the error list.
     * 
     * @return array
     */
    public function getErrorList()
    {
        return (array)$this->errorList;
    }

    public static function getProductIdList()
    {
        $query = 'SELECT `id_product` FROM `'._DB_PREFIX_.'product`';

        return DB::getInstance()->executeS($query);
    }

    public static function getByIdAndPosition($id, $position)
    {
        if (!is_numeric($id)) {
            throw new Exception(
                'L\'id n\'est pas un type numérique ! <br>'.
                __METHOD__.'<br>'.
                gettype($id).' envoyé !'
            );
        }

        if (!is_numeric($position)) {
            throw new Exception(
                'La position n\'est pas un type numérique ! <br>'.
                __METHOD__.'<br>'.
                gettype($position).' envoyé !'
            );
        }

        $query = 'SELECT * 
            FROM `'._DB_PREFIX_.self::$definition['table'].'`
            WHERE `product_id` = '.(int)$id.
            ' AND `is_enabled` = 1
            AND `commentary` != \'\'
            AND `position` = '.(int)$position;

        return Db::getInstance()->executeS($query);
    }
}