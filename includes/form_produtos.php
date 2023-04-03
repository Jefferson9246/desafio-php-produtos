<h1 class="text-center mb-4">Cadastro de Produtos</h1>
<form method="post">
	<div class="row">
		<div class="mb-3 col-md-12">
			<label for="descricao" class="form-label">Descrição</label>
			<input type="text" class="form-control" id="descricao" name="descricao" required>
		</div>
	</div>
	<div class="row">
		<div class="mb-3 col-md-4">
			<label for="quantidade" class="form-label">Quantidade</label>
			<input type="number" class="form-control" id="quantidade" name="quantidade" required>
		</div>
		<div class="mb-3 col-md-4">
			<label for="valor" class="form-label">Valor</label>
			<input type="number" class="form-control" id="valor" name="valor" step="0.01" required>
		</div>
		<div class="mb-3 col-md-4">
			<label for="tipo" class="form-label">Tipo</label>
			<select class="form-select" id="tipo" name="tipo" required>
				<option value="">Selecione um tipo</option>
			</select>
		</div>
	</div>
	<div class="col-md-12 text-right">
		<button type="submit" class="btn btn-primary">Cadastrar</button>
	</div>
</form>
<script>
	$(document).ready(function() {
		function getTipos(){
			$.ajax({
				'url': "/cadastrarprodutos.php?tipos",
				'method': 'GET',
				'success': function(data){
					let objeto = JSON.parse(data);
					$.each(objeto, function(index, value){
						$('#tipo').append(`<option value="${value.id}">${value.tipo}</option>`)
					})
				},
				'error': function(error){
					console.log("🚀 ~ file: form.php:42 ~ $ ~ error:", error)
				}
			})
		}
		getTipos();
		
	});
</script>