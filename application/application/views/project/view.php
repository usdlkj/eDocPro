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
									text: 'Create Project',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('project','create')); ?>";
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
										<a href="<?php echo site_url(array('project','edit',$id_hash));?>" data-toggle="tooltip" title="Edit Project">
											<button type="button" class="btn btn-warning btn-xs">
												<span class="cil-pencil btn-icon"></span>
											</button>
										</a> 
										<a href="<?php echo site_url(array('project','delete',$id_hash));?>" data-toggle="tooltip" title="Delete Project">
											<button type="button" class="btn btn-danger btn-xs">
												<span class="cil-trash btn-icon"></span>
											</button>
										</a>
										<a href="<?php echo site_url(array('projectfield','view',$id_hash));?>" data-toggle="tooltip" title="Project Fields">
											<button type="button" class="btn btn-primary btn-xs">
												<span class="cil-file btn-icon"></span>
											</button>
										</a> 
										<a href="<?php echo site_url(array('mailtype','view',$id_hash));?>" data-toggle="tooltip" title="Mail Types">
											<button type="button" class="btn btn-primary btn-xs">
												<span class="cil-envelope-closed btn-icon"></span>
											</button>
										</a>
										<a href="<?php echo site_url(array('projectuser','view',$id_hash));?>" data-toggle="tooltip" title="Project Users">
											<button type="button" class="btn btn-primary btn-xs">
												<span class="cil-user btn-icon"></span>
											</button>
										</a>
									</td>
									<td><?php echo $project['project_name']; ?></td>
									<td><?php echo strtoupper($project['project_code']); ?></td>
									<td><?php echo $project['trading_name']; ?></td>
									<td class="text-center">
										<input type="checkbox"<?php if (!$project['deleted_by']):?> checked<?php endif;?> disabled />
									</td>
								</tr>
								<?php endforeach; ?>
							
							</tbody>
							</table>
						</div>
					</div>