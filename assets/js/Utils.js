function logout(){
	$.ajax({
		url: '/UserController/logout',
		type: 'POST',
	}).done(function(res) {
		res = JSON.parse(res)
		Swal.fire(
			'Đăng xuất thành công!',
			res.message,
			'success'
		).then(function() {
			window.location.href = "/login";
		})
	}).fail(function(jqXHR, responseText, errorThrown) {
		res = JSON.parse(jqXHR.responseText)
		Swal.fire({
			title: 'Đăng xuất thất bại!',
			text: res.message,
			icon: 'error',
			confirmButtonText: 'OK'
		})
	})
}
function base_url() {
    return window.location.origin+'/';
}
function ts2dt(val){

	//get timezone
	var timezone = new Date().getTimezoneOffset();
	timezone = timezone * 60;
	val = val + timezone;

	var date = new Date(val*1000);
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	var hour = date.getHours();
	var minute = date.getMinutes();
	var second = date.getSeconds();
	if (day < 10) {
		day = '0' + day;
	}
	if (month < 10) {
		month = '0' + month;
	}
	if (hour < 10) {
		hour = '0' + hour;
	}
	if (minute < 10) {
		minute = '0' + minute;
	}
	if (second < 10) {
		second = '0' + second;
	}
	var dateTime = day + '/' + month + '/' + year + ' ' + hour + ':' + minute + ':' + second;
	return dateTime;
}

