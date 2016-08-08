{include 'header.tpl'}

<style>
.partner-logo-wrap {
    text-align: right;
    margin: 15px 0 20px;
}
    .partner-logo-wrap img {
        height: 80px;
    }
.hexagon-partner {
  position: relative;
  width: 160px;
  top: -45px;
  height: 92.38px;
  margin: 46.19px 0;
  background-image: url('/images/face6.jpg');
  background-size: auto 184.7521px;
  background-position: center;
}
    .hexagon-partner .hexTop,
    .hexagon-partner .hexBottom {
      position: absolute;
      z-index: 1;
      width: 113.14px;
      height: 113.14px;
      overflow: hidden;
      -webkit-transform: scaleY(0.5774) rotate(-45deg);
      -ms-transform: scaleY(0.5774) rotate(-45deg);
      transform: scaleY(0.5774) rotate(-45deg);
      background: inherit;
      left: 23.43px;
    }

    /*counter transform the bg image on the caps*/
    .hexagon-partner .hexTop:after,
    .hexagon-partner .hexBottom:after {
      content: "";
      position: absolute;
      width: 160.0000px;
      height: 92.37604307034013px;
      -webkit-transform:  rotate(45deg) scaleY(1.7321) translateY(-46.1880px);
      -ms-transform:      rotate(45deg) scaleY(1.7321) translateY(-46.1880px);
      transform:          rotate(45deg) scaleY(1.7321) translateY(-46.1880px);
      -webkit-transform-origin: 0 0;
      -ms-transform-origin: 0 0;
      transform-origin: 0 0;
      background: inherit;
    }

    .hexagon-partner .hexTop {
      top: -56.5685px;
    }

    .hexagon-partner .hexTop:after {
      background-position: center top;
    }

    .hexagon-partner .hexBottom {
      bottom: -56.5685px;
    }

    .hexagon-partner .hexBottom:after {
      background-position: center bottom;
    }

    .hexagon-partner .hexagon:after {
      content: "";
      position: absolute;
      top: 0.0000px;
      left: 0;
      width: 160.0000px;
      height: 92.3760px;
      z-index: 2;
      background: inherit;
    }
.partners {
    display: table;
    margin-bottom: 50px;
}
    .partners .column {
        display: table-cell;
        height: 100%;
        vertical-align: top;
    }
    .partners .column.left {
        width: 230px;
        padding: 0 10px 0 50px;
        color: #888;
        font-size: 12px;        
    }
        .partners .column.left .company-link {
            display: block;
            margin: 10px 0;
            color: #8dc63f;
        }
    .partners .column.right {
        padding: 0 50px 0 10px;
    }
        .partners .column.right .partner-name {
            display: block;
            font-weight: 900;
            font-style: italic;
            font-size: 14px;
            margin: 20px 0 30px;
        }
        .partners .column.right p {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .partners .column.right .photo span {
            display: block;
            color: #888;
            font-size: 12px;
            height: 30px;
            line-height: 30px;
        }
        .partners .column.right .first.photo {
            float: left;
            margin-right: 20px;
        }
        .partners .column.right .second.photo {
            float: right;
            margin-left: 20px;
        }
.projects {
    font-size: 14px;
    padding: 20px 0 40px 250px;
    margin-bottom: 100px;
}
.projects .successful-projects {
    color: #aed580;
    font-size: 24px;
    font-weight: 900;
    margin: 10px 0;
}
.projects hr {
    width: 940px;
    height: 0;
    border: 0;
    margin-left: -250px;
    padding: 10px 0;
    border-top: 1px solid #99cc53;
}
.objectSlider li {
    text-align: center;
}
    .objectSlider li > a {
        text-align: left;
    }
.objectSlider li > div {
    margin-left: 20px;
    margin-right: 20px;
}
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
.otherPartners {
    height: 300px;
    border-top: 2px solid #51a15c;
}
    .otherPartners > h3 {
        font-weight: 700;
        font-style: italic;
        margin: 20px 0;
        font-size: 14px;
        text-align: left;
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

</style>

<article class="inner">

        {if isset($partner.logo) && $partner.logo != ''}
            <div class="partner-logo-wrap">
            {if $partner.url != ''}
                <a href="{$partner.url}" class="company-link"><img src="/upload/partnerPhotos/{$partner.logo}" /></a>
            {else}
                <img src="/upload/partnerPhotos/{$partner.logo}" />
            {/if}
            </div>
        {/if}

    <div class="partners">
        <div class="column left">
            <div class="hexagon-partner" style="background-image: url('{if $partner.photo != ''}/upload/partnerPhotos/{$partner.photo}{else}/images/nophoto.png{/if}');">
                <div class="hexTop"></div>
                <div class="hexContent"></div>
                <div class="hexBottom"></div>
            </div>
            <p>
                {$partner.comment}


            </p>
        </div>
        <div class="column right">
            <span class="partner-name">{$partner.photoLabel}</span>
            {$partner.description}
        </div>
    </div>
    <div class="otherObjects">
        <h3>Объекты партнера</h3>
        <ul class="objectSlider">
            <li>
                {foreach $objects as $id => $data}
                    {if $count == 6}
                        </li>
                        <li>
                        {assign var=count value=0}
                    {/if}
                    {assign var=count value=$count+1}
                    <a href="/objects/view/{$id}" class="hexagon" data-category="{if isset($data.category) && $data.category != ''}{$data.category}{/if}" {if isset($data.photo) && $data.photo != ''}style="background-image: url(/upload/objectPhotos/thumbs/{$data.photo});"{/if}>
                        <div class="hexTop"></div>
                        <div class="hexContent"><h3>{$data.name}</h3></div>
                        <div class="hexBottom"></div>
                    </a>
                {/foreach}
            </li>
        </ul>
    </div>
</article>

{include 'footer.tpl'}