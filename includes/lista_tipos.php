<?php
if ($_GET['status'] == 'success') {
	echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="height:40%">
		Sucesso ao cadastrar o tipo de produto!
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>
	  ';
}
?>
<h2 class="text-center">Produtos cadastrados</h2>
<section class="my-2">
	<a href="/cadastrartipos.php" class="btn btn-primary">Novo</a>
</section>

<table id="tabela-tipos" class="table table-borded table-striped table-condensed dataTable no-footer dtr-inline">
	<thead>
		<tr>
			<th>Tipo</th>
			<th>Percentual</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($tipos as $tipo) {
			echo '<tr>';
			echo '<td>' . $tipo->tipo . '</td>';
			echo '<td>' . $tipo->percentual_imposto . '</td>';
			echo '</tr>';
		}
		?>
	</tbody>

</table>
<script>
	$(document).ready(function() {
		$('#tabela-tipos').DataTable({
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