{include file="header.tpl"}

<h1>Контент главной страницы</h1>
<style>
th:first-child {
    width: 50px;
}
td:last-child {
    width: 115px;
}
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>№</th>
            <th colspan="5">
                Тип содержимого шестиугольника
            </th>
        </tr>
    </thead>
    <tbody>
            <tr id="1">
                <td>
                    1
                </td>
                <td>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" value="1"> Объект
                    </label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </td>
                <td>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" value="2"> Партнер
                    </label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </td>
                <td>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" value="3"> Цвет
                    </label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </td>
                <td>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" value="4"> Пусто
                    </label>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </td>
            <tr>
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
            message: 'Вы уверены, что хотите удалить объект?',
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