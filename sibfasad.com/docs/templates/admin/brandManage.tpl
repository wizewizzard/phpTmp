{include file="header.tpl"}

<h1>{$header}</h1>

<div class="row">
    <form role="form" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Наименование</label>
            <input type="text" name="name" class="form-control" value="{if isset($name)}{$name}{/if}" placeholder="Наименование бренда">
            <input type="hidden" name="id" value="{if isset($id)}{$id}{/if}">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>

{include file="footer.tpl"}