					<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 40
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Add Selection',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('selectvalue','create',$id_hash));?>";
									}
								},
								{
									text: 'Project Fields',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('projectfield','view',$id_hash2));?>";
									}
								}
							]
						} );
					});
					</script>
					<div class="table-responsive">
						<?php if (isset($message)) echo $message;?>
						
						<table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>Selection Code</th>
								<th>Selection Text</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($values as $value):?><tr>
								<td class="text-center">
									<a href="<?php echo site_url(array('selectvalue','delete', $this->hashids->encode($value['id'])));?>" data-toggle="tooltip" title="Delete Selection"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
								</td>
								<td><?php echo $value['value_code'];?></td>
								<td><?php echo $value['value_text'];?></td>
							</tr><?php endforeach;?>
						
						</tbody>
						</table>
					</div>