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
  top: 30px;
  height: 92.38px;
  margin: 46.19px 0;
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
            font-size: 22px;
            margin: 50px 0 30px;
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
    .partners a {
        display: block;
        font-style: italic;
        color: #51a15c;
        font-size: 14px;
        padding-top: 10px;
    }

</style>

<article class="inner">
    <div class="partners">
        <div class="column left">
            <a href="{if isset($version)}/{$version}{/if}/about#employees" class="back">Назад</a>
            <div class="hexagon-partner" style="background-{if $employee.photo != ''}image: url('/upload/employeesPhotos/{$employee.photo}'){else}color: #8dc63f{/if};">
                <div class="hexTop"></div>
                <div class="hexBottom"></div>
            </div>            
        </div>
        <div class="column right">
            <span class="partner-name">{$employee.name}</span>
            {$employee.description}
        </div>
    </div>
</article>

{include 'footer.tpl'}