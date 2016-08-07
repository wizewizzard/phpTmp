{include file="header.tpl"}

<h1>Управление сотрудниками</h1>
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
            <a class="btn btn-primary pull-right" href="/admin/employees/manage/0">Добавить</a>
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
            <th width="200">
                Активен
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach $employees as $id => $data}
            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/employees/manage/{$id}" class="btn btn-primary" title="Изменить сотрудника"><i class="fa fa-fw fa-pencil"></i></a>
                        <a href="/admin/employees/delete/{$id}" class="btn btn-danger" title="Удалить сотрудника" data-action="remove"><i class="fa fa-fw fa-times"></i></a>
                    </div>
                </td>
                <td>
                    {$data.name}
                </td>
                <td>
                    {if $data.enabled == 1}<span style="color: darkgreen">Да</span>{else}<span style="color: darkred;">Нет</span>{/if}
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
            message: 'Вы уверены, что хотите удалить сотрудника?',
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