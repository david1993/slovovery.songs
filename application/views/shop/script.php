<?php if(isset($query_id)): ?>
	<script type="text/javascript" >showShops(0,'<?=$query_id?>');</script>
<?php endif ?>
<?php if(isset($shop_id)): ?>
	<script type="text/javascript" >showShop(<?=$shop_id?>);</script>
<?php endif ?>
<?php if(isset($init)): ?>
	<script type="text/javascript" >initialize();</script>
<?php endif ?>