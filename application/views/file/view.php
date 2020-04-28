					<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false
								},
								{ 
									"targets": 4, 
									"orderable": false
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
					<div class="card">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body table-responsive">
							<?php if (isset($message)) echo $message; ?>
							
							<table id="data_table" class="display">
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
								<?php foreach ($file as $file_item): ?>
								<tr>
									<td class="text-center">
										<?php $id_hash = $this->hashids->encode($file_item['id']);?>
										<a href="<?php echo site_url(array('file','download',$id_hash));?>" data-toggle="tooltip" title="Download File">
											<button type="button" class="btn btn-success btn-xs">
												<span class="cil-chevron-circle-down-alt btn-icon"></span>
											</button>
										</a> 
										<a href="<?php echo site_url(array('file','delete',$id_hash));?>" data-toggle="tooltip" title="Delete File">
											<button type="button" class="btn btn-danger btn-xs">
												<span class="cil-trash btn-icon"></span>
											</button>
										</a>
									</td>
									<td><?php echo $file_item['file_name']; ?></td>
									<td class='text-right'><?php echo $file_item['file_size']; ?> Kb</td>
									<td><?php echo $file_item['file_hash']; ?></td>
									<td class="text-center"><input type="checkbox"<?php if (!$file_item['deleted_by']):?> checked<?php endif;?> disabled /></td>
								</tr>
								<?php endforeach; ?>
							
							</tbody>
							</table>
						</div>
					</div>