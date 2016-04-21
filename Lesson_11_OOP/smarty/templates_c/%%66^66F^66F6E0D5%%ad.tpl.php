<?php /* Smarty version 2.6.25-dev, created on 2016-04-21 18:11:58
         compiled from ad.tpl */ ?>

<?php if ($this->_tpl_vars['ad']->private == '1'): ?>
    <div class="panel panel-success">
<?php else: ?>
    <div class="panel panel-warning">
<?php endif; ?>
        <div class="panel-heading">
            <a href="index.php?ads=<?php echo $this->_tpl_vars['ad']->getId(); ?>
"><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</a>
            <a href="?delete=<?php echo $this->_tpl_vars['ad']->getId(); ?>
" class='close'>×</a>
        </div>
        <div class="panel-body">
            <?php echo $this->_tpl_vars['ad']->getPrice(); ?>
руб |
            <?php echo $this->_tpl_vars['ad']->getName(); ?>
 |
            <a href="?edit=<?php echo $this->_tpl_vars['ad']->getId(); ?>
">Редактировать</a>
        </div>
    </div>