<script type="text/javascript" language="javascript">
function btnSearchGoogle_onclick(){
	if(test_empty(document.frmSearchGoogle.q.value)){
		alert(mustInput_Search);document.frmSearchGoogle.q.focus();return false;
	}
	document.frmSearchGoogle.submit();
	return true;
}
</script>
<table align="center" width="95%" border="0" bordercolor="#003399" cellpadding="0" cellspacing="0">
<form name="frmSearchGoogle" action="http://www.google.com.vn/custom" target="google_window" method="GET">
	<tr>
		<td><input type="text" name="q" id="sbi" style="width:90"/></td>
		<td><input type="button" name="btnSearchGoogle" value="<?=_SEARCH?>" onclick="return btnSearchGoogle_onclick()"></td>
	</tr>
</form>
</table>