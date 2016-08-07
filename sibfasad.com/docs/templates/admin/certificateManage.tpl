{include file="header.tpl"}

<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Название</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$certificate.name}" placeholder="Название диплома">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузить диплом</label>
            <div class="col-sm-10">
                <input type="file" name="photo">
                {if isset($certificate.photo) and $certificate.photo != ''}
                    <img style="max-height: 300px; margin: 5px;" src="/upload/certificates/thumbs/{$certificate.photo}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
</div>

{include file="footer.tpl"}