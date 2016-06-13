<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2016 Intelligent Spark
 *
 * @package    Isotope Custom Step "Order Notes"
 * @link       http://isotopeecommerce.org
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

namespace IntelligentSpark\CheckoutStep;

use Isotope\Interfaces\IsotopeCheckoutStep;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Isotope;
use Isotope\Template;



class OrderNotes extends CheckoutStep
{
    protected $strTemplate = 'iso_checkout_order_notes';

    protected $strFormId = 'iso_checkout_order_notes';

    protected $strTable = 'tl_iso_product_collection';

    protected $strField = 'notes_customer';

    /**
     * Returns true if order conditions are defined
     * @return  bool
     */
    public function isAvailable()
    {
        return true;
    }

    /**
     * Generate the checkout step
     * @return  string
     */
    public function generate()
    {
        // Make sure field data is available
        \Controller::loadDataContainer('tl_iso_product_collection');
        \System::loadLanguageFile('tl_iso_product_collection');


        $objTemplate = new Template($this->strTemplate);

        $varValue = null;

        $objWidget = new $strClass($strClass::getAttributesFromDca($GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField], $this->strField, $varValue, $this->strField, $this->strTable, $this));
        $objWidget->storeValues = true;

        if (\Input::post('FORM_SUBMIT') == $this->strFormId) {
            $objWidget->validate();
            $varValue = $objWidget->value;

            // Do not submit the field if there are errors
            if ($objWidget->hasErrors())
            {
                $doNotSubmit = true;
            }
            elseif ($objWidget->submitInput())
            {
                $objOrder = Isotope::getCart()->getDraftOrder();

                // Store the form data
                $_SESSION['FORM_DATA'][$this->strField] = $varValue;

                // Set the correct empty value (see #6284, #6373)
                if ($varValue === '')
                {
                    $varValue = $objWidget->getEmptyValue();
                }

                // Set the new value
                if ($varValue !== $objOrder->{$this->strField})
                {
                    $objOrder->{$this->strField};
                }
            }
        }

        $objTemplate->headline = $GLOBALS['TL_LANG'][$this->strTable][$this->strField][0];
        $objTemplate->customerNotes = $objWidget->parse();

        return $objTemplate->parse();

    }

    /**
     * Return array of tokens for notification
     * @param   IsotopeProductCollection
     * @return  array
     */
    public function getNotificationTokens(IsotopeProductCollection $objCollection)
    {
        return [$this->strField=>$objCollection->{$this->strField}];
    }
}