<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Test\Site\Controller;

use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

/**
 * Test Controller
 *
 * @since  1.5
 */
class DisplayController extends BaseController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
	 *
	 * @return  BaseController|bool  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = array())
	{
		$view   = $this->input->get('view', 'test');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('user_id');

		// Check for valid user
		if ($view == 'profile' && empty($id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setMessage(\JText::sprintf('COM_TEST_INVALID_USER', $id), 'error');
			$this->setRedirect(\JRoute::_('index.php?option=com_test&view=test', false));

			return false;
		}

		return parent::display();
	}
}
