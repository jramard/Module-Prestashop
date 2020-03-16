<?php

class JulienRamardProduct extends ObjectModel
{
    public $id;
    public $product_id;
    public $commentary;
    public $is_enabled;
    public $position;
    public $border_size;
    public $border_color;
    public $border_radius;
    public $background_color;
    public $text_color;
    public $text_align;
    public $font_family;
    public $minimum_product_price;

    public static $definition = array(
        'table' => 'julienramard_julienramardproduct',
        'primary' => 'id_julienramardproduct',
        'multishop' => false,
        'fields' => array(
            'product_id' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => true
            ),
            'commentary' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString',
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
            ),
            'border_size' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false
            ),
            'border_color' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 25,
                'required' => false
            ),
            'border_radius' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false
            ),
            'background_color' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 25,
                'required' => false
            ),
            'text_color' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 25,
                'required' => false
            ),
            'text_align' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 25,
                'required' => false
            ),
            'font_family' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 25,
                'required' => false
            ),
            'minimum_product_price' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isPrice',
                'size' => 10,
                'required' => true
            )
        )
    );

    const POSITION_LEFT = 1;
    const POSITION_RIGHT = 2;
    const POSITION_FOOTER = 3;

    const BORDER_COLOR_LIST = [
        'red',
        'green',
        'blue'
    ];

    const BACKGROUND_COLOR_LIST = [
        'black',
        'grey',
        'white'
    ];

    const TEXT_COLOR_LIST = [
        'black',
        'grey',
        'white'
    ];

    const TEXT_ALIGN_LIST = [
        'left',
        'center',
        'right'
    ];

    const FONT_FAMILY_LIST = [
        'consolas',
        'tahoma',
        'verdana'
    ];

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

        // Checks if Product ID is valid
        if (!Validate::isInt($this->product_id)) {
            $is_success = false;
            $this->errorList[] = 'product_id';
        }

        // Checks if Enabled is valid
        if (!Validate::isBool($this->is_enabled)) {
            $is_success = false;
            $this->errorList[] = 'is_enabled';
        }

        // Checks if Position is valid
        if (!Validate::isInt($this->position)) {
            $is_success = false;
            $this->errorList[] = 'position';
        }

        // Checks if Border Size is valid
        if (!is_null($this->border_size) && (
            !Validate::isInt($this->border_size) ||
            $this->border_size < 0 ||
            $this->border_size > 25
        )) {
            $is_success = false;
            $this->errorList[] = 'border_size';
        }

        // Checks if Border Color is valid
        if ($this->border_color && (
                !(bool)Validate::isGenericName($this->border_color) ||
                !in_array($this->border_color, self::BORDER_COLOR_LIST)
            )) {
            $is_success = false;
            $this->errorList[] = 'border_color';
        }

        // Checks if Border Radius is valid
        if (!is_null($this->border_radius) && (
                !Validate::isInt($this->border_radius) ||
                $this->border_radius < 0 ||
                $this->border_radius > 25
            )) {
            $is_success = false;
            $this->errorList[] = 'border_radius';
        }

        // Checks if Background Color is valid
        if ($this->background_color && (
                !(bool)Validate::isGenericName($this->background_color) ||
                !in_array($this->background_color, self::BACKGROUND_COLOR_LIST)
            )) {
            $is_success = false;
            $this->errorList[] = 'background_color';
        }

        // Checks if Text Color is valid
        if ($this->text_color && (
                !(bool)Validate::isGenericName($this->text_color) ||
                !in_array($this->text_color, self::TEXT_COLOR_LIST)
            )) {
            $is_success = false;
            $this->errorList[] = 'text_color';
        }

        // Checks if Text Alignment is valid
        if ($this->text_align && (
                !(bool)Validate::isGenericName($this->text_align) ||
                !in_array($this->text_align, self::TEXT_ALIGN_LIST)
            )) {
            $is_success = false;
            $this->errorList[] = 'text_align';
        }

        // Checks if Font Family is valid
        if ($this->font_family && (
                !(bool)Validate::isGenericName($this->font_family) ||
                !in_array($this->font_family, self::FONT_FAMILY_LIST)
            )) {
            $is_success = false;
            $this->errorList[] = 'font_family';
        }

        // Checks if Minimum Product Price is valid
        if (!Validate::isPrice($this->minimum_product_price)) {
            $is_success = false;
            $this->errorList[] = 'minimum_product_price';
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

    /**
     * Gets the list of product ids.
     */
    public static function getProductIdList()
    {
        $query = 'SELECT `id_product` FROM `'._DB_PREFIX_.'product`';

        return DB::getInstance()->executeS($query);
    }

    /**
     * Gets the list of commentaries (with some parameters) corresponding to a product.
     */
    public static function getByIdAndPositionAndPrice($id, $position, $price)
    {
        if (!is_numeric($id)) {
            throw new Exception(
                'L\'id n\'est pas un type numérique !<br>'.
                __METHOD__.'<br>'.
                gettype($id).' envoyé !'
            );
        }

        if (!is_numeric($position)) {
            throw new Exception(
                'La position n\'est pas un type numérique !<br>'.
                __METHOD__.'<br>'.
                gettype($position).' envoyé !'
            );
        }

        if (!Validate::isPrice($price)) {
            throw new Exception(
                'Le prix n\'est pas correct !<br>'.
                __METHOD__.'<br>'.
                gettype($price).' envoyé !'
            );
        }

        $query = 'SELECT * 
            FROM `'._DB_PREFIX_.self::$definition['table'].'`
            WHERE `product_id` = '.(int)$id.
            ' AND `is_enabled` = 1
            AND `commentary` != \'\'
            AND `position` = '.(int)$position.
            ' AND `minimum_product_price` < '.(float)$price;

        return Db::getInstance()->executeS($query);
    }
}
