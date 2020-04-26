					<script>
					$(document).ready( function () {
						$('.select2').select2();
						$('#data_table').DataTable( {
							"order": [[ 0, "asc" ]],
							dom: 'Blfrtip',
							"columnDefs": [ 
								{ 
									"targets": 0
								},
								{
									"targets": 5
								}
							],
							buttons: [],
							"pageLength": 5
						} );
						$('#closeModal').on('click', function () {
							var text = $('#attachments');
							var rowdata = table.cells('.selected', 0).data();
							text.val(rowdata.join());
						});
					} );
					</script>
					
					<div class="card">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php if (isset($message)): echo $message; endif;?>
							
							<div class="table-responsive">
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
									<?php foreach ($mails as $mail2):?><tr class="clickable-row<?php if ($mail['id'] == $mail2['id']) echo ' selected';?>" data-href="<?php echo site_url(array('mail','detail',$this->hashids->encode($mail2['project_id'],$mail2['id'])));?>">
										<td><?php echo $mail2['mail_code'];?></td>
										<td><?php echo $mail2['mail_type'];?></td>
										<td><?php echo $mail2['sender_name'];?></td>
										<td><?php echo $mail2['recipients'];?></td>
										<td><?php echo $mail2['subject'];?></td>
										<td class="text-center"><?php echo $mail2['created_at'];?></td>
									</tr>
									<?php endforeach;?>
								
								</tbody>
								</table>
							</div>
							
							<div class="form-style-2">
								<?php echo form_open('mail/detail/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
									<div class="form-group">
										<label for="mail_type">Mail Code:</label>
										<input class="form-control" type="text" name="subject" value="<?php echo $mail['mail_code'];?>" disabled />
									</div>
									<div class="form-group">
										<label for="mail_type">Mail Type:</label>
										<select class="form-control select2" name="mail_type" id="mail_type" disabled>
											<option value="<?php echo $mail['mail_type_id'];?>"><?php echo $mail['mail_type'];?></option>
										</select>
									</div>
									<div class="form-group">
										<label for="recipient_to">To:</label>
										<select class="form-control select2" name="recipient_to[]" id="recipient_to" multiple disabled>
											<?php foreach ($recipients as $recipient):?>
											<?php if ($recipient['user_type'] == 1):?>
											<option value="<?php echo $recipient['user_id'];?>" selected><?php echo $recipient['first_name'];?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
									</div>
									<div class="form-group">
										<label for="recipient_cc">Cc:</label>
										<select class="form-control select2" name="recipient_cc[]" id="recipient_cc" multiple disabled>
											<?php foreach ($recipients as $recipient):?>
											<?php if ($recipient['user_type'] == 2):?>
											<option value="<?php echo $recipient['user_id'];?>" selected><?php echo $recipient['first_name'];?></option>"
											<?php endif;?>
											<?php endforeach?>
										</select>
									</div>
									<div class="form-group">
										<label for="cname">Subject:</label>
										<input class="form-control" type="text" name="subject" value="<?php echo $mail['subject'];?>" disabled />
									</div>
									<div class="form-group">
										<label for="tname">Body:</label>
										<textarea class="form-control" name="message" rows="8" disabled><?php echo $mail['message'];?></textarea>
									</div>
									<?php foreach($attachments as $attachment):?>
									<div class="form-group">
										<label for="cname">Attachment:</label>
										<input class="form-control" type="text" name="displayfile" value="<?php echo $attachment['doc_code'];?>" disabled />
										<a href="<?php echo site_url(array('document','detail',$this->hashids->encode($attachment['attachment_id'])));?>">
											<button type="button" class="btn btn-primary"><span class='cil-file btn-icon'></span></button></a>
									</div>
									<?php endforeach;?>
									<div class="form-group">
										<a href="<?php echo site_url(array('mail','reply',$id_hash2));?>">
											<button type="button" class="btn btn-primary">Reply</button></a>
										<a href="<?php echo site_url(array('mail','forward',$id_hash2));?>">
											<button type="button" class="btn btn-primary">Forward</button></a>
										<a href="<?php echo site_url(array('mail','inbox',$id_hash));?>">
											<button type="button" class="btn btn-danger">Back</button></a>
									</div>
								</form>
							</div>
						</div>
					</div>