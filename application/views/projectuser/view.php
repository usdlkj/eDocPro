					<script>
					$(document).ready( function() { 
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Add User',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('projectuser','create',$id_hash));?>";
									}
								},
								{
									text: 'Project List',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('project','view'));?>";
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
									<th>Username</th>
									<th>Name</th>
									<th>Company</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user):?><tr>
									<td class="text-center">
										<a href="<?php echo site_url(array('projectuser','delete', $this->hashids->encode($prj_id, $user['user_id'])));?>" data-toggle="tooltip" title="Remove User">
											<button type="button" class="btn btn-danger btn-xs">
												<span class="cil-trash btn-icon"></span></button></a>
									</td>
									<td><?php echo $user['login'];?></td>
									<td><?php echo $user['first_name'];?></td>
									<td><?php echo $user['trading_name'];?></td>
								</tr>
								<?php endforeach;?>
							
							</tbody>
							</table>
						</div>
					</div>