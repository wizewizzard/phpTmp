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
.even .emptyHexagon{

}
.odd .emptyHexagon{

}
.gray{
    background: #444;
}
.grassyGreen{
    background: rgb(60, 181, 114);
}
.lightGray{
    background: rgba(238, 238, 238, 1);
}
.lightGreen{
    background: rgb(121, 214, 91);
}
.white{
    background: rgb(255, 255, 255);
}
.textEye{
    position: absolute;
    left:57px;
    top: 95px;
    background: url('/images/eye.png');
    background-size: 100% 100%;
    z-index: 1024;
    width: 18px;
    height: 9px;
}
.textHexagon{
    word-wrap: break-word;
}
.textHexagon .hexContent .hexBottom .hexTop{
    opacity: 1.0;
    background: none;
}
.textHexagon .hexContent{
    padding-left:5px;
    padding-right:5px;
    font-size: 14px;
}
</style>

<nav class="inner tabs objectMenu">
    <a href="0">Все</a>
    <a href="1">Жилые дома</a>
    <a href="2">Торговые центры</a>
    <a href="3">Административные здания</a>
</nav>
<article class="inner" style="margin-bottom: 40px;">
    {assign var=even value=1}
    {assign var=rowStart value=0}
    {assign var=rowsEvenUnevenNum value=$hexagonUnevenRowNum + $hexagonEvenRowNum}
    {assign var=currentRow value=0}
    {for $i = 0 to $hexagonsNum - 1}
        {assign var=count value=$count+1}
        {if $i == 0 }
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

        {assign var=class value='white'}
        {if !isset($hexagonsPhoto[$i]) && !isset($hexagonsText[$i])}
            {assign var=random value=1|rand:2}
            {if $random == 1 }
                {$class='white'}
            {elseif $random == 2}
                {$class='lightGray'}
            {/if}
            <div class="hexagon emptyHexagon {$class}">
                <div class="hexTop"></div>
                <div class="hexBottom"></div>
            </div>
        {elseif isset($hexagonsPhoto[$i])}
            <div class="hexagon photoHexagon" style="background-image: url('{if $hexagonsPhoto[$i].photo != ''}{$hexagonsPhoto[$i].photo}{/if}');" data-category="{if isset($hexagonsPhoto[$i].category) && $hexagonsPhoto[$i].category != ''}{$hexagonsPhoto[$i].category}{/if}">
                <div class="hexTop"></div>
                <div class="hexContent">{$hexagonsPhoto[$i].name}</div>
                <div class="hexBottom"></div>
            </div>
        {elseif isset($hexagonsText[$i])}
            {assign var=random value=1|rand:3}
            {if $random == 1 }
                {$class='lightGreen'}
            {elseif $random == 2}
                {$class='grassyGreen'}
            {else}
                {$class='gray'}
            {/if}
            <a href="{$hexagonsText[$i].link}" class="hexagon textHexagon {$class}" data-category="{if isset($hexagonsText[$i].category) && $hexagonsText[$i].category != ''}{$hexagonsText[$i].category}{/if}">
                <div class="hexTop"></div>
                <div class="hexContent">
                    <div>{$hexagonsText[$i].brief_info}</div>
                </div>
                <div class="textEye"></div>
                <div class="hexBottom"></div>
            </a>
        {/if}
        {if $i == $hexagonsNum - 1}
            </div>
        {/if}
    {/for}
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
