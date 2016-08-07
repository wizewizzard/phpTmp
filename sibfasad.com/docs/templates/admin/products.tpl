{include file="header.tpl"}

<h1>Управление продукцией</h1>

<div class="row">
    <form role="form">
        <div class="col-lg-6">
            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="email" placeholder="Введите параметры поиска">
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button">Поиск</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <a class="btn btn-primary pull-right" href="/admin/products/manage/0">Добавить</a>
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
                Бренд
            </th>
            <th>
                Допуски
            </th>
            <th>
                Фасовка
                &ndash;
                Цена
            </th>
            <th>
                Показывать
            </th>
        </tr>
    </thead>
    <tbody>
        {foreach name="products" from=$products key="productId" item="productData"}
            {$brandId = $productData.brand}

            <tr>
                <td>
                    <div class="btn-group">
                        <a href="/admin/products/manage/{$productId}" class="btn btn-primary" title="Изменить продукт"><i class="fa fa-fw fa-pencil"></i></a>
                        <a href="/admin/products/delete/{$productId}" class="btn btn-danger" title="Удалить продукт" data-action="remove"><i class="fa fa-fw fa-times"></i></a>
                    </div>
                </td>
                <td>
                    {$productData.name}
                </td>
                <td>
                    {$brands.$brandId.name}
                </td>
                <td>
                    123123
                </td>
                <td>
                    {foreach name="productPrices" from=$productData.prices key="priceName" item="priceValue"}
                        {$priceName} &ndash; {$priceValue}<br>
                    {/foreach}
                </td>
                <td class="text-center">
                    {if $productData.active == 1}
                        <i class="fa fa-fw fa-check text-success"></i>
                    {else}
                        <i class="fa fa-fw fa-times text-danger"></i>
                    {/if}
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
            message: 'Вы уверены, что хотите удалить продукт?',
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