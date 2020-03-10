<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once('models/TestProduct.php');

class Test extends Module
{
    private $hookList = array(
        'actionAdminControllerSetMedia',
        'displayLeftColumnProduct',
        'displayRightColumnProduct',
        'displayFooterProduct'
    );

    public function __construct()
    {
        $this->name = 'test';
        $this->version = '1.0.0';
        $this->tab = 'administration';
        $this->author = 'Juster';
        $this->displayName = $this->l('Test module');
        $this->description = $this->l('Learning module for IUT LPDEV 2020.');
        $this->confirmUninstall = $this->l('Are you sure to uninstall this module?');

        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->ps_version_compliancy = array(
            'min' => '1.5',
            'max' => _PS_VERSION_
        );

        parent::__construct();

        $this->shopGroupId = (int)Shop::getContextShopGroupId();
        $this->shopId = (int)$this->context->shop->id;
        $this->langId = (int)$this->context->language->id;
        $this->langIso = pSQL($this->context->language->iso_code);
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return (
            (bool)parent::install() &&
            (bool)$this->_installTabList() &&
            (bool)$this->_registerHookList() &&
            (bool)$this->_installSql()
        );
    }

    protected function _installTabList()
    {
        $parentId = Tab::getIdFromClassName('AdminParentModules'.
            (version_compare(_PS_VERSION_, '1.7', '>=') 
                ? 'Sf' 
                : null
            )
        );

        $tabList = array(
            'Index' => $this->displayName
        );

        $i = 0;
        $languageList = Language::getLanguages(true);

        foreach ($tabList as $tabKey => $tabName) {
            $tabObject = new Tab();

            foreach ($languageList as $language) {
                $tabObject->name[(int)$language['id_lang']] = pSQL($tabName);
            }

            $tabObject->class_name = pSQL('Admin'.$tabKey.$this->name);
            $tabObject->module = pSQL($this->name);
            $tabObject->id_parent = (int)$parentId;
            $tabObject->position = Tab::getNewLastPosition((int)$parentId);
            $tabObject->active = ((int)$i == 0);
            $tabObject->add();
            $i++;
        }

        return true;
    }

    protected function _registerHookList()
    {
        foreach ((array)$this->hookList as $hook) {
            if (!(bool)$this->registerHook($hook)) {
                return false;
            }
        }

        return true;
    }

    protected function _installSql()
    {
        $queryList = array();

        $queryList[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->name.'_testproduct` (
            `id_testproduct` INT(11) NOT NULL AUTO_INCREMENT,
            `product_id` INT(11) NOT NULL,
            `commentary` VARCHAR(255) NULL,
            `is_enabled` TINYINT(1) NOT NULL,
            `position` INT(11) NOT NULL,
            PRIMARY KEY (`id_testproduct`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

        foreach ((array)$queryList as $query) {
            if (!(bool)Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    public function uninstall()
    {
        return (
            (bool)parent::uninstall() &&
            (bool)$this->_uninstallTabList() &&
            (bool)$this->_unregisterHookList() &&
            (bool)$this->_uninstallSql()
        );
    }

    protected function _uninstallTabList()
    {
        foreach (Tab::getCollectionFromModule($this->name) as $tab) {
            $tab->delete();
        }

        return true;
    }

    protected function _unregisterHookList()
    {
        foreach ((array)$this->hookList as $hook) {
            if (!(bool)$this->unregisterHook($hook)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Uninstalls database tables.
     * 
     * @return bool
     */
    protected function _uninstallSql()
    {
        $tableList = array(
            'testproduct'
        );

        foreach ((array)$tableList as $table) {
            if (!(bool)Db::getInstance()
                ->execute(
                    'DROP TABLE `'.pSQL(_DB_PREFIX_.$this->name.'_'.$table).'`'
                )
            ) {
                return false;
            }
        }

        return true;
    }

    public function getContent() 
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminIndex'.$this->name)
        );
    }

    public function hookActionAdminControllerSetMedia($params)
    {
        if (Tools::getValue('controller') != 'AdminIndex'.$this->name) {
            return;
        }

        $this->context->controller->addCSS($this->_path.'views/css/back.css');
        $this->context->controller->addJS($this->_path.'views/js/back.js');
    }

    public function hookDisplayLeftColumnProduct($params)
    {

    }

    public function hookDisplayRightColumnProduct($params)
    {
        // Récupération de l'id produit
        $productId = Tools::getValue('id_product');

        try {
            $commentaryList = TestProduct::getByIdAndPosition(
                (int)$productId,
                TestProduct::POSITION_RIGHT
            );
            // ddd($commentaryList);
            if (!is_array($commentaryList)) {
                $commentaryList = array();
            }

            $this->context->smarty->assign(array(
                'commentaryList' => (array)$commentaryList
            ));

            return $this->displayBlock();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function hookDisplayFooterProduct($params)
    {

    }

    private function displayBlock()
    {
        return $this->display(
            _PS_MODULE_DIR_.$this->name,
            'views/templates/hooks/front/display_block.tpl'
        );
    }
}
