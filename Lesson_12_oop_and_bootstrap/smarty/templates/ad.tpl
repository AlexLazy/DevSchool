
{if $ad->private == '1'}
    <div class="panel panel-success">
{else}
    <div class="panel panel-warning">
{/if}
        <div class="panel-heading">
            <a href="index.php?ads={$ad->getId()}">{$ad->getTitle()}</a>
            <a href="?delete={$ad->getId()}" class='close'>×</a>
        </div>
        <div class="panel-body">
            {$ad->getPrice()}руб |
            {$ad->getName()} |
            <a href="?edit={$ad->getId()}">Редактировать</a>
        </div>
    </div>
