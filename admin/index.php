<?php
    $page_title = "메인 대시보드"; // 이 페이지의 타이틀 설정
    require_once 'includes/_header.php';    
    

    try {
        $query = "SELECT id, username, IFNULL(nickname, '-') as nickname, balance, member_type, status, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created_at_formatted FROM members ORDER BY id DESC";
        echo $query.'<p>';
        $stmt = $pdo->query($query);
        $members = $stmt->fetchAll();
    } catch (PDOException $e) {
        $members = []; 
        $db_error_message = "회원 정보를 가져오는 중 오류가 발생했습니다. 관리자에게 문의하십시오.";
    }    
?>

		<!--**********************************
            Content body start
        ***********************************-->
		<div class="content-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-9 col-xxl-12">
						<div class="row">
							<div class="col-xl-12">
								<div class="row">
									<div class="col-xl-6">
										<div class="row">
											<div class="col-xl-6 col-sm-6">
												<div class="card bg-primary text-white">
													<div class="card-header border-0 flex-wrap">
														<div class="revenue-date">
															<span>revenue</span>
															<h4 class="text-white">$310.435</h4>
														</div>
														<div class="avatar-list avatar-list-stacked me-2">
															<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
																class="avatar rounded-circle" alt="">
															<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																class="avatar rounded-circle" alt="">
															<span class="avatar rounded-circle">25+</span>
														</div>

													</div>
													<div
														class="card-body pb-0 custome-tooltip d-flex align-items-center">
														<div id="chartBar" class="chartBar"></div>
														<div>
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<circle cx="10" cy="10" r="10" fill="white" />
																<g clip-path="url(#clip0_3_443)">
																	<path opacity="0.3"
																		d="M13.0641 7.54535C13.3245 7.285 13.3245 6.86289 13.0641 6.60254C12.8038 6.34219 12.3817 6.34219 12.1213 6.60254L6.46445 12.2594C6.2041 12.5197 6.2041 12.9419 6.46445 13.2022C6.7248 13.4626 7.14691 13.4626 7.40726 13.2022L13.0641 7.54535Z"
																		fill="black" />
																	<path
																		d="M7.40729 7.26921C7.0391 7.26921 6.74062 6.97073 6.74062 6.60254C6.74062 6.23435 7.0391 5.93587 7.40729 5.93587H13.0641C13.4211 5.93587 13.7147 6.21699 13.7302 6.57358L13.9659 11.9947C13.9819 12.3626 13.6966 12.6737 13.3288 12.6897C12.961 12.7057 12.6498 12.4205 12.6338 12.0526L12.4258 7.26921H7.40729Z"
																		fill="black" />
																</g>
																<defs>
																	<clipPath id="clip0_3_443">
																		<rect width="16" height="16" fill="white"
																			transform="matrix(-1 0 0 -1 18 18)" />
																	</clipPath>
																</defs>
															</svg>
															<span class="d-block font-w600">45%</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card bg-secondary text-white">
													<div class="card-header border-0">
														<div class="revenue-date">
															<span class="text-black">Expenses</span>
															<h4 class="text-black">$920.035</h4>
														</div>
														<div class="avatar-list avatar-list-stacked me-2">
															<span class="avatar rounded-circle">
																<a href="#">
																	<svg width="14" height="15" viewBox="0 0 14 15"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M5.83333 6.27083V1.60417C5.83333 0.959834 6.35567 0.4375 7 0.4375C7.64433 0.4375 8.16667 0.959834 8.16667 1.60417V6.27083H12.8333C13.4777 6.27083 14 6.79317 14 7.4375C14 8.08183 13.4777 8.60417 12.8333 8.60417H8.16667V13.2708C8.16667 13.9152 7.64433 14.4375 7 14.4375C6.35567 14.4375 5.83333 13.9152 5.83333 13.2708V8.60417H1.16667C0.522334 8.60417 0 8.08183 0 7.4375C0 6.79317 0.522334 6.27083 1.16667 6.27083H5.83333Z"
																			fill="#222B40" />
																	</svg>
																</a>
															</span>
														</div>

													</div>
													<div
														class="card-body pb-0 custome-tooltip d-flex align-items-center">
														<div id="expensesChart" class="chartBar"></div>
														<div>
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<circle cx="10" cy="10" r="10" fill="#222B40" />
																<g clip-path="url(#clip0_3_473)">
																	<path opacity="0.3"
																		d="M13.0641 7.54535C13.3245 7.285 13.3245 6.86289 13.0641 6.60254C12.8038 6.34219 12.3817 6.34219 12.1213 6.60254L6.46446 12.2594C6.20411 12.5197 6.20411 12.9419 6.46446 13.2022C6.72481 13.4626 7.14692 13.4626 7.40727 13.2022L13.0641 7.54535Z"
																		fill="white" />
																	<path
																		d="M7.40728 7.26921C7.03909 7.26921 6.74061 6.97073 6.74061 6.60254C6.74061 6.23435 7.03909 5.93587 7.40728 5.93587H13.0641C13.4211 5.93587 13.7147 6.21699 13.7302 6.57358L13.9659 11.9947C13.9819 12.3626 13.6966 12.6737 13.3288 12.6897C12.9609 12.7057 12.6498 12.4205 12.6338 12.0526L12.4258 7.26921H7.40728Z"
																		fill="white" />
																</g>
																<defs>
																	<clipPath id="clip0_3_473">
																		<rect width="16" height="16" fill="white"
																			transform="matrix(-1 0 0 -1 18 18)" />
																	</clipPath>
																</defs>
															</svg>
															<span class="d-block font-w600 text-black">45%</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card">
													<div class="card-body depostit-card">
														<div
															class="depostit-card-media d-flex justify-content-between style-1">
															<div>
																<h6>Tasks Not Finisheds</h6>
																<h3>20</h3>
															</div>
															<div class="icon-box bg-secondary">
																<svg width="24" height="24" viewBox="0 0 24 24"
																	fill="none" xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_3_566)">
																		<path opacity="0.3" fill-rule="evenodd"
																			clip-rule="evenodd"
																			d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
																			fill="#222B40" />
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
																			fill="#222B40" />
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
																			fill="#222B40" />
																	</g>
																	<defs>
																		<clipPath id="clip0_3_566">
																			<rect width="24" height="24" fill="white" />
																		</clipPath>
																	</defs>
																</svg>
															</div>
														</div>
														<div class="progress-box mt-0">
															<div class="d-flex justify-content-between">
																<p class="mb-0">Complete Task</p>
																<p class="mb-0">20/28</p>
															</div>
															<div class="progress">
																<div class="progress-bar bg-secondary"
																	style="width:50%; height:5px; border-radius:4px;"
																	role="progressbar"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card same-card">
													<div class="card-body depostit-card p-0">
														<div
															class="depostit-card-media d-flex justify-content-between pb-0">
															<div>
																<h6>Total Deposit</h6>
																<h3>$1200.00</h3>
															</div>
															<div class="icon-box bg-primary">
																<svg width="12" height="20" viewBox="0 0 12 20"
																	fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path
																		d="M11.4642 13.7074C11.4759 12.1252 10.8504 10.8738 9.60279 9.99009C8.6392 9.30968 7.46984 8.95476 6.33882 8.6137C3.98274 7.89943 3.29927 7.52321 3.29927 6.3965C3.29927 5.14147 4.93028 4.69493 6.32655 4.69493C7.34341 4.69493 8.51331 5.01109 9.23985 5.47964L10.6802 3.24887C9.73069 2.6333 8.43112 2.21342 7.14783 2.0831V0H4.49076V2.22918C2.12884 2.74876 0.640949 4.29246 0.640949 6.3965C0.640949 7.87005 1.25327 9.03865 2.45745 9.86289C3.37331 10.4921 4.49028 10.83 5.56927 11.1572C7.88027 11.8557 8.81873 12.2813 8.80805 13.691L8.80799 13.7014C8.80799 14.8845 7.24005 15.3051 5.89676 15.3051C4.62786 15.3051 3.248 14.749 2.46582 13.9222L0.535522 15.7481C1.52607 16.7957 2.96523 17.5364 4.4907 17.8267V20.0001H7.14783V17.8735C9.7724 17.4978 11.4616 15.9177 11.4642 13.7074Z"
																		fill="#fff" />
																</svg>
															</div>
														</div>
														<div id="NewExperience"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-sm-6">
										<div class="card bg-success rainbow-box"
											style="background-image: url(images/rainbow.gif);background-size: cover;background-blend-mode: luminosity;">
											<div class="card-header border-0">
												<svg width="40" height="40" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M22.525 18.3762L15.0112 10.8625L18.461 7.41268L28.894 17.8457L26.6106 20.1291L30.1441 23.6626L35.961 17.8457L18.461 0.345703L11.4777 7.32896L7.94422 10.8624L11.4777 14.396L15.219 18.1372L21.9107 24.829L18.461 28.2787L8.02796 17.8457L10.3113 15.5623L6.77783 12.0288L0.960938 17.8457L18.461 35.3457L25.4442 28.3625L28.9777 24.829L22.525 18.3762Z" fill="white"/>
												</svg>
	
											</div>
											<div class="card-body pt-0">
												<div class="finance">
													<h4>Your Finances, safe and Secure</h4>
													<p>
														It is a long established fact that a reader will be distracted
														by the readable content of a page when looking at its layout.
													</p>
												</div>
												<div class="d-flex pt-3">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic777.jpg"
															class="avatar rounded-circle" alt="">
													</div>
													<div class="ratting-data">
														<h4>15k+</h4>
														<span>Happy Clients</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="relative">
													<div id="redial"></div>
													<span class="right-sign">
														<svg width="93" height="93" viewBox="0 0 93 93" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<g filter="url(#filter0_d_3_700)">
																<circle cx="46.5" cy="31.5" r="16.5" fill="#F8B940" />
															</g>
															<g clip-path="url(#clip0_3_700)">
																<path
																	d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
																	fill="#222B40" />
															</g>
															<defs>
																<filter id="filter0_d_3_700" x="0" y="0" width="93"
																	height="93" filterUnits="userSpaceOnUse"
																	color-interpolation-filters="sRGB">
																	<feFlood flood-opacity="0"
																		result="BackgroundImageFix" />
																	<feColorMatrix in="SourceAlpha" type="matrix"
																		values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
																		result="hardAlpha" />
																	<feOffset dy="15" />
																	<feGaussianBlur stdDeviation="15" />
																	<feComposite in2="hardAlpha" operator="out" />
																	<feColorMatrix type="matrix"
																		values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
																	<feBlend mode="normal" in2="BackgroundImageFix"
																		result="effect1_dropShadow_3_700" />
																	<feBlend mode="normal" in="SourceGraphic"
																		in2="effect1_dropShadow_3_700" result="shape" />
																</filter>
																<clipPath id="clip0_3_700">
																	<rect width="24" height="24" fill="white"
																		transform="translate(35 19)" />
																</clipPath>
															</defs>
														</svg>
													</span>
												</div>
												<div class="redia-date text-center">
													<h4>My Progress</h4>
													<p>
														Lorem ipsum dolor sit amet, consectetur
													</p>
													<a href="crm.html" class="btn btn-secondary text-black">More
														Details</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-8">
										<div class="card overflow-hidden">
											<div class="card-header border-0 pb-0 flex-wrap">
												<h4 class="heading mb-0">Projects Overview</h4>
												<ul class="nav nav-pills mix-chart-tab" id="pills-tab" role="tablist">
													<li class="nav-item" role="presentation">
														<button class="nav-link active" data-series="week"
															id="pills-week-tab" data-bs-toggle="pill"
															data-bs-target="#pills-week" type="button" role="tab"
															aria-selected="true">Week</button>
													</li>
													<li class="nav-item" role="presentation">
														<button class="nav-link" data-series="month"
															id="pills-month-tab" data-bs-toggle="pill"
															data-bs-target="#pills-month" type="button" role="tab"
															aria-selected="false">Month</button>
													</li>
													<li class="nav-item" role="presentation">
														<button class="nav-link" data-series="year" id="pills-year-tab"
															data-bs-toggle="pill" data-bs-target="#pills-year"
															type="button" role="tab" aria-selected="false">Year</button>
													</li>
													<li class="nav-item" role="presentation">
														<button class="nav-link" data-series="all" id="pills-all-tab"
															data-bs-toggle="pill" data-bs-target="#pills-all"
															type="button" role="tab" aria-selected="false">All</button>
													</li>
												</ul>
											</div>
											<div class="card-body custome-tooltip p-0">
												<div id="overiewChart"></div>
												<div class="ttl-project">
													<div class="pr-data">
														<h5>12,721</h5>
														<span>Number of Projects</span>
													</div>
													<div class="pr-data">
														<h5 class="text-primary">721</h5>
														<span>Active Projects</span>
													</div>
													<div class="pr-data">
														<h5>$2,50,523</h5>
														<span>Revenue</span>
													</div>
													<div class="pr-data">
														<h5 class="text-success">12,275h</h5>
														<span>Working Hours</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-4">
										<div class="card overflow-hidden">
											<div class="card-header border-0 flex-wrap">
												<h4 class="heading mb-0">My To Do Items</h4>
												<div>
													<a href="javascript:void(0);" class="text-primary me-2">View All</a>
													<a href="javascript:void(0);" class="text-black"> + Add To Do</a>
												</div>
											</div>
											<div class="card-body p-0">
												<div class="dt-do-bx">
													<div class="draggable-zone dropzoneContainer to-dodroup dz-scroll">
														<div class="sub-card draggable-handle draggable">
															<div class="d-items">
																<span class="text-warning dang d-block mb-2">
																	<svg class="me-1" width="18" height="18"
																		viewBox="0 0 18 18" fill="none"
																		xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M3.61051 15.3276H14.3978C15.5843 15.3276 16.329 14.0451 15.7395 13.0146L10.35 3.59085C9.75676 2.5536 8.26126 2.55285 7.66726 3.5901L2.26876 13.0139C1.67926 14.0444 2.42326 15.3276 3.61051 15.3276Z"
																			stroke="#FF9F00" stroke-width="1.5"
																			stroke-linecap="round"
																			stroke-linejoin="round" />
																		<path d="M9.00189 10.0611V7.7361"
																			stroke="#FF9F00" stroke-width="1.5"
																			stroke-linecap="round"
																			stroke-linejoin="round" />
																		<path d="M8.99625 12.375H9.00375"
																			stroke="#FF9F00" stroke-width="2"
																			stroke-linecap="round"
																			stroke-linejoin="round" />
																	</svg>
																	Latest to do's
																</span>
																<div class="d-flex justify-content-between flex-wrap">
																	<div class="d-items-2">
																		<div class="svg-icon">
																			<svg width="9" height="16"
																				viewBox="0 0 9 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<rect width="1" height="1"
																					fill="#888888" />
																				<rect y="3" width="1" height="1"
																					fill="#888888" />
																				<rect y="6" width="1" height="1"
																					fill="#888888" />
																				<rect y="9" width="1" height="1"
																					fill="#888888" />
																				<rect y="12" width="1" height="1"
																					fill="#888888" />
																				<rect y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="15" width="1" height="1"
																					fill="#888888" />
																			</svg>
																		</div>
																		<div>
																			<div class="form-check custom-checkbox">
																				<input type="checkbox"
																					class="form-check-input"
																					id="customCheckBox1" required>
																				<label class="form-check-label"
																					for="customCheckBox1">Compete this
																					projects</label>
																			</div>
																			<span>2023-12-26 07:15:00</span>
																		</div>
																	</div>
																	<div>
																		<div
																			class="icon-box icon-box-sm bg-danger-light me-1">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path d="M13.8055 4.1598H2.50012"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																		<div
																			class="icon-box icon-box-sm bg-primary-light">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path d="M9.16492 13.6286H14"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path fill-rule="evenodd"
																					clip-rule="evenodd"
																					d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M7.34723 4.00059L10.9821 6.79201"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>

																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="sub-card draggable-handle draggable">
															<div class="d-items">
																<span class="text-success dang d-block mb-2">
																	<svg class="me-1" width="18" height="18"
																		viewBox="0 0 18 18" fill="none"
																		xmlns="http://www.w3.org/2000/svg">
																		<path d="M15 4.5L6.75 12.75L3 9"
																			stroke="#3AC977" stroke-width="2"
																			stroke-linecap="round"
																			stroke-linejoin="round" />
																	</svg>
																	Latest finished to do's
																</span>
																<div class="d-flex justify-content-between flex-wrap">
																	<div class="d-items-2">
																		<div class="svg-icon">
																			<svg width="9" height="16"
																				viewBox="0 0 9 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<rect width="1" height="1"
																					fill="#888888" />
																				<rect y="3" width="1" height="1"
																					fill="#888888" />
																				<rect y="6" width="1" height="1"
																					fill="#888888" />
																				<rect y="9" width="1" height="1"
																					fill="#888888" />
																				<rect y="12" width="1" height="1"
																					fill="#888888" />
																				<rect y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="15" width="1" height="1"
																					fill="#888888" />
																			</svg>
																		</div>
																		<div>
																			<div class="form-check custom-checkbox">
																				<input type="checkbox"
																					class="form-check-input"
																					id="customCheckBox2" required>
																				<label class="form-check-label"
																					for="customCheckBox2">Compete this
																					projects</label>
																			</div>
																			<span>2023-12-26 07:15:00</span>
																		</div>
																	</div>
																	<div>
																		<div
																			class="icon-box icon-box-sm bg-danger-light me-1">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path d="M13.8055 4.1598H2.50012"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																		<div
																			class="icon-box icon-box-sm bg-primary-light">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path d="M9.16492 13.6286H14"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path fill-rule="evenodd"
																					clip-rule="evenodd"
																					d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M7.34723 4.00059L10.9821 6.79201"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>

																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="sub-card draggable-handle draggable">
															<div class="d-items">
																<div class="d-flex justify-content-between flex-wrap">
																	<div class="d-items-2">
																		<div class="svg-icon">
																			<svg width="9" height="16"
																				viewBox="0 0 9 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<rect width="1" height="1"
																					fill="#888888" />
																				<rect y="3" width="1" height="1"
																					fill="#888888" />
																				<rect y="6" width="1" height="1"
																					fill="#888888" />
																				<rect y="9" width="1" height="1"
																					fill="#888888" />
																				<rect y="12" width="1" height="1"
																					fill="#888888" />
																				<rect y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="15" width="1" height="1"
																					fill="#888888" />
																			</svg>
																		</div>
																		<div>
																			<div class="form-check custom-checkbox">
																				<input type="checkbox"
																					class="form-check-input"
																					id="customCheckBox3" required>
																				<label class="form-check-label"
																					for="customCheckBox3">Compete this
																					projects</label>
																			</div>
																			<span>2023-12-26 07:15:00</span>
																		</div>
																	</div>
																	<div>
																		<div
																			class="icon-box icon-box-sm bg-danger-light me-1">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path d="M13.8055 4.1598H2.50012"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																		<div
																			class="icon-box icon-box-sm bg-primary-light">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path d="M9.16492 13.6286H14"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path fill-rule="evenodd"
																					clip-rule="evenodd"
																					d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M7.34723 4.00059L10.9821 6.79201"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>

																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="sub-card draggable-handle draggable">
															<div class="d-items">
																<div class="d-flex justify-content-between flex-wrap">
																	<div class="d-items-2">
																		<div class="svg-icon">
																			<svg width="9" height="16"
																				viewBox="0 0 9 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<rect width="1" height="1"
																					fill="#888888" />
																				<rect y="3" width="1" height="1"
																					fill="#888888" />
																				<rect y="6" width="1" height="1"
																					fill="#888888" />
																				<rect y="9" width="1" height="1"
																					fill="#888888" />
																				<rect y="12" width="1" height="1"
																					fill="#888888" />
																				<rect y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="15" width="1" height="1"
																					fill="#888888" />
																			</svg>
																		</div>
																		<div>
																			<div class="form-check custom-checkbox">
																				<input type="checkbox"
																					class="form-check-input"
																					id="customCheckBox4" required>
																				<label class="form-check-label"
																					for="customCheckBox4">Compete this
																					projects Monday</label>
																			</div>
																			<span>2023-12-26 07:15:00</span>
																		</div>
																	</div>
																	<div>
																		<div
																			class="icon-box icon-box-sm bg-danger-light me-1">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path d="M13.8055 4.1598H2.50012"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																		<div
																			class="icon-box icon-box-sm bg-primary-light">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path d="M9.16492 13.6286H14"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path fill-rule="evenodd"
																					clip-rule="evenodd"
																					d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M7.34723 4.00059L10.9821 6.79201"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>

																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="sub-card draggable-handle draggable">
															<div class="d-items">
																<div class="d-flex justify-content-between flex-wrap">
																	<div class="d-items-2">
																		<div class="svg-icon">
																			<svg width="9" height="16"
																				viewBox="0 0 9 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<rect width="1" height="1"
																					fill="#888888" />
																				<rect y="3" width="1" height="1"
																					fill="#888888" />
																				<rect y="6" width="1" height="1"
																					fill="#888888" />
																				<rect y="9" width="1" height="1"
																					fill="#888888" />
																				<rect y="12" width="1" height="1"
																					fill="#888888" />
																				<rect y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="4" y="15" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="3" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="6" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="9" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="12" width="1" height="1"
																					fill="#888888" />
																				<rect x="8" y="15" width="1" height="1"
																					fill="#888888" />
																			</svg>
																		</div>
																		<div>
																			<div class="form-check custom-checkbox">
																				<input type="checkbox"
																					class="form-check-input"
																					id="customCheckBox5" required>
																				<label class="form-check-label"
																					for="customCheckBox5">Compete this
																					projects Monday</label>
																			</div>
																			<span>2023-12-26 07:15:00</span>
																		</div>
																	</div>
																	<div>
																		<div
																			class="icon-box icon-box-sm bg-danger-light me-1">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path d="M13.8055 4.1598H2.50012"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598"
																					stroke="#FF5E5E"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																		<div
																			class="icon-box icon-box-sm bg-primary-light">
																			<svg width="16" height="16"
																				viewBox="0 0 16 16" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path d="M9.16492 13.6286H14"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path fill-rule="evenodd"
																					clip-rule="evenodd"
																					d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																				<path
																					d="M7.34723 4.00059L10.9821 6.79201"
																					stroke="var(--primary)"
																					stroke-linecap="round"
																					stroke-linejoin="round" />
																			</svg>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 respo col-xxl-4 col-lg-5">
						<div class="row">
							<div class="col-xl-12">
								<div class="card my-calendar">
									<div class="card-body schedules-cal p-2">
										<input type="text" class="form-control d-none" id="datetimepicker1">
										<div class="events">
											<h6>events</h6>
											<div class="dz-scroll event-scroll">
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Development
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Desinging
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Frontend
																	Designing</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Software
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card same-card chart-chart">
									<div class="card-body d-flex align-items-center  py-2">
										<div id="AllProject"></div>
										<ul class="project-list">
											<li>
												<h6>All Projects</h6>
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="#3AC977" />
												</svg>
												Compete
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="var(--primary)" />
												</svg>
												Pending
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="var(--secondary)" />
												</svg>
												Not Start
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-xxl-12">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive active-projects">
									<div class="tbl-caption">
										<h4 class="heading mb-0">Active Projects</h4>
									</div>
									<table id="projects-tbl" class="table">
										<thead>
											<tr>
												<th>Project Name</th>
												<th>Project Lead</th>
												<th>Progress</th>
												<th>Assignee</th>
												<th>Status</th>
												<th>Due Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Batman</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Liam Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Bender Project</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Oliver Noah</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:30%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-danger">30%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Pending</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Canary</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic888.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Elijah James</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-success"
																style="width:40%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-success">40%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-success light border-0">Completed</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Casanova</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">William Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Bigfish</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Donald Benjamin</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:30%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-danger">30%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Matadors</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic888.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Liam Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Mercury</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Oliver Noah</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:30%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-danger">30%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Pending</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Whistler</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Elijah James</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-success"
																style="width:40%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-success">40%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-success light border-0">Completed</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Time Projects</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Lucas</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:33%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">33%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Fast Ball</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">William Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>

										</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-xxl-8 col-lg-7">
						<div class="card h-auto">
							<div class="card-header border-0 pb-3">
								<h4 class="heading mb-0">Running Projects</h4>
								<a href="javascript:void(0)" class="btn btn-sm btn-primary">View All</a>
							</div>
							<div class="card-body pt-0">
								<div class="swiper mySwiper">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="<?php echo $admin_assets_url; ?>/images/p1.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Development planning</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-danger light border-0">Pending</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="<?php echo $admin_assets_url; ?>/images/p3.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Desinging planning</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-info light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="<?php echo $admin_assets_url; ?>/images/p.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Frontend Designing</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-warning light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="<?php echo $admin_assets_url; ?>/images/p2.gif" alt="">
													</div>
													<div class="media-data">
														<h4>Compete this projects Monday</h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="<?php echo $admin_assets_url; ?>/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-primary light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!--**********************************
            Content body end
        ***********************************-->
<?php include_once "includes/_footer.php"; ?>		