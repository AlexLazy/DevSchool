<?php /* Smarty version 2.6.25-dev, created on 2016-05-31 02:35:28
         compiled from ad.tpl */ ?>

<?php if ($this->_tpl_vars['ad']->private == '1'): ?>
    <div class="panel panel-success">
<?php else: ?>
    <div class="panel panel-warning">
<?php endif; ?>
        <div class="panel-heading">
            Название: <a href="index.php?ads=<?php echo $this->_tpl_vars['ad']->getId(); ?>
"><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</a>
            <a class='close'>×</a>
        </div>
        <div class="panel-body">
            Цена: <?php echo $this->_tpl_vars['ad']->getPrice(); ?>
руб |
            Имя: <?php echo $this->_tpl_vars['ad']->getName(); ?>
 |
            <a href="?edit=<?php echo $this->_tpl_vars['ad']->getId(); ?>
">Редактировать</a>
        </div>
        <i class="hidden"><?php echo $this->_tpl_vars['ad']->getId(); ?>
</i>
    </div>