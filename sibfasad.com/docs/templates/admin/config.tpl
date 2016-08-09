{include file="header.tpl"}

<h1>Управление настройками</h1>
<style>
th:first-child {
    width: 105px;
}
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>
                Имя параметра
            </th>
            <th>
                Значение
            </th>
            <th>
                Описание
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach $config as $id => $data}
            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/config/manage/{$id}" class="btn btn-primary" title="Изменить настройку"><i class="fa fa-fw fa-pencil"></i></a>
                    </div>
                </td>
                <td>
                    {$data.param}
                </td>
                <td>
                    {$data.value}
                </td>
                <td>
                    {$data.description}
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

{include file="footer.tpl"}