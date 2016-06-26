<html lang="en">
	<body class="bs-docs-home">
		<div class="col-md-2" style="margin-top:100px;">
			<ul class="nav list-group">
				<li class="list-group-item"><a href="?id=permintaan">Laporan permintaan material</a></li>
				<li class="list-group-item"><a href="?id=pemesanan">Laporan Pemesanan material</a></li>
				<li class="list-group-item"><a href="?id=penerimaan">Laporan Penerimaan material</a></li>
				<li class="list-group-item"><a href="?id=pengeluaran">Laporan Pengeluaran material</a></li>
				<li class="list-group-item"><a href="?id=pengembalian">Laporan pengembalian material</a></li>
			</ul>
		</div>
		
	<?php
		include '../header.php';
		$link="";
		$view="";
		$nama='';
		if(isset($_GET["id"])){
			if($_GET["id"]=="pemesanan"){$link='laporan pemesanan.php'; $nama='pemesanan';}
			else if($_GET["id"]=="penerimaan"){$link='laporan penerimaan.php'; $nama='penerimaan';}
			else if($_GET["id"]=="pengeluaran"){$link='laporan pengeluaran.php'; $nama='pengeluaran';}
			else if($_GET["id"]=="pengembalian"){$link='laporan pengembalian.php'; $nama='pengembalian';}
			else {$link='laporan permintaan.php'; $nama='permintaan';}
		}else if(isset($_GET["view"])){
			if($_GET["view"]=="pemesanan"){$view='pemesanan.php';}
			else if($_GET["view"]=="penerimaan"){$view='penerimaan.php';}
			else if($_GET["view"]=="pengeluaran"){$view='pengeluaran.php';}
			else if($_GET["view"]=="pengembalian"){$view='pengembalian.php';}
			else {$view='laporan permintaan.php';}
		}else{
			$link='laporan permintaan.php'; $nama='permintaan';
		}
		
		if(isset($_GET["id"])){
			?>
			
		<div class="col-md-8" style="margin-top:100px; margin-bottom:50px; border:1px solid black; padding:50px 50px;">
			<div class="col-md-12" style="text-align:center; margin-bottom:15px; font-size:24px;">
				Laporan <?php echo $nama;?> material <br>
				"SAKURA PAINTING"
			</div>
			<form class="col-md-offset-4 col-md-4 form-horizontal" role="form" action="<?php echo '?view='.$nama;?>" method="post">
				<div class="form-group">
					<div class="input-group input-daterange">
						<input name="awal" type="text" class="form-control" placeholder="yyyy-mm-dd"/>
						<span class="input-group-addon">to</span>
						<input name="akhir" type="text" class="form-control" placeholder="yyyy-mm-dd"/>
					</div>
				</div>
				<div class="col-sm-offset-4">
					<input type="submit" value="Tampilkan" class="btn btn-default">
				</div>
			</form>
		</div>
			
			<?php
		}else if(isset($_GET["view"])){
			include $_GET["view"].'.php';
		}else{
			header('Location:?id=permintaan');
		}
	?>
	
	<script type="text/javascript">
	// Run Datables plugin and create 3 variants of settings
	function AllTables(){
		classTable();
	}

	$(document).ready(function() {
		// Load Datatables and run plugin on tables 
		LoadDataTablesScripts(AllTables);
		// Add Drag-n-Drop feature
		WinMove();
		init_edit_class();
	});

	//fungsi print
	function printData()
	{
	   var divToPrint=document.getElementById("classTable");
	   newWin= window.open("");
	   newWin.document.write(divToPrint.outerHTML);
	   newWin.print();
	   newWin.close();
	}

	$('button').on('click',function(){
	printData();
	})
	</script>
		
	</body>
</html>