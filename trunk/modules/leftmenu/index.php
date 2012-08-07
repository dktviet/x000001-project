<ul class="art-vmenu">
<?
$sql="select * from bnk_product_category where status=0 and system=0 and parent=1 order by sort asc";

$result=mysql_query($sql,$conn);
	
while($row=mysql_fetch_assoc($result))
{
	
	$sp=$row["name"];
	
	$sqlparen = "select * from bnk_product_category where parent='".$row['id']."' and status=0 order by sort asc";
	$resultparen = mysql_query($sqlparen,$conn);
	$childcategory = countRecord("bnk_product_category","parent=".$row["id"]." AND status=0");
	if($childcategory > 0){
		$parentid=getRecord("bnk_product_category",'id='.$_GET['cat']);?>
	<li>
    	<a href="<?=$curHost.$row['id'].str_replace(' ','-',$row['subject'])?>/4-<?=str_replace(' ','-',$row['name'])?>.html" <?=$row['id']==$parentid['parent'] ? "class='active'" : "";?>>
        	<span class="l"></span><span class="r"></span><span class="t"><?=$sp?></span>
       	</a>
		<ul <?=$row['id']==$parentid['parent'] && $frame=='product' ? "class='active'" : "";?>>
	  
	<? 
		while($rowcat = mysql_fetch_assoc($resultparen)) {
		
			$spname = $rowcat["name"];?>
			
			<li>
            	<a href="<?=$curHost.$rowcat['id'].str_replace(' ','-',$rowcat['subject'])?>/7-<?=str_replace(' ','-',$rowcat['name'])?>.html">
                	<?=$spname?>
                </a>
            </li>
		
		<? } //end while?>
        </ul>
    </li>
    <li class="art-vmenu-separator">
    	<span class="art-vmenu-separator-span"> </span>
    </li>
	<? } else {?>
		
	<li>
    	<a href="<?=$curHost.$row['id']?>/7-<?=$row['name']?>.html">
        	<span class="l"></span><span class="r"></span><span class="t"><?=$sp?></span>
        </a>
    </li>
    <li class="art-vmenu-separator">
    	<span class="art-vmenu-separator-span"> </span>
    </li>
	<?
    } //end if
	?>
        
<? } //end while?>
</ul>
