{include file="header.tpl"}

<h1>{$header}</h1>


<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Наименование</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$product.name}" placeholder="Наименование продукта">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Бренд</label>
            <div class="col-sm-3">
                <select name="brand" class="form-control">
                    {foreach $brands as $id => $brand}
                        <option value="{$id}"{if $product.brand == $id} selected="selected"{/if}>{$brand}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-3">
                <select name="category" class="form-control" id="category">
                    {foreach $categories as $id => $name}
                        <option value="{$id}"{if $product.category == $id} selected="selected"{/if}>{$name}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group" id="vehicle" {if $vehicle == 0}hidden{/if}>
            <label class="col-sm-2 control-label">Вид транспорта</label>
            <div class="col-sm-3">
                <select name="vehicle_type" class="form-control">
                    {foreach $vehicles as $id => $name}
                        <option value="{$id}"{if $product.vehicle_type == $id} selected="selected"{/if}>{$name}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group" id="oil" {if $oil == 0}hidden{/if}>
            <label class="col-sm-2 control-label">Тип масла</label>
            <div class="col-sm-3">
                <select name="oil_type" class="form-control">
                    {foreach $oils as $id => $name}
                        <option value="{$id}"{if $product.oil_type == $id} selected="selected"{/if}>{$name}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group" id="fluid" {if $fluid == 0}hidden{/if}>
            <label class="col-sm-2 control-label">Тип кпп</label>
            <div class="col-sm-3">
                <select name="transmission_type" class="form-control">
                    {foreach $fluids as $id => $name}
                        <option value="{$id}"{if $product.transmission_type == $id} selected="selected"{/if}>{$name}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Допуски (коротко)</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="margins" rows="3" placeholder="Допуски продукта">{$product.margins}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Допуски (ещё)</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="margins_full" rows="3" placeholder="Допуски продукта">{$product.margins_full}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descr" rows="3" placeholder="Описание продукта">{$product.descr}</textarea>
            </div>
        </div>
        <div data-handler="prices">
            {foreach name="prices" from=$product.prices key="package" item="price"}
                <div class="form-group" data-row>
                    <label class="col-sm-2 control-label">Фасовка</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="packages[]" value="{$package}" placeholder="" />
                    </div>
                    <label class="col-sm-1 control-label">Цена</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="prices[]" value="{$price}" placeholder="" />
                    </div>
                    <div class="col-sm-2">
                        {if $smarty.foreach.prices.first === true}
                            <button class="btn btn-success" data-action="add"><i class="fa fa-fw fa-plus"></i></button>
                        {else}
                            <button class="btn btn-danger" data-action="remove"><i class="fa fa-fw fa-minus"></i></button>
                        {/if}
                    </div>
                </div>
            {foreachelse}
                <div class="form-group" data-row>
                    <label class="col-sm-2 control-label">Фасовка</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="packages[]" placeholder="" />
                    </div>
                    <label class="col-sm-1 control-label">Цена</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="prices[]" placeholder="" />
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" data-action="add"><i class="fa fa-fw fa-plus"></i></button>
                    </div>
                </div>
            {/foreach}
        </div>
        <div data-handler="properties">
            {foreach name="properties" from=$product.properties key="property" item="value"}
                <div class="form-group" data-row>
                    <label class="col-sm-2 control-label">Характеристика</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="properties[]" value="{$property}" placeholder="" />
                    </div>
                    <label class="col-sm-1 control-label">Значение</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="values[]" value="{$value}" placeholder="" />
                    </div>
                    <div class="col-sm-2">
                        {if $smarty.foreach.properties.first === true}
                            <button class="btn btn-success" data-action="add"><i class="fa fa-fw fa-plus"></i></button>
                        {else}
                            <button class="btn btn-danger" data-action="remove"><i class="fa fa-fw fa-minus"></i></button>
                        {/if}
                    </div>
                </div>
            {foreachelse}
                <div class="form-group" data-row>
                    <label class="col-sm-2 control-label">Характеристика</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="properties[]" placeholder="" />
                    </div>
                    <label class="col-sm-1 control-label">Значение</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" name="values[]" placeholder="" />
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success add-property" data-action="add"><i class="fa fa-fw fa-plus"></i></button>
                    </div>
                </div>
            {/foreach}
        </div>
        <div class="form-group">
            <label for="excelPrice" class="col-sm-2 control-label">Выберите файл</label>
            <div class="col-sm-10">
                <input type="file" id="productPhoto" name="productPhoto">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Отображать на сайте</label>
            <div class="col-sm-2">
                <label class="radio-inline">
                    <input type="radio" name="active" id="inlineRadio1" value="1" {if $product.active == 1}checked{/if}> Да
                </label>
                <label class="radio-inline">
                    <input type="radio" name="active" id="inlineRadio2" value="0" {if $product.active == 0}checked{/if}> Нет
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
/*
* Add margin and price row
*/
$(function() {
    $('#category').on('change', function() {
        $('#vehicle').hide(); 
        $('#oil').hide(); 
        $('#fluid').hide();

        switch ($(this).val()) {
            case '1':
                $('#vehicle').show(); 
                $('#oil').show(); 
                break;

            case '2':
                $('#fluid').show(); 
                break;
        }
    });

    /*
    * Add new rows if need
    */
    $('.btn[data-action="add"]').on('click', function() {
        // Prepare variables
        var
            $button  = $(this),
            $handler = $button.closest('[data-handler]'),
            $newRow  = $button.closest('[data-row]').clone(),
            $rowButton = $('[data-action]', $newRow);

        // Change add button to remove button
        $rowButton.attr('data-action', 'remove').toggleClass('btn-success btn-danger');
        $('i.fa', $rowButton).toggleClass('fa-plus fa-minus');

        // Append row
        $newRow.appendTo($handler);

        // Prevent default action
        return false;
    });

    /*
    * Extend "remove" buttons
    */
    $(document).on('click', '.btn[data-action="remove"]', function() {
        // Prepare variables
        var
            $row = $(this).closest('[data-row]');

        // Remove row
        $row.fadeOut('fast', function() {
            $row.remove();
        });

        // Prevent default action
        return false;
    });
});
</script>

{include file="footer.tpl"}