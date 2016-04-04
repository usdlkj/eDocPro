					<script>
					$( document ).ready( function () {
						var table = $('#data_table').DataTable( {
							"ajax": "<?php echo site_url(array('document','ajax_latest_docs',$id_hash2));?>",
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 55,
									"className": "text-center"
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
								{
									text: 'Upload Document',
									action: function ( e, dt, node, config ) {
										window.location.href = "<?php echo site_url(array('document','create',$id_hash));?>";
									}
								},
								{
									text: 'Latest Versions',
									action: function ( e, dt, node, config ) {
										dt.clear();
										dt.ajax.url( "<?php echo site_url(array('document','ajax_latest_docs',$id_hash2));?>" ).load();
										dt.draw();
									}
								},
								{
									text: 'All Versions',
									action: function ( e, dt, node, config ) {
										dt.clear();
										dt.ajax.url( "<?php echo site_url(array('document','ajax_all_docs',$id_hash2));?>" ).load();
										dt.draw();
									}
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
						</table><?php endif;?>
					
					</div>