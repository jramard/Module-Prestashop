<?php

require_once(dirname(__FILE__).'/../../models/TestProduct.php');

class AdminIndextestController extends ModuleAdminController 
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function renderList()
    {
        $has_error = false;
        $error = array();
        $is_success = false;

        $product_id = null;
        $commentary = null;
        $is_enabled = null;
        $position = null;

        $productIdList = TestProduct::getProductIdList();

        if (Tools::isSubmit('testform')) {
            $model = new TestProduct();
            $model->product_id = Tools::getValue('product_id');
            $model->commentary = Tools::getValue('commentary');
            $model->is_enabled = Tools::getValue('is_enabled');
            $model->position = Tools::getValue('position');

            if ((bool)$model->isValid() && 
                (bool)$model->save()
            ) {
                $is_success = true;
            }

            $error = (array)$model->getErrorList();
            $has_error = (bool)$model->hasError();
        }

        // ddd($productIdList);
        // ppp($productIdList);

        $this->context->smarty->assign(array(
            'controllerLink' => $this->context->link->getAdminLink(
                Tools::getValue('controller')
            ),
            'has_error' => (bool)$has_error,
            'error' => (array)$error,
            'is_success' => (bool)$is_success,
            'product_id' => $product_id,
            'commentary' => $commentary,
            'is_enabled' => (bool)$is_enabled,
            'position' => $position,
            'productIdList' => $productIdList
        ));

        return $this->module->display(
            _PS_MODULE_DIR_.$this->module->name,
            'views/templates/admin/base.tpl'
        );
    }
}
