$(document).ready(function() {
	$('#btnLogin').click(function() {
		var UidVal = $('#modlgn_username').val();
		var PassVal = $('#modlgn_passwd').val();
		if(test_empty(UidVal)){
			alert('Hãy nhập "tên đăng nhập" !');
			$('#modlgn_username').focus();return false;
		}
		if(test_empty(PassVal)){
			alert('Hãy nhập "mật khẩu" !');
			$('#modlgn_passwd').focus();return false;
		}
		$('#modlgn_passwd').val(hex_md5(PassVal));
		return true;
	});
});
function setFocus(){
    $('#modlgn_username').focus();
}