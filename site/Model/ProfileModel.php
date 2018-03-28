<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Test\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Table\Table;
use Joomla\Component\Users\Administrator\Model\UserModel;
use Joomla\Registry\Registry;

/**
 * Profile model class for Users.
 *
 * @since  1.6
 */
class ProfileModel extends ItemModel
{
	/**
	 * @var		object	The user profile data.
	 * @since   1.6
	 */
	protected $data;

	/**
	 * Constructor.
	 *
	 * @param   array                $config   An optional associative array of configuration settings.
	 * @param   MVCFactoryInterface  $factory  The factory.
	 *
	 * @see     \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 * @since   3.2
	 */
	public function __construct($config = array(), MVCFactoryInterface $factory = null)
	{
		$config = array_merge(
			array(
				'events_map' => array('validate' => 'user')
			), $config
		);

		parent::__construct($config, $factory);
	} 

	/**
	 * Method to get the profile form data.
	 *
	 * The base form data is loaded and then an event is fired
	 * for users plugins to extend the data.
	 *
	 * @return  \JUser
	 *
	 * @since   1.6
	 */
	public function getUser()
	{
		if ($this->data === null)
		{
			$userId = $this->getState('user.id');

			$db = \JFactory::getDbo();
			$db->setQuery(
				'SELECT p.`fields`,u.`name`,u.`id` FROM `#__test_profiles` AS p '.
				'LEFT JOIN `#__users` AS u ON u.id=p.user_id '.
				'WHERE p.id='. $db->quote($userId)
			);

			$this->data = $db->loadObject();
			$this->data->fields = json_decode($this->data->fields);
			if( count($this->data->fields) ){
				$db->setQuery(
					'SELECT f.`label`,v.`value`,f.`id` FROM `#__fields_values` AS v '.
					'LEFT JOIN `#__fields` AS f ON f.`id`=v.`field_id` '.
					'WHERE v.`field_id` IN ('. implode(',',$this->data->fields) . ') '.
					'AND f.`context`="com_users.user" '.					
					'AND v.`item_id`='.$db->quote($this->data->id)
				);
				$this->data->fields = $db->loadObjectList();
			}
 
		}

		return $this->data;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState()
	{
		// Get the application object.
		$app = \JFactory::getApplication();
		$params = $app->getParams('com_test');

		// Set the user id.
		$this->setState('user.id', $app->input->getInt('user_id'));

		// Load the parameters.
		$this->setState('params', $params);
	}
}
