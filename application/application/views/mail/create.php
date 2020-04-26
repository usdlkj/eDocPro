					<script>
					$(document).ready( function () {
						$( '.select2' ).select2( {
							theme: 'bootstrap'
						} );
						
						var table = $( '#data_table' ).DataTable( {
							"ajax": "<?php echo site_url(array('document','ajax_latest_docs',$id_hash2));?>",
							"order": [[ 1, "asc" ]],
							select: 'multi',
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>",
							buttons: [
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
						
						$( '#closeModal' ).on( 'click', function () {
							var docids 		= table.cells( '.selected' , 0 ).data();
							var doccodes 	= table.cells( '.selected' , 1 ).data();
							var doctitles 	= table.cells( '.selected' , 2 ).data();
							jQuery.each( doccodes , function( i , val ) {
								var divAtt = $( '#divAttTemplate' ).clone().attr( 'id', 'attachment'+i ).appendTo( $( '#divAttachments' ) ).removeClass( 'hide' );
								divAtt.find( 'input[type="text"]' ).val( doccodes[ i ] + ' ' + doctitles[ i ] );
								divAtt.find( 'input[type="hidden"]' ).val( docids[ i ] );
							} );
							table.rows().deselect();
						} );
						
						$( '#divAttachments' ).on( 'click' , '.att-remove' , function () {
							$( this ).parent( 'div' ).parent( 'div' ).remove();
						} );
					} );
					</script>
					
					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('mail/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="mail_type">Mail Type: <span class="required">*</span></label>
								<div class="col-sm-4">
									<select class="form-control select2" name="mail_type" id="mail_type" required>
										<?php foreach ($mail_types as $mail_type):?><option value="<?php echo $mail_type['id'];?>"><?php echo $mail_type['mail_type'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="recipient_to">To: <span class="required">*</span></label>
								<div class="col-sm-7">
									<select class="form-control select2" name="recipient_to[]" id="recipient_to" placeholder="To" multiple required>
										<?php foreach ($recipients as $recipient):?><option value="<?php echo $recipient['user_id'];?>"<?php if (isset($sender_id) && $sender_id == $recipient['user_id']):?> selected<?php endif;?>><?php echo $recipient['first_name'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="recipient_cc">Cc:</label>
								<div class="col-sm-7">
									<select class="form-control select2" name="recipient_cc[]" id="recipient_cc" placeholder="Cc" multiple>
										<?php foreach ($recipients as $recipient):?><option value="<?php echo $recipient['user_id'];?>"><?php echo $recipient['first_name'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="recipient_bcc">Bcc:</label>
								<div class="col-sm-7">
									<select class="form-control select2" name="recipient_bcc[]" id="recipient_bcc" placeholder="Bcc" multiple>
										<?php foreach ($recipients as $recipient):?><option value="<?php echo $recipient['user_id'];?>"><?php echo $recipient['first_name'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cname">Subject: <span class="required">*</span></label>
								<div class="col-sm-7">
									<input class="form-control" type="text" name="subject" placeholder="Mail Subject"<?php if (isset($subject)) echo ' value="'.$subject.'"';?> required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="tname">Body: <span class="required">*</span></label>
								<div class="col-sm-7">
									<textarea class="form-control" name="message" placeholder="Mail Body" rows="8"><?php if (isset($body)):?>&#13;----------------------------------------------&#13;<?php echo $body; endif;?></textarea>
								</div>
							</div>
							<div id="divAttachments">
								
							</div>
							<div id="divAttTemplate" class="form-group attachment hide">
								<label class="control-label col-sm-2">Attachment:</label>
								<div class="col-sm-3">
									<input name="attachments[]" type="hidden" /><input type="text" class="form-control" disabled />
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger att-remove"><span class="glyphicon glyphicon-remove"></span></button>
								</div>
							</div>	
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Send Mail</button> <button type="button" id="btnOpenDialog" class="btn btn-info" data-toggle="modal" data-target="#myModal">Documents</button> <a href="<?php echo site_url(array('mail','inbox',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
							
							<div id="myModal" class="modal fade" role="dialog">
								<div class="modal-dialog modal-lg">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Document Register</h4>
										</div>
										<div class="modal-body">
										<table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th></th>
												<?php foreach ($fields as $field):?><th><?php echo $field['field_text'];?></th>
												<?php endforeach;?>
											
											</tr>
										</thead>
										</table>
										</div>
										<div class="modal-footer">
											<button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Attach Document</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>