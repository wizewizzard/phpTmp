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
    font-weight: 300;
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
.hexagon {
    background-color: #ccc;
    -webkit-transition: linear .3s;
            transition: linear .3s;
}
    .fade {
        opacity: 0.2;
        -webkit-transition: linear .3s;
                transition: linear .3s;
    }

</style>

<nav class="inner tabs objectMenu">
    <a href="0">Все</a>
    <a href="1">Жилые дома</a>
    <a href="2">Торговые центры</a>
    <a href="3">Административные здания</a>
</nav>
<article class="inner" style="margin-bottom: 40px;">
    {foreach $objects as $id => $data}
        {assign var=count value=$count+1}
        {if $data@first}
            {assign var=even value=1}
            {assign var=count value=0}
            <div class="even">
        {/if}
        {if $even == 0 and $count == 6}
            {assign var=even value=1}
            {assign var=count value=0}
            </div>
            <div class="even">
        {/if}
        {if $even == 1 and $count == 7}
            {assign var=even value=0}
            {assign var=count value=0}
            </div>
            <div class="odd">
        {/if}
        <a href="/objects/view/{$id}" class="hexagon" data-category="{if isset($data.category) && $data.category != ''}{$data.category}{/if}" {if isset($data.photo) && $data.photo != ''}style="background-image: url(/upload/objectPhotos/thumbs/{$data.photo});"{/if}>
            <div class="hexTop"></div>
            <div class="hexContent"><h3>{$data.name}</h3></div>
            <div class="hexBottom"></div>
        </a>
        {if $data@last}
            </div>
        {/if}
    {/foreach}
</article>

{include 'footer.tpl'}

<script type="text/javascript">
$(function () {
    $('.objectMenu > a').click(function() {
        var
            $id = $(this).attr('href'),
            $hexagons = $('.hexagon'),
            $hexagonsCat = $('.hexagon[data-category="' + $id + '"]');

        if ($id == 0) {
            $hexagons.removeClass('fade');

            return false;
        }  
        $hexagons.addClass('fade');
        $hexagonsCat.removeClass('fade');

        return false;
    });
});
</script>
