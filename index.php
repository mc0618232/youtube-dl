<?php
	header("Content-type:text/html;charset=gb2312");
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;

			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$downloader = new Downloader($_POST['urls'], $audio_only);
			
			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
			}
		}
	}
?>
		<div class="container">
			<h1>下載</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" class="form-horizontal" action="index.php" method="post">					
				<div class="form-group">
					<div class="col-md-10">
						<input class="form-control" id="url" name="urls" placeholder="影片連結" type="text">
					</div>
					<div class="col-md-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="audio"> 只下載音樂
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">下載</button>
			</form>
			<br>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">信息</h3></div>
						<div class="panel-body">
							<p>剩餘空間 : <?php echo $file->free_space(); ?></b></p>
							<p>下載目錄 : <?php echo $file->get_downloads_folder(); ?></p>
						</div>
					</div>
				</div>
				
			</div>
		</div>

