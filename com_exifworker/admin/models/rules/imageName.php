<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! form rule class
jimport ( 'joomla.form.formrule' );

/**
 * Rule class for validating the form field "imageName"
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class JFormRuleImageName extends JFormRule {
	/**
	 * The regular expression
	 *
	 * @var string
	 */
	protected $regex = '^[^0-9]+$';
}