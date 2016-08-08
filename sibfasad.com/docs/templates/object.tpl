{include 'header.tpl'}

<style>
article {
    padding-top: 40px;
}
.objectMenu {
    padding-top: 15px;
    padding-left: 0!important;
}
.objectSubmenu {
    width: 825px;
    border-top: 1px solid #888;
    line-height: 30px;
}
    .objectSubmenu a {
        font-size: 14px;
        margin-right: 26px;
        color: #888;
        text-decoration: none;
    }
    .objectSubmenu a:last-child {
        margin-right: 0;
    }
nav.tabs {
    padding-left: 0;
}
.objectInfo {
    font-size: 14px;
    padding: 10px 50px;

}
    .objectInfo a {
        text-decoration: none!important;
        border-bottom: 1px dashed #99cc53;
    }
        .objectInfo a.active {
            border-bottom: 1px solid #99cc53;
        }
    .objectInfo .tab-content {
        padding: 20px 0;
    }
.otherObjects {
    height: 300px;
    border-top: 1px solid #99cc53;
}
    .otherObjects > h3 {
        font-weight: 700;
        font-style: italic;
        margin: 20px 0;
        font-size: 14px;
        text-align: left;
    }

/*//////////*/
.bx-wrapper .bx-prev {
    left: 0;
    background: url('/images/controls-green.png');
}
.bx-wrapper .bx-next {
    right: 0;
    background: url('/images/controls-green.png') -24px 0;
}
.bx-wrapper .bx-controls-direction a {
    top: -70px;
    width: 24px;
    height: 24px;
}
.objectSlider li {
    text-align: center;
}
.objectSlider li > div {
    margin-left: 20px;
    margin-right: 20px;
}
.index h3 {
    color: #aed580;
    font-size: 24px;
    font-weight: 900;
    margin: 40px 0 20px;
}
.hexagon {
    position: relative!important;
    text-align: left;
}
    .hexagon:hover {
        cursor: pointer;
    }
.galleria-theme-classic .galleria-image-nav-left,
.galleria-theme-classic .galleria-image-nav-right {
    height: 37px;
    background: #89c557 url('/images/controls.png') no-repeat;
    border-radius: 20px;
    border: 1px solid #89c557;
}
.galleria-theme-classic .galleria-image-nav-right {
    background-position: -37px 0;
}
.galleria-thumbnails-container {
    text-align: center;
}
.galleria-thumbnails-list {
    display: inline-block;
    margin: 0 auto;
}
</style>
<article class="inner">
    <h1 style="font-size: 40px; font-weight: 500; color: #777; font-style: italic;">{$object.name}</h1>
    <div id="galleria" style="height: 600px; background: #eee">
        {foreach $object.photos as $id => $data}
        <a href="/upload/objectPhotos/{$data}"><img height="70px" src="/upload/objectPhotos/{$data}"></a>
        {/foreach}
    </div>

    <div class="objectInfo">
        <nav class="inner tabs">
            <a href="#description" class="active">Описание</a>
            <a href="#participants">Участники</a>
            <a href="#tech">Технологии</a>
            <a href="#projec">Проект</a>
        </nav>
        <div class="tabs-content">
            <div rel="#description" class="tab-content show">
                {$object.description}
            </div>
            <div rel="#participants" class="tab-content">
                {$object.participiants}
            </div>
            <div rel="#tech" class="tab-content">
                {$object.technologies}
            </div>
            <div rel="#projec" class="tab-content">
                {foreach $object.pdf_files as $id => $data}
                    <a href="/file/load/{$data}">{$data}</a>
                {/foreach}
            </div>
        </div>
    </div>
    <div class="otherObjects">
        <h3>Остальные объекты</h3>
        <ul class="objectSlider">
            <li>
                {foreach $objects as $id => $data}
                    {if $count == 6}
                        </li>
                        <li>
                        {assign var=count value=0}
                    {/if}
                    {assign var=count value=$count+1}
                    <a href="/objects/view/{$id}" class="hexagon" {if isset($data.photo) && $data.photo != ''}style="background-image: url(/upload/objectPhotos/thumbs/{$data.photo});"{/if}>
                        <div class="hexTop"></div>
                        <div class="hexContent"><h3>{$data.name}</h3></div>
                        <div class="hexBottom"></div>
                    </a>
                {/foreach}
            </li>
        </ul>
    </div>
</article>

<script type="text/javascript">
    $(function () {
        Galleria.loadTheme('galleria/themes/classic/galleria.classic.min.js');
        Galleria.run('#galleria');
    });
</script>

{include 'footer.tpl'}
