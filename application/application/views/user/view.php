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
									text: 'Create User',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('user','create'));?>";
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
									<th>First Name</th>
									<th>Company</th>
									<th class="text-center">Active</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user):?><tr>
									<td class="text-center">
										<?php $id_hash = $this->hashids->encode($user['id']);?>
										<?php if ($user['id'] == '10000001'):?>
											<button type="button" class="btn btn-xs">
												<span class="cil-pencil btn-icon"></span>
											</button>
										<?php else:?>
											<a href="<?php echo site_url(array('user','edit',$id_hash));?>" data-toggle="tooltip" title="Edit User">
												<button type="button" class="btn btn-warning btn-xs">
													<span class="cil-pencil btn-icon"></span>
												</button>
											</a>
										<?php endif;?>
										<?php if ($user['id'] == '10000001'):?>
											<button type="button" class="btn btn-xs">
												<span class="cil-trash btn-icon"></span>
											</button>
										<?php else:?>
											<a href="<?php site_url(array('user','delete',$id_hash));?>" data-toggle="tooltip" title="Delete User">
												<button type="button" class="btn btn-danger btn-xs">
													<span class="cil-trash btn-icon"></span>
												</button>
											</a>
										<?php endif;?>
										<a href="<?php echo site_url(array('user','password',$id_hash));?>" data-toggle="tooltip" title="Set Password">
											<button type="button" class="btn btn-primary btn-xs">
												<span class="cil-lock-locked btn-icon"></span>
											</button>
										</a>
										
									</td>
									<td><?php echo $user['login'];?></td>
									<td><?php echo $user['first_name'];?></td>
									<td><?php echo $user['trading_name'];?></td>
									<td class="text-center">
										<input type="checkbox"<?php if (!$user['deleted_by']):?> checked<?php endif;?> disabled />
									</td>
								</tr>
								<?php endforeach;?>
							
							</tbody>
							</table>
						</div>
					</div>