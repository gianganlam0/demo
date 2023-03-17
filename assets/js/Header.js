$(document).ready(function () {
	//get list of a tag in nav
	aList = $('.nav').find('a');
	aList.each(function (i,e) {
		currUrl = window.location.href;
		currUrl = currUrl.replace(base_url(), '');
		url = $(e).attr('href');
		if (url == '/' && currUrl == '/') {//special case for home page
			$(e).addClass('selected');
			return
		}
		//if current url is contain url in first position
		if (currUrl.indexOf(url) == 0 && url != '/') {
			$(e).addClass('selected');
			return
		}
	});
});
