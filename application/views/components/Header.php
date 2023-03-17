<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<header class="header row">
	<div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
		<a href="<?= base_url() ?>" class="logo">
			<div id="header-logo">
				Company Logo
			</div>
		</a>
	</div>
	<nav class="col-6">
		<div class="nav">
				<a href="/" class="nav-link">Home</a>
			<?php
				if ($this->session->userdata('username')) {
					echo <<<HTML
					<a href="/admin/dashboard" class="nav-link">Admin</a>
					HTML;
				}
			?>
		</div>
	</nav>
	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
		<div class="header-right">
			<?php
				if (!$this->session->userdata('username')) {
					echo <<<HTML
					<a href='/login' class='btn btn-success'>Đăng nhập</a>
					HTML;
				}
				else {
					echo <<<HTML
					<a class='btn btn-danger' onclick='logout()'>Đăng xuất</a>
					HTML;
				}
			?>
		</div>
</header>
