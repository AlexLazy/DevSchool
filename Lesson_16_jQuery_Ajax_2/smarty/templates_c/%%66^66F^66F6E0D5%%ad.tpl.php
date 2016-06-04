<?php /* Smarty version 2.6.25-dev, created on 2016-06-04 14:40:35
         compiled from ad.tpl */ ?>
<?php if ($this->_tpl_vars['ad']->private == '1'): ?>
    <div class="panel panel-success">
<?php else: ?>
    <div class="panel panel-warning">
<?php endif; ?>
        <div class="panel-heading">
            Название: <a class="ads-title"><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</a>
            <a class='close'>×</a>
        </div>
        <div class="panel-body">
            Цена: <?php echo $this->_tpl_vars['ad']->getPrice(); ?>
руб |
            Имя: <?php echo $this->_tpl_vars['ad']->getName(); ?>
 |
            <a class="edit">Редактировать</a>
        </div>
        <i class="hidden"><?php echo $this->_tpl_vars['ad']->getId(); ?>
</i>
    </div>