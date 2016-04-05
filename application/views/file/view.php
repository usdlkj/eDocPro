					<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 65
								},
								{ 
									"targets": 4, 
									"orderable": false,
									"width": 50
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Upload File',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('file','create'));?>";
									}
								}
							]
						} );
					});
					</script>
					<div class="table-responsive">
						<?php if (isset($message)) echo $message; ?>
						
						<table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>File Name</th>
								<th class='text-right'>File Size</th>
								<th>File Hash</th>
								<th class="text-center">Active</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($file as $file_item): ?><tr>
								<td class="text-center">
									<?php $id_hash = $this->hashids->encode($file_item['id']);?>
									<a href="<?php echo site_url(array('file','download',$id_hash));?>" data-toggle="tooltip" title="Download File"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></button></a> 
									<a href="<?php echo site_url(array('file','delete',$id_hash));?>" data-toggle="tooltip" title="Delete File"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
								</td>
								<td><?php echo $file_item['file_name']; ?></td>
								<td class='text-right'><?php echo $file_item['file_size']; ?> Kb</td>
								<td><?php echo $file_item['file_hash']; ?></td>
								<td class="text-center"><input type="checkbox"<?php if ($file_item['active']):?> checked<?php endif;?> disabled /></td>
							</tr>
							<?php endforeach; ?>
						
						</tbody>
						</table>
					</div>