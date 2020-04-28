					<script>
					$(document).ready( function() { 
						$('#data_table').DataTable( {
							"order": [[ 0, "asc" ]],
							dom: 'Bfrtip',
							"columnDefs": [ 
								{ 
									"targets": 0
								},
								{
									"targets": 5
								}
							],
							buttons: []
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
									<th>Mail Code</th>
									<th>Mail Type</th>
									<th>Sender</th>
									<th>Recipients</th>
									<th>Mail Subject</th>
									<th class="text-center">Send Date</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($mails as $mail):?>
								<tr>
									<td><a href="<?php echo site_url(array('mail','detail',$this->hashids->encode($mail['project_id'],$mail['id'])));?>">
											<?php echo $mail['mail_code'];?></a></td>
									<td><?php echo $mail['mail_type'];?></td>
									<td><?php echo $mail['sender_name'];?></td>
									<td><?php echo $mail['recipients'];?></td>
									<td><?php echo $mail['subject'];?></td>
									<td class="text-center"><?php echo $mail['created_at'];?></td>
								</tr>
								<?php endforeach;?>
							</tbody>
							</table>
						</div>
					</div>