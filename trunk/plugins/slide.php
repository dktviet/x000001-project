<?
$heightImage = 83;

$code = $_lang=='vn' ? "vn_slide" : "vn_slide";
$sql = "select * from bnk_content where status=0 and parent in (select id from bnk_content_category where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
$arrImage = array();
$arrLink = array();
while($row=mysql_fetch_assoc($result)){
	if($row['image']!=''){
		$arrImage[] = $row['image'];
		$arrLink[] = $row['code'];
	}
}
$strImage = implode(',',$arrImage);
$strLink = implode(',',$arrLink);
?>

<script type="text/javascript" language="javascript">
var iedom=document.all||document.getElementById;																													
var sliderwidth="100%";
var sliderheight="<?=$heightImage?>";
var slidespeed=1;
slidebgcolor="";
var leftrightslide=new Array();
var finalslide='';
var i=0;
</script>

<script type="text/javascript" language="javascript">
var strImage = '<?=$strImage?>';
var strLink = '<?=$strLink?>';
arrImage = strImage.split(',');
arrLink = strLink.split(',');

for(var ij=0; i<arrImage.length; ij++){
	leftrightslide[i++]='<a href="' + arrLink[ij] + '" target="_blank"><img src="' + arrImage[ij] + '" height="<?=$heightImage?>" hspace="5" border="0"/></a>';
}
</script>

<script type="text/javascript" language="javascript">
var imagegap="";
var slideshowgap=0;
var copyspeed2=slidespeed;
leftrightslide='<nobr>'+leftrightslide.join(imagegap)+'</nobr>';
if(iedom){
document.write('<span id="temp" style="visibility:hidden;position:absolute;top:0px;left:0px;width:' + sliderwidth + '>'+leftrightslide+'</span>');
}
var actualwidth='';
var cross_slide, ns_slide;

document.open();

with (document){
if (iedom){

write('<div style="position:relative;left:2px;width:'+sliderwidth+';height:'+sliderheight+';overflow:hidden">');
write('<div style="position:absolute;width:'+sliderwidth+';height:'+sliderheight+';background-color:'+slidebgcolor+'" onMouseover="copyspeed2=0" onMouseout="copyspeed2=slidespeed">');
write('<div id="test2" style="position:absolute;left:0px;top:0px"></div>');
write('<div id="test3" style="position:absolute;left:0px;top:0px"></div>');
write('</div></div>');
}
else if (document.layers){
write('<ilayer align=center left=2px width='+sliderwidth+' height='+sliderheight+' name="ns_slidemenu" bgColor='+slidebgcolor+'>');
write('<layer name="ns_slidemenu2" left=0 top=0 onMouseover="copyspeed2=0" onMouseout="copyspeed2=slidespeed"></layer>');
write('<layer name="ns_slidemenu3" left=0 top=0 onMouseover="copyspeed2=0" onMouseout="copyspeed2=slidespeed"></layer>');
write('</ilayer>');
}

}
document.close();
window.onload=startSlide;

function startSlide(){
fillup();
}
</script>