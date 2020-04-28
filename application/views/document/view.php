					<script>
					$( document ).ready( function () {
						var table = $('#data_table').DataTable( {
							"ajax": "<?php echo site_url(array('document','ajax_latest_docs',$id_hash2));?>",
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
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
					<div class="card">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body table-responsive">
							<?php if (isset($message)) echo $message;?>
							
							<?php if ($project_id != '0'):?><table id="data_table" class="display">
							<thead>
								<tr>
									<th></th>
									<?php foreach ($fields as $field):?><th><?php echo $field['field_text'];?></th>
									<?php endforeach;?>
								</tr>
							</thead>
							</table><?php endif;?>
						
						</div>