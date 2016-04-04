					<script>
					$(document).ready( function () {
						$.fn.dataTable.ext.buttons.alert = {
							className: 'buttons-alert',
							action: function ( e, dt, node, config ) {
								jQuery.ajax( {
									type: "POST",
									url: "<?php echo site_url(array('document','ajax_all_docs',$id_hash3));?>",
									dataType: 'json',
									success: function( res ) {
										if ( res ) {
											table.fnClearTable();
										}
									}
								} );
							}
						};
						
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 35
								}
							],
							dom: 'Bfrtip',
							buttons: [
								{
									text: 'Upload Document',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('document','create',$id_hash));?>";
									}
								},
								{
									<?php if ($all_version):?>text: 'Latest Version',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('document','view',$id_hash));?>";
									}<?php else:?>text: 'All Versions',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('document','view',$id_hash2));?>";
									}<?php endif;?>
								},
								{
									extend: 'alert',
									text: 'My button 3'
								}
							]
						} );
					} );
					</script>
					<div class="table-responsive">
						<?php if (isset($message)) echo $message;?>
						
						<?php if ($project_id != '0'):?><table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<?php foreach ($fields as $field):?><th><?php echo $field['field_text'];?></th>
								<?php endforeach;?>
							
							</tr>
						</thead>
						<tbody>
							<?php foreach ($documents as $document):?><tr class="clickable-row" data-href="<?php echo site_url(array('document','detail',$this->hashids->encode($document['id'])));?>">
								<td class="text-center">
									<?php $id_hash = $this->hashids->encode($document['file_id']); if ($document['file_id'] == '0'):?><button type="button" class="btn btn-xs"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></button><?php else:?><a href="<?php echo site_url(array('file','download',$id_hash));?>" data-toggle="tooltip" title="Download File">
										<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></button>
									</a><?php endif;?>
								
								</td>
								<?php foreach ($fields as $field):?><td><?php if (array_key_exists($field['field_code'], $document)) {	
										if ($field['field_type'] == 5) {
											foreach ($selections as $select) {
												if ($document[$field['field_code']] == $select['id']) { 
													if ($all_version && $document['is_latest'] == 1) echo '<strong>';
													echo $select['value_text']; 
													if ($all_version && $document['is_latest'] == 1) echo '</strong>';
													break;
												}
											}
										}
										elseif ($field['field_type'] == 6) {
											$values = array();
											$value_ids = explode(',', $document[$field['field_code']]);
											foreach ($selections as $select) {
												foreach ($value_ids as $value_id) {
													if ($value_id == $select['id']) { 
														array_push($values, $select['value_text']);
													}
												}
											}
											if ($all_version && $document['is_latest'] == 1) echo '<strong>';
											echo implode(', ', $values);
											if ($all_version && $document['is_latest'] == 1) echo '</strong>';
										}
										else {
											if ($all_version && $document['is_latest'] == 1) echo '<strong>';
											echo $document[$field['field_code']];
											if ($all_version && $document['is_latest'] == 1) echo '</strong>';
										} 
									}?></td>
								<?php endforeach;?>
							
							</tr>
							<?php endforeach; ?>
						
						</tbody>
						</table><?php endif;?>
					
					</div>