{include file="header.tpl"}

{if $statusClass !== ''}
    <div class="row">
        <div class="col-xs-12 alert alert-{$statusClass}">
            {$statusMessage}
        </div>
    </div>
{/if}

<h1>Управление вступительным видео</h1>

<form  method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
        <label for="video" class="col-xs-12 col-md-2 control-label">Выберите файл</label>
        <div class="col-xs-12 col-md-10">
            <input type="file" id="video" name="video">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-md-2">
            <a href="/upload/video/intro.mp4" class="btn btn-info">Скачать текущее видео</a>
        </div>
        <div class="col-xs-12 col-md-10">
            <button type="submit" class="btn btn-success">Загрузить</button>
        </div>
    </div>
</form>


{include file="footer.tpl"}