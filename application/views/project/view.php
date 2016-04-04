					<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 140
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
									text: 'Create Project',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('project','create')); ?>";
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
								<th>Project Name</th>
								<th>Project Code</th>
								<th>Project Owner</th>
								<th class="text-center">Active</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($projects_list as $project): ?><tr>
								<td class="text-center">
									<?php $id_hash = $this->hashids->encode($project['id']);?>
									<a href="<?php echo site_url(array('project','edit',$id_hash));?>" data-toggle="tooltip" title="Edit Project"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a> 
									<a href="<?php echo site_url(array('project','delete',$id_hash));?>" data-toggle="tooltip" title="Delete Project"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
									<a href="<?php echo site_url(array('projectfield','view',$id_hash));?>" data-toggle="tooltip" title="Project Fields"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></button></a> 
									<a href="<?php echo site_url(array('mailtype','view',$id_hash));?>" data-toggle="tooltip" title="Mail Types"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button></a>
									<a href="<?php echo site_url(array('projectuser','view',$id_hash));?>" data-toggle="tooltip" title="Project Users"><button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button></a>
								</td>
								<td><?php echo $project['project_name']; ?></td>
								<td><?php echo strtoupper($project['project_code']); ?></td>
								<td><?php echo $project['trading_name']; ?></td>
								<td class="text-center"><input type="checkbox"<?php if ($project['active']):?> checked<?php endif;?> disabled /></td>
							</tr>
							<?php endforeach; ?>
						
						</tbody>
						</table>
					</div>