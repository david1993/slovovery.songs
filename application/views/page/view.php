<dl class="dl-horizontal">
  <dt>Магазин:</dt>  <dd><?=$stock->store?></dd>
  <dt>Адрес:</dt> <dd><?=$stock->address?></dd>
  <dt>Телефон:</dt> <dd><?=$stock->phone?></dd>
</dl>
<p class="lead"><?=$stock->anons?></p>
<p><?= HTML::image('/images/mini/'.$stock->pic)?></p>
<p><?=$stock->content?></p>
        
    