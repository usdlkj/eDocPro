					<script>
					$(document).ready( function () {
						var dp = $('.datepicker').datepicker( {
							format: 'dd/mm/yyyy'
						} ).on('changeDate', function(ev) {
							dp.datepicker('hide');
						} );
						
						$('.select2').select2( {
							theme: 'bootstrap'
						} );
					} );
					</script>
					
					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open_multipart('document/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<?php foreach ($fields as $field):?><div class="form-group">
								<label class="control-label col-sm-2" for="<?php echo $field['field_code'];?>"><?php echo $field['field_text'];?>:<?php if($field['mandatory']):?> <span class="required">*</span><?php endif;?></label>
								<?php if ($field['field_type'] == 1):?><div class="col-sm-1">
									<input class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								</div><?php elseif ($field['field_type'] == 2):?><div class="col-sm-4">
									<input class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								</div><?php elseif ($field['field_type'] == 3):?><div class="col-sm-4">
									<textarea class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?>></textarea>
								</div><?php elseif ($field['field_type'] == 4):?><div class="col-sm-2">
									<input class="form-control datepicker" type="text" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								</div><?php elseif ($field['field_type'] == 5):?><div class="col-sm-3">
									<select class="form-control select2" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?>>
										<?php foreach ($selections as $select):?><?php if ($select['field_id'] == $field['id']):?><option value="<?php echo $select['id'];?>"><?php echo $select['value_text'];?></option>
										<?php endif;?><?php endforeach;?>
									
									</select>
								</div><?php elseif ($field['field_type'] == 6):?><div class="col-sm-4">
									<select class="form-control select2" name="<?php echo $field['field_code'];?>[]" id="<?php echo $field['field_code'];?>" multiple<?php if($field['mandatory']):?> required<?php endif;?>>
										<?php foreach ($selections as $select):?><?php if ($select['field_id'] == $field['id']):?><option value="<?php echo $select['id'];?>"><?php echo $select['value_text'];?></option>
										<?php endif;?><?php endforeach;?>
									
									</select>
								</div><?php endif;?>
								
								<?php if($field['mandatory']):?><div class="help-block with-errors"></div><?php endif;?>
							
							</div>
							<?php endforeach;?>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="userfile">File:</label>
								<div class="col-sm-4">
									<input class="btn btn-default" type="file" name="userfile" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Upload</button> <a href="<?php echo site_url(array('document','view',$project_id));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>