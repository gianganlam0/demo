$(document).ready(function() {
	crudServiceBaseUrl = base_url()+'usercontroller';
	dataSource = new kendo.data.DataSource({
		transport: {
			read: {
				url: crudServiceBaseUrl + "/get",
				dataType: "json"
			}
		},
		schema: {
			data: function(res){
				res = res.data;
				//if res.sex ==0, change to "Nam"
				res.map(function(item){
					switch(item.sex){
						case 0:
							item.sex = "Nam";
							break;
						case 1:
							item.sex = "Nữ";
							break;
						default:
							item.sex = "Khác";
					}
					switch(item.activeCode){
						case null:
							item.activeCode = "Đã xác thực";
							break;
						default:
							item.activeCode = "Chưa xác thực";
					}
					if (item.sentMailTime != null) {
						item.sentMailTime = ts2dt(item.sentMailTime);
					}
					else item.sentMailTime = "Chưa gửi";
					if (item.openMailTime != null) {
						item.openMailTime = ts2dt(item.openMailTime);
					}
					else item.openMailTime = "Chưa mở";	
					if (item.downloadTime != null) {
						item.downloadTime = ts2dt(item.downloadTime);
					}
					else item.downloadTime = "Chưa tải";

				})
				return res
			}
		},
		batch: true,
		pageSize: 20,
		autoSync: true,
	});
	$("#grid").kendoGrid({
		dataSource: dataSource,
		height: 600,
		// columnMenu: {
		// 	filterable: false
		// },
		// editable: "incell",
		navigatable: true,
		resizable: true,
		toolbar: [
			{
				name: 'pdf',
				text: 'Xuất PDF'
			},
			{
				name: 'search',
				text: 'Tìm kiếm'
			}
		],
		reorderable: true,
		filterable: true,
		sortable: true,
		pageable: {
			refresh: true,
			pageSizes: true,
			buttonCount: 5,
			messages: {
				display: "Hiển thị {0}-{1} của {2} kết quả",
				empty: "Không có kết quả nào",
				page: "Trang",
				of: "của {0}",
				itemsPerPage: "kết quả/trang",
				first: "Trang đầu",
				last: "Trang cuối",
				next: "Trang sau",
				previous: "Trang trước",
				refresh: "Làm mới"
			}
		},
		groupable: {
			messages: {
				empty: "Kéo thả cột vào đây để nhóm theo cột đó"
			}
		},
		columns: [
			{field: "email", title: "email", width: 200 },
			{field: 'fullname', title: "Họ và tên", width: 150},
			{field: 'sex', title: "Giới tính", width: 50},
			{field: 'age', title: "Tuổi", width: 50},
			{field: 'job', title: "Nghề nghiệp", width: 120},
			{field: 'latitude', title: "Vĩ độ", width: 80},
			{field: 'longitude', title: "Kinh độ", width: 80},
			{field: 'activeCode', title: "Trạng thái", width: 70},
			{field: 'sentMailTime', title: "Thời gian gửi mail", width: 100},
			{field: 'openMailTime', title: "Thời gian mở mail", width: 100},
			{field:'downloadTime', title: "Thời gian tải file", width: 100}
		]
	});

})
