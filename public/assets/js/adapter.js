function pageResizer() {
	var body = document.body;
    var html = document.documentElement;
    //var maxHeight = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );	
	var hgt = window.innerHeight;
	//$('.hamburgerMenu').attr('style', 'height: '+hgt+'px;');
	$( window ).resize(function() {
		//$('.hamburgerMenu').attr('style', 'height: '+window.innerHeight+'px');

		if (window.innerWidth >= 770) {
			$(".hamburger").removeAttr("style");
			$(".hamburger").attr("style", 'padding-left: 0px;');
		} else {
			// handled in media queries
		}	
	});
}