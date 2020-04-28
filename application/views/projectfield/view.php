					<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 6, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false
								},
								{
									"targets": 4,
									"orderable": false
								},
								{
									"targets": 5,
									"orderable": false
								},
								{
									"targets": 6
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Add Field',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('projectfield','create',$id_hash)); ?>";
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
									<th>Field Code</th>
									<th>Field Type</th>
									<th>Text</th>
									<th class="text-center">Visible</th>
									<th class="text-center">Mandatory</th>
									<th class="text-center">Sequence</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($fields as $field):?><tr>
									<td class="text-center">
										<?php $field_id_hash = $this->hashids->encode($field['id']);?><a href="<?php echo site_url(array('projectfield','edit',$field_id_hash));?>" data-toggle="tooltip" title="Edit Project Field">
											<button type="button" class="btn btn-warning btn-xs"><span class="cil-pencil btn-icon"></span></button>
										</a>
										<a href="<?php echo site_url(array('projectfield','delete',$field_id_hash));?>" data-toggle="tooltip" title="Delete Project Field">
											<button type="button" class="btn btn-danger btn-xs"><span class="cil-trash btn-icon"></span></button>
										</a>
										<?php if ($field['field_type'] == 5 || $field['field_type'] == 6):?><a href="<?php echo site_url(array('selectvalue','view',$field_id_hash));?>" data-toggle="tooltip" title="Selections">
											<button type="button" class="btn btn-primary btn-xs"><span class="cil-file btn-icon"></span></button>
										</a>
										<?php else:?><button type='button' class='btn btn-xs'><span class="cil-file btn-icon"></span><?php endif;?>
										
									</td>
									<td><?php echo $field['field_code'];?></td>
									<td><?php switch ($field['field_type']) {
											case 1: echo 'Short Text'; break; 
											case 2: echo 'Medium Text'; break;
											case 3: echo 'Long Text'; break;
											case 4: echo 'Date'; break;
											case 5: echo 'Single Select'; break;
											case 6: echo 'Multi Select'; break;
										} ?></td>
									<td><?php echo $field['field_text']; ?></td>
									<td class="text-center"><input type="checkbox" disabled <?php if ($field['visible']) echo 'checked';?> /></td>
									<td class="text-center"><input type="checkbox" disabled <?php if ($field['mandatory']) echo 'checked';?> /></td>
									<td class="text-center"><?php echo $field['sequence'];?></td>
								</tr>
								<?php endforeach;?>
								
							</tbody>
							</table>
						</div>
					</div>