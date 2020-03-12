<?php

require_once(dirname(__FILE__) . '/../../models/JulienRamardProduct.php');

class AdminIndexjulienramardController extends ModuleAdminController
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
        $border_size = null;
        $border_color = null;
        $border_radius = null;
        $background_color = null;
        $text_color = null;
        $text_align = null;
        $font_family = null;
        $minimum_product_price = null;

        $productIdList = JulienRamardProduct::getProductIdList();
        $borderColorList = JulienRamardProduct::BORDER_COLOR_LIST;
        $backgroundColorList = JulienRamardProduct::BACKGROUND_COLOR_LIST;
        $textColorList = JulienRamardProduct::TEXT_COLOR_LIST;
        $textAlignList = JulienRamardProduct::TEXT_ALIGN_LIST;
        $fontFamilyList = JulienRamardProduct::FONT_FAMILY_LIST;

        if (Tools::isSubmit('julienramardform')) {
            $model = new JulienRamardProduct();
            $model->product_id = Tools::getValue('product_id');
            $model->commentary = Tools::getValue('commentary');
            $model->is_enabled = Tools::getValue('is_enabled');
            $model->position = Tools::getValue('position');
            $model->border_size = Tools::getValue('border_size');
            $model->border_color = Tools::getValue('border_color');
            $model->border_radius = Tools::getValue('border_radius');
            $model->background_color = Tools::getValue('background_color');
            $model->text_color = Tools::getValue('text_color');
            $model->text_align = Tools::getValue('text_align');
            $model->font_family = Tools::getValue('font_family');
            $model->minimum_product_price = Tools::getValue('minimum_product_price');

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
            'border_size' => $border_size,
            'border_color' => $border_color,
            'border_radius' => $border_radius,
            'background_color' => $background_color,
            'text_color' => $text_color,
            'text_align' => $text_align,
            'font_family' => $font_family,
            'minimum_product_price' => $minimum_product_price,
            'productIdList' => $productIdList,
            'borderColorList' => $borderColorList,
            'backgroundColorList' => $backgroundColorList,
            'textColorList' => $textColorList,
            'textAlignList' => $textAlignList,
            'fontFamilyList' => $fontFamilyList,
        ));

        return $this->module->display(
            _PS_MODULE_DIR_.$this->module->name,
            'views/templates/admin/base.tpl'
        );
    }
}
