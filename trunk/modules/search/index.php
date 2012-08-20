<?
//xác định dang mục cha
$parent_id = getRecord('xteam_category', 'code="product"');
$parents = getArray('xteam_category','parent_id='.$parent_id['id']);
$parname = array();
$parid = array();
foreach ($parents as $parent){
    $parname[$parent['id']] = $parent['name'];
    $parid[$parent['id']] = $parent['id'];
}
//lọc dữ liệu từ máy chủ
$arry_get = $_REQUEST;
$newarray = array();
for($i=0; $i<=5;$i++){
    if($i>=1) array_push($newarray,key($arry_get));
    next($arry_get);
}
foreach ($newarray as $item){
    if($_POST[$item])
        $where_in .= killInjection ($_POST[$item]).',';
}
//điều kiện lọc
$where_in = 'properties_id IN ('.substr($where_in,0,-1).')';
$result = mysql_query("SELECT prod.*
    FROM xteam_product prod
    INNER JOIN xteam_product_extend ext
    ON prod.id = ext.product_id
    WHERE ".$where_in);
$num=0;
while($row=mysql_fetch_assoc($result)){
    $num++;
    $class = $num%2==0? "block-left":"block-right";
    if($parid[$top_pro[$i]['parent_id']]%2==0){$class_sp="rental";}else{$class_sp="salse";}?>
        <div class="block-news">
            <div class="<?=$class?>">
                <h3 class="title-news">
                    <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" >
                        <span class="<?=$class_sp?>"><?=$parname[$row['parent_id']]?> | </span><?=catchu($row['name'],40)?>
                    </a>
                </h3>
                <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" >
                    <img class="img-news" src="<?=$curHost?><?=$row['image']?>" title="<?=$row['name']?>" alt="<?=$row['name']?>" />
                </a>
                <div class="short-news">
                    <?=catchu(strip_tags($row['detail_short']),200)?>
                </div>
            </div>
    <? if($num%2==0){echo '<div class="clear"></div></div><div class="block-news">'; }?>
<? }?>
        </div>
<div class="cleared"></div>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		var contentdiv = $('.block-news').text(function(){
			if ($.trim($(this).text())==''){
				$(this).hide();
			}
			});

	})
</script>