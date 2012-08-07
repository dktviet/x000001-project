
$(document).ready(function() {
// For menu left BEGIN
	$('#menu_item1').click(function() {
		$('#menu_item1 ul').slideToggle();
		$('#menu_item2 ul').slideUp();
		$('#menu_item3 ul').slideUp();
		$('#menu_item4 ul').slideUp();
		$('#menu_item5 ul').slideUp();
	});
	$('#menu_item2').click(function() {
		$('#menu_item2 ul').slideToggle();
		$('#menu_item1 ul').slideUp();
		$('#menu_item3 ul').slideUp();
		$('#menu_item4 ul').slideUp();
		$('#menu_item5 ul').slideUp();
	});
	$('#menu_item3').click(function() {
		$('#menu_item3 ul').slideToggle();
		$('#menu_item2 ul').slideUp();
		$('#menu_item1 ul').slideUp();
		$('#menu_item4 ul').slideUp();
		$('#menu_item5 ul').slideUp();
	});
	$('#menu_item4').click(function() {
		$('#menu_item4 ul').slideToggle();
		$('#menu_item2 ul').slideUp();
		$('#menu_item3 ul').slideUp();
		$('#menu_item1 ul').slideUp();
		$('#menu_item5 ul').slideUp();
	});
	$('#menu_item5').click(function() {
		$('#menu_item5 ul').slideToggle();
		$('#menu_item2 ul').slideUp();
		$('#menu_item3 ul').slideUp();
		$('#menu_item4 ul').slideUp();
		$('#menu_item1 ul').slideUp();
	});
	$('#menu_item1 #opened').slideToggle();
	$('#menu_item2 #opened').slideToggle();
	$('#menu_item3 #opened').slideToggle();
	$('#menu_item4 #opened').slideToggle();
	$('#menu_item5 #opened').slideToggle();
// For menu left END

// Display and Hide Eng block BEGIN
	$('#short_en_show').hide();
	$('#long_en_show').hide();
	$('#short_en_call input').click(function() {
		$('#short_en_show').slideToggle('slow');
	});
	$('#long_en_call input').click(function() {
		$('#long_en_show').slideToggle('slow');
	});
// Display and Hide Eng block END

});


