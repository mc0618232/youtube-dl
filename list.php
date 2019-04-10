<?php
	header("Content-type:text/html;charset=utf8");
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}

	if(isset($_GET['type']) && !empty($_GET['type']))
	{
		$t = $_GET['type'];
		if($t === 'v')
		{
			$type = "videos";
			$files = $file->listVideos();
		}
		elseif($t === 'm')
		{
			$type = "musics";
			$files = $file->listMusics();
		}
	}

	if($session->is_logged_in() && isset($_GET["delete"]))
	{
		$file->delete($_GET["delete"], $t);
		header("Location: list.php?type=".$t);
	}

	require 'views/header.php';
?>
		<div class="container">
		<?php
			if(!empty($files))
			{
		?>
			<h2>全部列表 <?php echo $type ?> :</h2>
			<table class="table table-striped table-hover ">
				<thead>
					<tr>
						<th style="min-width:800px; height:35px">標題</th>
						<th style="min-width:80px">大小</th>
						<th style="min-width:80px">播放</th>
						<th style="min-width:80px">下載</th>
						<th style="min-width:110px">刪除</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$i = 0;
				$totalSize = 0;

				foreach($files as $f)
				{
					echo "<tr>";
					echo "<td>".$f["name"]."</td>";
					echo "<td>".$f["size"]."</td>";
					echo "<td><a href=\play.php?f=".$f["name"]." class=\"btn btn-danger btn-sm\">播放</a></td>";
					echo "<td><a href=\download.php?f=".$f["name"]." class=\"btn btn-danger btn-sm\">下載</a></td>";
					echo "<td><a href=\"./list.php?delete=$i&type=$t\" class=\"btn btn-danger btn-sm\">刪除</a></td>";
					echo "</tr>";
					$i++;
				}
			?>
				</tbody>
			</table>
			<br/>
			<br/>
		<?php
			}
			else
			{
				if(isset($t) && ($t === 'v' || $t === 'm'))
				{
					echo "<br><div class=\"alert alert-warning\" role=\"alert\">沒有 $type !</div>";
				}
				else
				{
					echo "<br><div class=\"alert alert-warning\" role=\"alert\">沒有文件 !</div>";
				}
			}
		?>
			<br/>
		</div><!-- End container -->
<?php
	require 'views/footer.php';
?>
