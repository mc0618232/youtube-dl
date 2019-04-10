﻿<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Youtube-dl WebUI</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
		<div class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="">Youtube-dl WebUI</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li><a href="./">下載</a></li>
					<li><a href="./list.php?type=v">影片列表</a></li>
					<li><a href="./list.php?type=m">音樂列表</a></li>
					<?php
						if($session->is_logged_in())
						{
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<?php if(Downloader::background_jobs() > 0) echo "<b>"; ?>後台下載任務 : <?php echo Downloader::background_jobs()." / ".Downloader::max_background_jobs(); if(Downloader::background_jobs() > 0) echo "</b>"; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
								if(Downloader::get_current_background_jobs() != null)
								{
									foreach(Downloader::get_current_background_jobs() as $key)
									{
										if (strpos($key['cmd'], '-x') !== false) //Music
										{
											echo "<li><a href=\"#\"><i class=\"fa fa-music\"></i> 用時 : ".$key['time']."</a></li>";
										}
										else
										{
											echo "<li><a href=\"#\"><i class=\"fa fa-video-camera\"></i> 用時 : ".$key['time']."</a></li>";
										}
									}

									echo "<li class=\"divider\"></li>";
									echo "<li><a href=\"./index.php?kill=all\">停止全部下載</a></li>";
								}
								else
								{
									echo "<li><a>沒有任務!</a></li>";
								}

							?>
						</ul>
					</li>
					<?php
						}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
						if($session->is_logged_in())
						{
							echo "<li><a href=\"./logout.php\">登出</a></li>";
						}
					?>
				</ul>
			</div>
		</div>
