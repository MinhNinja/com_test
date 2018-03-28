<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Test\Administrator\Field;

defined('JPATH_BASE') or die;

use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('list');

/**
 * Userfields field.
 *
 * @since  1.6
 */
class UserfieldsField extends \JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Userfields';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.6
	 */
	public function getOptions()
	{
		$db = \JFactory::getDbo();
		$db->setQuery(
			'SELECT `id` AS `value`, `name` AS `text` '.
			'FROM #__fields '.
			'WHERE `context`="com_users.user" AND `state`=1');
		$items = $db->loadObjectList();
		return array_merge(parent::getOptions(), $items );
	}
}
