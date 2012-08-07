<!--<script type="text/javascript" language="javascript" src="<?=CUR_HOST?>plugins/box_search/search_script.js"></script>
-->
<?
	$post_tit = lang_change('Bài viết','Posts');
	$project_tit = lang_change('Dự án','Projects');
	$game_tit = lang_change('Game','Games');
	$news_tit = lang_change('Tin tức','News');
?>
<form id="formSearch" class="search" name="formSearch" method="post" action="<?=CUR_HOST.utf8_to_ascii(_SEARCH_BTN).'.html'?>">
	<div class="sp-label">
		<label for="sp-searchtext">Search</label>
		<input type="text" name="keyword" id="sp-searchtext" accesskey="s" value="" />
	</div>
    <!--<div class="search_bar_check">
    	<div>
            <input id="type_search_1" type="radio" name="type_search" class="styled" value="1" /> <span id="type_1"><?=$post_tit?></span>
    	</div>
    	<div>
            <input id="type_search_2" type="radio" name="type_search" class="styled" value="2" /> <span id="type_2"><?=$project_tit?></span>
    	</div>
    	<div>
            <input id="type_search_3" type="radio" name="type_search" class="styled" value="3" /> <span id="type_3"><?=$game_tit?></span>
    	</div>
    	<div>
            <input id="type_search_4" type="radio" name="type_search" class="styled" value="4" checked="checked" /> <span id="type_4"><?=$news_tit?></span>
    	</div>
	</div>
--></form>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$('#search_submit').click(function() {
		location.formSearch.submit();
	});
});
</script>
