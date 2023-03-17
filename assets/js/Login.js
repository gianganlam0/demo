//bind enter key with submit button
$(document).ready(function() {
	form = $('#login-form');
	form.kendoForm({
		items: [{
			field: "username",
			label: 'Tên đăng nhập',
			validation: {
				required: {
					message: "Tên đăng nhập không được để trống"
				}
			},
			attributes: {
				oninput: "vali()",
			}
		}, {
			field: "password",
			label: 'Mật khẩu',
			attributes: {
				type: "password",
				oninput: "vali()",
			},
			validation: {
				required: {
					message: "Mật khẩu không được để trống"
				}
			}
		},{
			field: "show-password",
			label: '',
            editor:'<button id="toggle-btn"></button>'
		}],
		buttonsTemplate:
		'<button id="submit-btn" disabled class="btn btn-primary">Đăng nhập</button>',
		submit: handleSubmit

	})
	$("#toggle-btn").kendoButton({
		icon: "eye",
		click: function(e) {
			var input = $("#password");
			if (input.attr("type") == "password") {
				input.attr("type", "text");
				$("#toggle-btn").removeClass("eye");
				$("#toggle-btn").addClass("eye-slash");
			}
			else {
				input.attr("type", "password");
				$("#toggle-btn").removeClass("eye-slash");
				$("#toggle-btn").addClass("eye");
			}
		},
		themeColor: "success"
	})

});
function vali(e){
	validator = form.data("kendoValidator");
	if (validator.validate()) {
		$("#submit-btn").removeAttr("disabled");
	}
	else {
		$("#submit-btn").attr("disabled", true);
	}
}
function handleSubmit(e) {
	e.preventDefault();

	$.ajax({
		url: "/usercontroller/auth",
		type: "post",
		data: e.model,
		// beforeSend: function() {}
	}).done(function(res) {
		res = JSON.parse(res)
		Swal.fire(
			'Đăng nhập thành công!',
			res.message,
			'success'
		).then(function() {
			window.location.href = "/admin/dashboard";
		})
	}).fail(function(jqXHR, responseText, errorThrown) {
		res = JSON.parse(jqXHR.responseText)
		Swal.fire({
			title: 'Đăng nhập thất bại!',
			text: res.message,
			icon: 'error',
			confirmButtonText: 'OK'
		})
	})

}
