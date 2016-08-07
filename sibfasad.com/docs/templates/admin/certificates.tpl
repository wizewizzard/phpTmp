{include file="header.tpl"}

<h1>Управление дипломами</h1>
<style>
th:first-child {
    width: 105px;
}
</style>

<div class="row">
    <form role="form" class="form-horizontal" method="post">
        <div class="col-lg-6">
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="text" name="search" value="{if isset($search)}{$search}{/if}"placeholder="Введите параметры поиска">
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-info" value="Поиск" />
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <a class="btn btn-primary pull-right" href="/admin/certificates/manage/0">Добавить</a>
        </div>
    </form>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>
                Наименование
            </th>
            <th>
                Фото
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach $certificates as $id => $data}
            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/certificates/manage/{$id}" class="btn btn-primary" title="Изменить диплом"><i class="fa fa-fw fa-pencil"></i></a>
                        <a href="/admin/certificates/delete/{$id}" class="btn btn-danger" title="Удалить диплом" data-action="remove"><i class="fa fa-fw fa-times"></i></a>
                    </div>
                </td>
                <td>
                    {$data.name}
                </td>
                <td style="width: 150px;">
                    <img style="height: 200px;" src="/upload/certificates/thumbs/{$data.photo}" />
                </td>
            <tr>
        {foreachelse}
            <tr>
                <td colspan="2">
                    Ничего не найдено...
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>

<script type="text/javascript">
$(function() {
    $('[data-action="remove"]').on('click', function() {
        // Prepare variables
        var
            $link = $(this);

        // Show confirmation dialog
        bootbox.dialog({
            message: 'Вы уверены, что хотите удалить диплом?',
            title: 'Подтверждение',
            buttons: {
                cancel: {
                    label: 'Отмена',
                    className: 'btn-default',
                    callback: function() {
                        // Don't do anything on cancel
                        return true;
                    }
                },
                ok: {
                    label: 'Удалить',
                    className: 'btn-danger',
                    callback: function() {
                        window.location.assign($link.attr('href'));

                        return true;
                    }
                }
            }
        });

        // Prevent default action
        return false;
    });
});
</script>

{include file="footer.tpl"}