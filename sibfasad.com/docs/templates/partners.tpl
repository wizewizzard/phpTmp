{include 'header.tpl'}

<style>
article {
    padding-top: 60px;
}
.partners-desrc {
    margin-top: 40px;
    padding: 20px 60px;
    border-top: 1px solid #99cc53;
    font-size: 14px;
}
.hexTop,
.hexButton,
.hexagon {
    box-shadow: 3px 3px 5px #ccc;
    background-color: #fff;
}
</style>
<article class="inner">

{foreach $partners as $id => $data}
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
    <a href="/partners/view/{$id}" {if $data.logo != ''} data-logo="/upload/partnerPhotos/{$data.logo}"{/if} {if $data.photo != ''} data-replacement="{$data.photo}"{/if} class="hexagon partner" {if $data.logo != ''}style="background-image: url(/upload/partnerPhotos/{$data.logo});"{/if}>
        <div class="hexTop"></div>
        <div class="hexContent"><h3>{$data.name}</h3></div>
        <div class="hexBottom"></div>
    </a>
    {if $data@last}
        </div>
    {/if}
{/foreach}
</article>
<script>
    $(document).ready(function() {
        $('.partner').bind('mouseenter', function () {
            var imgPath = $(this).data('replacement');
            if (typeof imgPath != 'undefined'){
                $(this).css('background-image', 'url(' + imgPath + ')');
                $(this).removeClass('partner');
            }

        });
        $('.partner').bind('mouseleave', function () {
            var imgPath = $(this).data('logo');
            if (typeof imgPath != 'undefined'){
                $(this).css('background-image', 'url(' + imgPath + ')');

                $(this).addClass('partner');
            }
            else
                $(this).css('background-image', 'none');

        });
    });
</script>
{include 'footer.tpl'}
