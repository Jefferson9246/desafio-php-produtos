<?php
if (isset($_GET['status']) && $_GET['status'] == 'success') {
	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="height:40%">
		Sucesso ao cadastrar a venda!
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>
	  ';
}
?>
<h2 class="text-center">Vendas cadastradas</h2>
<section class="my-1">
	<a href="/cadastrarvendas.php" class="btn btn-primary">Nova</a>
</section>
<table id="tabela-venda" class="table table-borded table-striped table-condensed dataTable no-footer dtr-inline ">
	<thead>
		<tr>
			<th>Número</th>
			<th>Cliente</th>
			<th>Impostos</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($vendas as $venda) {
			echo '<tr>';
			echo '<td>' . $venda->id . '</td>';
			echo '<td>' . $venda->cliente . '</td>';
			echo '<td>' . number_format($venda->valor_imposto, 2, ',', '.') . '</td>';
			echo '<td>' . number_format($venda->valor_venda, 2, ',', '.') . '</td>';
			echo '</tr>';
		}
		?>
	</tbody>

</table>

<script>
	$(document).ready(function() {
		$('#tabela-venda').DataTable({
			"dom": 'frtip',
			ordering: true,
			responsive: true,
			paging: true,
			language: {
				url: "libraries/pt_br_dt.json"
			},
			scrollY: '200px',
			scrollCollapse: true
		});
	});
</script>