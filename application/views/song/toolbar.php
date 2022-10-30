<div class="btn-toolbar">
<div class="btn-group">
	<button class="btn" onclick="location.href='/category/add/<?php echo $id?>'"><i class="icon-plus"></i>Добавить категорию</button>
</div>
<div class="btn-group">
	<button class="btn dropdown-toggle" data-toggle="dropdown" onclick="getCategoryList()">Переместить в <span class="caret"></span></button>
	<ul id="movetolist" class="dropdown-menu" role="dropdown" aria-labelledby="dLabel">
	</ul>
</div>
</div>
<script type="text/javascript">


function getCategoryList(){
	var list=$('#movetolist');
	
	if(!list.hasClass('loaded')){
		$.getJSON('/category/json', function(data) {
					//	  html+='<li><a href="/category/moveto/' + key + '" >' + val.name + '</a></li>';
			var getLI=function(key, val){
			  	if(val.childs != undefined){
				  	var submenu='';
				  	for(var i = 0; i < val.childs.length; i++){
					  	var child_id=val.childs[i];
					  	submenu+=getLI(child_id,data[child_id]);
					}
					return '<li class="dropdown-submenu"><a href="/category/moveto/' + key + '">' + val.name + '</a><ul class="dropdown-menu">'+submenu+'</ul></li>';	  	
				}
				else{
			  		return '<li><a href="/category/moveto/' + key + '">' + val.name + '</a></li>';
				}
			}
			$.each(data, function(key, val) {
				if(val.parent_id != null){
					
					if(data[val.parent_id].childs == undefined){
						data[val.parent_id].childs=[];
					}
					data[val.parent_id].childs.push(key);
				}
			});
		  	console.log(data);	
		  	
		  	var html = '';
		  	$.each(data, function(key, val) {
			  	if(val.parent_id != null){
				  	return false;
				}
			  	html+=getLI(key,val);
		  	});
			
			$(html).appendTo(list);
			list.addClass('loaded'); 
			list.find('a').click(function(event){
				event.preventDefault();
				$('#categorylist').attr('action',$(this).attr('href')).submit();
				return false;
			});
			//$('.dropdown-submenu').dropdown();
		});
	}
}
</script>
        
    