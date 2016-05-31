
{if $ad->private == '1'}
    <div class="panel panel-success">
{else}
    <div class="panel panel-warning">
{/if}
        <div class="panel-heading">
            Название: <a href="index.php?ads={$ad->getId()}">{$ad->getTitle()}</a>
            <a class='close'>×</a>
        </div>
        <div class="panel-body">
            Цена: {$ad->getPrice()}руб |
            Имя: {$ad->getName()} |
            <a href="?edit={$ad->getId()}">Редактировать</a>
        </div>
        <i class="hidden">{$ad->getId()}</i>
    </div>
