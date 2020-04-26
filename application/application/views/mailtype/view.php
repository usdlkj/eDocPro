					<script>
					$(document).ready( function() { 
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false
								},
								{ 
									"targets": 3, 
									"orderable": false
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Add Mail Type',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('mailtype','create',$id_hash));?>";
									}
								},
								{
									text: 'Project List',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('project','view')); ?>";
									}
								}
							]
						} );
					} );
					</script>
					<div class="card">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body table-responsive">
							<?php if (isset($message)) echo $message;?>
							
							<table id="data_table" class="display">
							<thead>
								<tr>
									<th></th>
									<th>Mail Code</th>
									<th>Mail Type</th>
									<th class="text-center">Transmittal</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($mail_types as $type):?><tr>
									<td class="text-center">
										<?php $type_id_hash = $this->hashids->encode($type['id']);?>
										<a href="<?php echo site_url(array('mailtype','edit',$type_id_hash));?>" data-toggle="tooltip" title="Edit Mail Type">
											<button type="button" class="btn btn-warning btn-xs">
												<span class="cil-pencil btn-icon"></span></button>
										</a> 
										<a href="<?php echo site_url(array('mailtype','delete',$type_id_hash));?>" data-toggle="tooltip" title="Delete Mail Type">
											<button type="button" class="btn btn-danger btn-xs">
												<span class="cil-trash btn-icon"></span></button>
										</a>
									</td>
									<td><?php echo $type['mail_code'];?></td>
									<td><?php echo $type['mail_type'];?></td>
									<td class="text-center"><input type="checkbox"<?php if ($type['is_transmittal'] == 1):?> checked<?php endif;?> disabled /></td>
								</tr>
								<?php endforeach;?>
							
							</tbody>
							</table>
						</div>
					</div>