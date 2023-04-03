<?php
	if(isset($_GET['status']) && $_GET['status'] == 'success'){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="height:40%">
		Sucesso ao cadastrar o produto!
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	  </div>
	  ';
	}
?>
<h2 class="text-center">Produtos cadastrados</h2>
<section class="">
	<a href="/cadastrarprodutos.php" class="btn btn-primary">Novo</a>
</section>

<table id="tabela-produtos" class="table table-borded table-striped table-condensed dataTable no-footer dtr-inline">
	<thead>
		<tr>
			<th>Produto</th>
			<th>Quantidade</th>
			<th>Valor</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($produtos as $produto) {
			echo '<tr>';
			echo '<td>' . $produto->descricao . '</td>';
			echo '<td>' . $produto->quantidade . '</td>';
			echo '<td>' . number_format($produto->valor, 2, ',', '.') . '</td>';
			echo '<td>' . $produto->tipo . '</td>';
			echo '</tr>';
		}
		?>
	</tbody>

</table>
<script>
	$(document).ready(function() {
		

		$('#tabela-produtos').DataTable({
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