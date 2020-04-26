					<script>
					$(document).ready( function () {
						$('.select2').select2( {
							theme: 'bootstrap'
						} );
						$('#data_table').DataTable( {
							"order": [[ 0, "asc" ]],
							dom: 'Blfrtip',
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
					
					<?php if (isset($message)): echo $message; endif;?>
					
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
							<?php foreach ($mails as $mail2):?><tr class="clickable-row<?php if ($mail['id'] == $mail2['id']) echo ' selected';?>" data-href="<?php echo site_url(array('mail','detail',$this->hashids->encode($mail2['project_id'],$mail2['id'])));?>">
								<td><?php echo $mail2['mail_code'];?></td>
								<td><?php echo $mail2['mail_type'];?></td>
								<td><?php echo $mail2['sender_name'];?></td>
								<td><?php echo $mail2['recipients'];?></td>
								<td><?php echo $mail2['subject'];?></td>
								<td class="text-center"><?php echo $mail2['modified2'];?></td>
							</tr>
							<?php endforeach;?>
						
						</tbody>
						</table>
					</div>
					
					<div class="form-style-2">
						<?php echo form_open('mail/detail/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="mail_type">Mail Code:</label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="subject" value="<?php echo $mail['mail_code'];?>" disabled />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="mail_type">Mail Type:</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="mail_type" id="mail_type" disabled>
										<option value="<?php echo $mail['mail_type_id'];?>"><?php echo $mail['mail_type'];?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="recipient_to">To:</label>
								<div class="col-sm-7">
									<select class="form-control select2" name="recipient_to[]" id="recipient_to" multiple disabled>
										<?php foreach ($recipients as $recipient) {
											if ($recipient['user_type'] == 1) {
												echo "<option value='".$recipient['user_id']."' selected>".$recipient['first_name']."</option>";
											}
										}?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="recipient_cc">Cc:</label>
								<div class="col-sm-7">
									<select class="form-control select2" name="recipient_cc[]" id="recipient_cc" multiple disabled>
										<?php foreach ($recipients as $recipient) {
											if ($recipient['user_type'] == 2) {
												echo "<option value='".$recipient['user_id']."' selected>".$recipient['first_name']."</option>";
											}
										}?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cname">Subject:</label>
								<div class="col-sm-7">
									<input class="form-control" type="text" name="subject" value="<?php echo $mail['subject'];?>" disabled />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="tname">Body:</label>
								<div class="col-sm-7">
									<textarea class="form-control" name="message" rows="8" disabled><?php echo $mail['message'];?></textarea>
								</div>
							</div>
							<?php foreach($attachments as $attachment):?><div class="form-group">
								<label class="control-label col-sm-2" for="cname">Attachment:</label>
								<div class="col-sm-3">
									<input class="form-control" type="text" name="displayfile" value="<?php echo $attachment['doc_code'];?>" disabled />
								</div>
								<div class="col-sm-1">
									<a href="<?php echo site_url(array('document','detail',$this->hashids->encode($attachment['attachment_id'])));?>"><button type="button" class="btn btn-primary"><span class='glyphicon glyphicon-file' aria-hidden='true'></span></button></a>
								</div>
							</div>
							<?php endforeach;?>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<a href="<?php echo site_url(array('mail','reply',$id_hash2));?>"><button type="button" class="btn btn-primary">Reply</button></a>
									<a href="<?php echo site_url(array('mail','forward',$id_hash2));?>"><button type="button" class="btn btn-primary">Forward</button></a>
									<a href="<?php echo site_url(array('mail','inbox',$id_hash));?>"><button type="button" class="btn btn-danger">Back</button></a>
								</div>
							</div>
						</form>
					</div>