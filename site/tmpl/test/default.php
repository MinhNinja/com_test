<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="profile<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1>
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        </div>
    <?php endif; ?>

    <?php if ( count($this->data ) ) : 
        foreach ( $this->data as $i=>$user ) : ?>
        <ul class="">
            <li class="btn-group">
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_test&view=profile&user_id=' . (int) $user->id); ?>">                   
                #<?php echo ++$i ?>  <span class="icon-user"></span>: <?php echo $user->name; ?>
                </a>
            </li>
        </ul>
    <?php endforeach;
    else:
        echo \JText::_('NO_RECORD_FOUND');
    endif; ?>
</div>
