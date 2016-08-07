{include file="header.tpl"}

<h1>Управление услугами</h1>
<style>
th:first-child {
    width: 61px;
}
</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>
                Наименование
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach $services as $name => $data}
            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/services/manage/{$name}" class="btn btn-primary" title="Редактировать услугу"><i class="fa fa-fw fa-pencil"></i></a>
                    </div>
                </td>
                <td>
                    {$data.title}
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