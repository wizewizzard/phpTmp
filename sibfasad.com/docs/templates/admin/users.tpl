{include file="header.tpl"}

<h1>Управление пользователями</h1>
<style>
th:first-child {
    width: 105px;
}
</style>

<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-primary pull-right" href="/admin/users/manage/0">Добавить</a>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>
                Имя пользователя
            </th>
            <th>
                Почта
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach $users as $id => $data}
            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/users/manage/{$id}" class="btn btn-primary" title="Изменить пользователя"><i class="fa fa-fw fa-pencil"></i></a>
                        <a href="/admin/users/delete/{$id}" class="btn btn-danger" title="Удалить пользователя" data-action="remove"><i class="fa fa-fw fa-times"></i></a>
                    </div>
                </td>
                <td>
                    {$data.name}
                </td>
                <td>
                    {$data.mail}
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

        // Prevent deleting admin
        if ($link.attr('href') == '/admin/users/delete/2') {
            bootbox.dialog({
                message: 'Нельзя удалить Администратора',
                title: 'Ошибка',
                buttons: {
                    ok: {
                        label: 'Ок',
                        className: 'btn-danger',
                        callback: function() {

                            return true;
                        }
                    }
                }
            });

            return false;
        }

        // Show confirmation dialog
        bootbox.dialog({
            message: 'Вы уверены, что хотите удалить пользователя?',
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
                    className: 'btn-default',
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