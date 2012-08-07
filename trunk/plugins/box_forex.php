<script language="javascript" src="http://www.vnexpress.net/Service/Forex_Content.js"></script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="xam">
<?
$i=0;
while($i<3){

	$vForex = 'vForexs['.$i.']';

	$vCost = 'vCosts['.$i++.']';

	?>

	<tr>

		  <td width="48%" ><div align="center" class="style3">

			<script language="javascript">document.write(<?=$vForex?>);</script></div></td>

		 <td width="52%" height="17" ><div align="center" class="style3">
			<script language="javascript">document.write(<?=$vCost?>);</script></div></td>

	</tr>

	

	<?

}

?>

</table>

