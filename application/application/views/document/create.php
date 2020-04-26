					<script>
					$(document).ready( function () {
						var dp = $('.datepicker').datepicker( {
							format: 'dd/mm/yyyy'
						} ).on('changeDate', function(ev) {
							dp.datepicker('hide');
						} );
						
						$(".select2").select2();
					} );
					</script>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
					<div class="card-body">
						<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
						
						<?php echo form_open_multipart('document/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
						<?php foreach ($fields as $field):?>
							<div class="form-group">
								<label for="<?php echo $field['field_code'];?>"><?php echo $field['field_text'];?>:<?php if($field['mandatory']):?> <span class="required">*</span><?php endif;?></label>
								<?php if ($field['field_type'] == 1):?>
								<input class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								<?php elseif ($field['field_type'] == 2):?>
								<input class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								<?php elseif ($field['field_type'] == 3):?>
								<textarea class="form-control" type="text" name="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?>></textarea>
								<?php elseif ($field['field_type'] == 4):?>
								<input class="form-control datepicker" type="text" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?> />
								<?php elseif ($field['field_type'] == 5):?>
								<select class="form-control select2" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>"<?php if($field['mandatory']):?> required<?php endif;?>>
									<?php foreach ($selections as $select):?>
									<?php if ($select['field_id'] == $field['id']):?>
									<option value="<?php echo $select['id'];?>"><?php echo $select['value_text'];?></option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
								<?php elseif ($field['field_type'] == 6):?>
								<select class="form-control select2" name="<?php echo $field['field_code'];?>[]" id="<?php echo $field['field_code'];?>" multiple<?php if($field['mandatory']):?> required<?php endif;?>>
									<?php foreach ($selections as $select):?>
									<?php if ($select['field_id'] == $field['id']):?>
									<option value="<?php echo $select['id'];?>"><?php echo $select['value_text'];?></option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
								<?php endif;?>
							</div>
							<?php endforeach;?>
							
							<div class="form-group">
								<label for="userfile">File:</label>
								<input class="btn btn-default" type="file" name="userfile" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Upload</button> <a href="<?php echo site_url(array('document','view',$project_id));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
							</div>
						</form>
					</div>