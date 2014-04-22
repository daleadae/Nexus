function bottom_footer() {
	console.log('bottom footer');
    var footer_h = parseFloat($('#footer').height());
    $('#page-global').css('margin', '0 auto -'+footer_h+'px');
    $('#wrap_footer').css('height', footer_h+'px');
    $('#push').css('height', footer_h+'px');
}

bottom_footer();

window.onresize = bottom_footer;