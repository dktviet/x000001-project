<?
$sql="select * from xteam_category where status=0 and system=0 and parent=8 order by sort asc";
$result=mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result))
{
	$sp=$row["name"];
	$sqlparen = "select * from xteam_category where parent='".$row['id']."' and status=0 order by sort asc";
	$resultparen = mysql_query($sqlparen,$conn);
	$childcategory = countRecord("xteam_category","parent=".$row["id"]." AND status=0");
	if($childcategory > 0){
		$parentid=getRecord("xteam_category",'id='.$_GET['cat']);
		?>
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
	<? } else {?>
		
	<li>
    	<a href="<?=$curHost.$row['id'].$row['subject']?>/2-<?=$row['name']?>.html">
        	<span class="l"></span><span class="r"></span><span class="t"><?=$sp?></span>
        </a>
    </li>
	<?
    } //end if
	?>
        
<? } //end while?>
