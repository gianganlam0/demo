$(document).ready(function() {
	//get location
    if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(
			function(position){
				x=position.coords.latitude;
				y=position.coords.longitude;
				// alert("User denied the request for Geolocation.")
			}
		,
			function(error) {
				switch(error.code) {
					case error.PERMISSION_DENIED:
						// alert("User denied the request for Geolocation.")
						break;
					case error.POSITION_UNAVAILABLE:
						// alert("Location information is unavailable.")
						break;
					case error.TIMEOUT:
						// alert("The request to get user location timed out.")
						break;
					case error.UNKNOWN_ERROR:
						// alert("An unknown error occurred.")
						break;
				}
			}
		)
	}
	else{
		console.log("Trình duyệt của bạn không hỗ trợ lấy vị trí");
	}

	form = $('#info-form');
	form.kendoForm({
		items: [{
			field: "email",
			label: 'Email',
			validation: {
				required: {
					message: "Email không được để trống"
				},
				email: {
					message: "Email không đúng định dạng"
				}
			},
			attributes: {
				oninput: "vali()",
			}
		},{
			field: "fullname",
			label: 'Họ và tên',
			validation: {
				required: {
					message: "Họ và tên không được để trống"
				},
			},
		},{
			field: "sex",
			label: 'Giới tính',
			editor: 'DropDownList',
			validation: {
				required: {
					message: "Giới tính không được để trống"
				}
			},
			editorOptions: {
				dataSource: [
					{ text: "Nam", value: 0 },
					{ text: "Nữ", value: 1 },
					{ text: "Khác", value: 2 }
				],
				dataTextField: "text",
				dataValueField: "value",
				valuePrimitive: true,
				optionLabel: "Chọn giới tính",
			}
		},{
			field: "age",
			label: 'Tuổi',
			attributes: {
				type: "number",
				oninput: "vali()",
			},
			validation: {
				required: {
					message: "Tuổi không được để trống"
				},
				step:{
					message: "Tuổi phải là số nguyên",
					value: 1
				},
				min: {
					message: "Tuổi phải lớn hơn 10",
					value: 11
				},
				max: {
					message: "Tuổi không được lớn hơn 150",
					value: 150
				}
			},	
		},{
			field: "job",
			label: 'Nghề nghiệp',
			validation: {
				required: {
					message: "Nghề nghiệp không được để trống"
				},
			},
			attributes: {
				oninput: "vali()",
			}
		}
	],
		buttonsTemplate:
		'<button id="submit-btn" disabled class="btn btn-primary">Gửi</button>',
		submit: handleSubmit
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
	e.model['latitude']=x;
	e.model['longitude']=y;
	$.ajax({
		url: "/usercontroller/register",
		type: "post",
		data: e.model,
		beforeSend: function() {
			Swal.fire({
				text: "Đã gửi đăng ký",
				icon: "info",
				timer: 1000
			})
		}
	}).done(function resp(res) {
		res = JSON.parse(res)
		Swal.fire({
			title: 'Đã gửi email xác nhận, vui lòng kiểm tra email',
			text: res.message,
			icon: 'success',
			confirmButtonText: 'OK'
		})
	}).fail(function(jqXHR, responseText, errorThrown) {
		res = JSON.parse(jqXHR.responseText)
		Swal.fire({
			title: 'Gửi email xác nhận thất bại',
			text: res.message,
			icon: 'error',
			confirmButtonText: 'OK'
		})
	})

}
