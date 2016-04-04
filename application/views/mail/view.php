					<script>
					$(document).ready( function() { 
						$('#data_table').DataTable( {
							"order": [[ 0, "asc" ]],
							dom: 'Bfrtip',
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"width": 160
								},
								{
									"targets": 5,
									"width": 120
								}
							],
							buttons: []
						} );
					} );
					</script>
					<div class="table-responsive">
						<?php if (isset($message)) echo $message;?>
						
						<table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Mail Code</th>
								<th>Mail Type</th>
								<th>Sender</th>
								<th>Recipients</th>
								<th>Mail Subject</th>
								<th class="text-center">Send Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($mails as $mail):?><tr class="clickable-row" data-href="<?php echo site_url(array('mail','detail',$this->hashids->encode($mail['project_id'],$mail['id'])));?>">
								<td><?php echo $mail['mail_code'];?></td>
								<td><?php echo $mail['mail_type'];?></td>
								<td><?php echo $mail['sender_name'];?></td>
								<td><?php echo $mail['recipients'];?></td>
								<td><?php echo $mail['subject'];?></td>
								<td class="text-center"><?php echo $mail['modified2'];?></td>
							</tr>
							<?php endforeach;?>
						
						</tbody>
						</table>
					</div>