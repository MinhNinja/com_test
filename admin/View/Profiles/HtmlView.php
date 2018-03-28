<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Test\Administrator\View\Profiles;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * View class for a list of profiles.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * An array of items
	 *
	 * @var  array
	 */
	protected $items;

	/**
	 * The pagination object
	 *
	 * @var  \JPagination
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var  object
	 */
	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \JViewGenericdataexception(implode("\n", $errors), 500);
		}

		\JHtmlSidebar::addEntry(
			\JText::_('COM_TEST_SUBMENU_PROFILES'),
			'index.php?option=com_test&view=profiles',
			true
		);

		$this->addToolbar();
		$this->sidebar = \JHtmlSidebar::render();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$canDo = \JHelperContent::getActions('com_test');

		\JToolbarHelper::title(\JText::_('COM_TEST_MANAGER_PROFILES'), 'bookmark profiles');

		if ($canDo->get('core.create'))
		{
			\JToolbarHelper::addNew('profile.add');
		}

		if ($canDo->get('core.edit.state'))
		{
			\JToolbarHelper::publish('profiles.publish', 'JTOOLBAR_PUBLISH', true);
			\JToolbarHelper::unpublish('profiles.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			\JToolbarHelper::archiveList('profiles.archive');
			\JToolbarHelper::checkin('profiles.checkin');
		}

		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			\JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'profiles.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			\JToolbarHelper::trash('profiles.trash');
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			\JToolbarHelper::preferences('com_test');
		}

		\JToolbarHelper::help('JHELP_COMPONENTS_BANNERS_PROFILES');
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.status'    => \JText::_('JSTATUS'),
			'a.name'      => \JText::_('COM_TEST_HEADING_PROFILE'),
			'a.id'        => \JText::_('JGRID_HEADING_ID')
		);
	}
}
