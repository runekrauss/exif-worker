<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! form rule class
jimport ( 'joomla.form.formrule' );
 
/**
 * Rule class for validating the form field "addImage"
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class JFormRuleAddImage extends JFormRule
{
    /**
     * The regular expression
     *
     * @var string
     */
    protected $regex = '.zip$';

}