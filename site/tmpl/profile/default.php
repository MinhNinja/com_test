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

    <table class="table">
        <tr><th><?php echo \JText::_('NAME') ?></th><td><?php echo $this->user->name ?></td></tr>
        <?php foreach( $this->user->fields as $f): ?>
            <tr><th><?php echo $f->label ?></th><td><?php echo $f->value ?></td></tr>
        <?php endforeach; ?>
    </table>

         
</div>
