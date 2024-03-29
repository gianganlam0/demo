<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2023.1.117/styles/kendo.common-bootstrap.min.css">
	<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2023.1.117/styles/kendo.bootstrap.min.css">
	<script src="https://kendo.cdn.telerik.com/2023.1.117/js/kendo.all.min.js"></script>
	<script src="/assets/js/Utils.js"></script>
	<script src="/assets/js/Header.js"></script>
	<link rel="stylesheet" href="/assets/css/Header.css">
	<script src="/assets/js/Home.js"></script>
	<link rel="stylesheet" href="/assets/css/Home.css">
	<title>Trang chủ</title>
</head>

<body>
	<?php $this->load->view("/components/header");?>

	<div class="container-fluid mx-auto">
		<div class="row d-flex justify-content-center">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">	
					<form id="info-form"><h3 class="text-center">Nhập thông tin cá nhân</h3>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>


