<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2016 Intelligent Spark
 *
 * @package    Isotope Custom Step "Delivery Date"
 * @link       http://isotopeecommerce.org
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */



$GLOBALS['TL_DCA']['tl_iso_product_collection']['palettes']['default'] .= ';{customer_legend},notes_customer';

$GLOBALS['TL_DCA']['tl_iso_product_collection']['fields']['notes_customer'] = array
(
    'label'			=> &$GLOBALS['TL_LANG']['tl_iso_product_collection']['notes_customer'],
    'search'		=> true,
    'inputType'		=> 'textarea',
    'eval'			=> array('style'=>'height:70px'),
    'sql'           => 'mediumtext NULL'
);