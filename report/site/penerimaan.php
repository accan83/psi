<?php
	
	include '../connection.php';
	$awal = strtotime($_POST["awal"] . ' 00:00:00');
	$akhir = strtotime($_POST["akhir"] . ' 23:59:59');

?>

<div class="col-md-8" style="border:1px solid black; padding:50px 50px;">
	<div class="col-md-12" style="text-align:center; margin-bottom:15px; font-size:24px;">
		Laporan Penerimaan Material <br>
		"SAKURA PAINTING"
	</div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#nofilter" aria-controls="nofilter" role="tab" data-toggle="tab">No filter</a></li>
		<li role="presentation"><a href="#material" aria-controls="material" role="tab" data-toggle="tab">Material</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="nofilter"> <!------------------------------------------------------------------->
			<table class="table table-striped">
				<th>no</th>
				<th>no penerimaan</th>
				<th>tanggal</th>
				<th>ID material</th>
				<th>jumlah(Kardus)</th>
				<th width="15%">Harga</th>
				<th width="15%">Subtotal</th>
				
				<?php				
					$sql = "SELECT * FROM 
							material_accepted p join material_accepted_detail d on p.id=d.material_accepted_id
							where p.created_at>='".$awal."' and p.created_at<='".$akhir."'";
					$result = mysqli_query($conn, $sql);
					$x=1;
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$total=$row["qty"]*$row["price"];
							echo '
							<tr>
								<td>'.$x.'</td>
								<td>'.$row["id"].'</td>
								<td>'.date('d M Y', $row["created_at"]).'</td>
								<td>'.$row["material_id"].'</td>
								<td>'.$row["qty"].'</td>
								<td>'.$row["price"].'</td>
								<td>'.$total.'</td>
							</tr>
							';
							$x++;
						}
					}
				?>
				
			</table>
		</div>
		<button class="col-md-offset-4 col-md-4">Cetak</button>
	</div>
	
</div>