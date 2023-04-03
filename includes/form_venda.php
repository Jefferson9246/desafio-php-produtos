	<h1 class="text-center mb-5">Venda</h1>

	<form id="form-venda">
		<div class="row">

			<div class="mb-3 col-md-6">
				<label for="nome_cliente" class="form-label">Cliente</label>
				<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Insira o nome do cliente">
			</div>

			<div class="mb-3 col-md-3">
				<label for="valor-venda" class="form-label">Total da Venda</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="valor-venda" value="0.00" name="valor_venda" readonly>
				</div>
			</div>
			<div class="mb-3 col-md-3">
				<label for="valor-imposto" class="form-label">Total de Impostos</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="valor-imposto" value="0.00" name="valor_imposto" readonly>
				</div>
			</div>
		</div>
		<hr>
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInserirProduto">
			Inserir Produto
		</button>
		<div class="row mt-2 border border-primary rounded">
			<div class="col-md-12">
				<h4 class="text-center">Itens da venda</h4>
				<table class="table table-striped" id="table-itens-venda">
					<thead>
						<tr>
							<td>Id</td>
							<th>Produto</th>
							<th>Quantidade</th>
							<th>Valor Unitário</th>
							<th>Valor Imposto</th>
							<th>Total Item</th>
						</tr>
					</thead>
					<tbody id="tabela-itens">

					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-12 my-2">
			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</div>
	</form>

	<!-- Modal para inserção de produtos -->
	<div class="modal fade" id="modalInserirProduto" tabindex="-1" aria-labelledby="modalInserirProdutoLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalInserirProdutoLabel">Inserir Produto</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<form>
						<div class="mb-3">
							<label for="produto" class="form-label">Descrição</label>
							<select class="form-select" id="produto" name="produto" required>
								<option value="">Selecione um produto</option>
								<?php foreach ($produtos as $produto) {
									echo '<option value="' . $produto->id . '">' . $produto->descricao . '</option>';
								} ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="inputQuantidade" class="form-label">Quantidade</label>
							<input type="number" class="form-control" id="inputQuantidade">
						</div>
						<div class="mb-3">
							<label for="inputValor" class="form-label">Valor</label>
							<input type="number" class="form-control" id="inputValor" readOnly>
						</div>
						<div class="mb-3">
							<label for="inputImposto" class="form-label">Imposto</label>
							<input type="number" class="form-control" id="inputImposto" readonly>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary insereItem">Inserir</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			var objeto = null

			$('#table-itens-venda').dataTable({
				"dom": 'frtip',
				ordering: true,
				responsive: true,
				paging: true,
				language: {
					url: "libraries/pt_br_dt.json"
				},
				scrollY: '80px',
				scrollCollapse: true,
			})

			$('#produto').on('change', function() {
				let id = $(this).val();
				$.ajax({
					'url': "/cadastrarvendas.php?produto=" + id,
					'method': 'GET',
					'success': function(data) {
						objeto = JSON.parse(data)[0];
						$('#inputValor').val(objeto.valor);
					},
					'error': function(error) {
					}
				})

				if ($('#inputQuantidade').val()) {
					$('#inputImposto').val(calcularImposto($('#inputQuantidade').val() * objeto.valor, objeto.percentual_imposto));
				}
			})

			$('#inputQuantidade').on('change', function() {
				let qtd = $(this).val();
				if ($('#produto').val() && objeto) $('#inputImposto').val(calcularImposto(qtd * objeto.valor, objeto.percentual_imposto));
			})



			function calcularImposto(valor, imposto) {
				return valor * (imposto / 100);
			}

			$('.insereItem').on('click', function() {
				let produto = $('#produto option:selected').text();
				let idProduto = $('#produto').val();
				let quantidade = $('#inputQuantidade').val();
				let valorUnitario = parseFloat($('#inputValor').val()).toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL'
				});

				let imposto = $('#inputImposto').val();
				let impostoFormato = parseFloat(imposto).toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL'
				});
				let totalItem = parseFloat(parseFloat($('#inputValor').val() * quantidade) + parseFloat(imposto));
				let totalItemFormato = totalItem.toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL',
				});
				let table = $('#table-itens-venda').DataTable();
				//adiciona a row com o data-imposto e data-total para serem usados no calculo do total da venda

				table.row.add([
					idProduto,
					produto,
					quantidade,
					valorUnitario,
					impostoFormato,
					totalItemFormato
				]).draw(false);
				$('#modalInserirProduto').modal('hide');
				limpaModal()
				atualizaValoresVenda();
			})

			function atualizaValoresVenda() {
				let totalVenda = 0;
				let totalImposto = 0;
				$('#tabela-itens tr').each(function() {
					let totalItem = $(this).find('td').eq(5).text();
					totalItem = totalItem.replace('R$', '').replace('.', '').replace(',', '.');
					totalVenda += parseFloat(totalItem);

					//totalimposto
					let impostoItem = $(this).find('td').eq(4).text();
					impostoItem = impostoItem.replace('R$', '').replace('.', '').replace(',', '.');
					totalImposto += parseFloat(impostoItem);
				});

				$('#valor-venda').val(totalVenda.toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL'
				}));

				//insere no campo total de imposto
				$('#valor-imposto').val(totalImposto.toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL'
				}));

			}

			function limpaModal() {
				$('#produto').val('');
				$('#inputQuantidade').val('');
				$('#inputValor').val('');
				$('#inputImposto').val('');
			}

		});

		$('#form-venda').on('submit', function(e) {
			e.preventDefault();
			const dados = new FormData();
			dados.append('cliente', $('#nome_cliente').val().replace('R$', '').replace('.', '').replace(',', '.'));
			dados.append('valor_venda', parseFloat($('#valor-venda').val().replace('R$', '').replace('.', '').replace(',', '.')));	
			dados.append('valor_imposto', parseFloat($('#valor-imposto').val().replace('R$', '').replace('.', '').replace(',', '.')));

			let itens = [];
			$('#tabela-itens tr').each(function() {
				let item = {};
				item.produto_id = $(this).find('td').eq(0).text();
				item.quantidade = $(this).find('td').eq(2).text();
				item.imposto = parseFloat($(this).find('td').eq(4).text().replace('R$', '').replace('.', '').replace(',', '.'));
				item.total = parseFloat($(this).find('td').eq(5).text().replace('R$', '').replace('.', '').replace(',', '.'));
				itens.push(item);
			})
			dados.append('itens', JSON.stringify(itens));

			$.ajax({
				'url': "/cadastrarvendas.php",
				'method': 'POST',
				processData: false,
				contentType: false,
				'data': dados,
				'success': function(data) {
					console.log("🚀 ~ file: form_venda.php:173 ~ $ ~ data:", data)
					if(data) {
						alert('Venda cadastrada com sucesso!');
						window.location.href = '/index.php';
					} else {
						alert('Erro ao cadastrar venda!');
					}
				},
				'error': function(error) {
					console.log("🚀 ~ file: form_venda.php:176 ~ $ ~ error:", error)
				}
			})
		})
	</script>