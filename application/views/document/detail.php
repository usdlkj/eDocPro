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
					
					<div class="form-horizontal">
						<div class="form-style-2">
							<?php foreach ($fields as $field):?><div class="form-group">
								<label class="control-label col-sm-2" for="<?php echo $field['field_code'];?>"><?php echo $field['field_text'];?>:</label>
								<?php if ($field['field_type'] == 1):?><div class="col-sm-1">
									<input class="form-control" type="text" name="<?php echo $field['field_code'];?>" value="<?php echo $field['field_value'];?>" disabled />
								</div><?php elseif ($field['field_type'] == 2):?><div class="col-sm-4">
									<input class="form-control" type="text" name="<?php echo $field['field_code'];?>" value="<?php echo $field['field_value'];?>" disabled />
								</div><?php elseif ($field['field_type'] == 3):?><div class="col-sm-4">
									<textarea class="form-control" type="text" name="<?php echo $field['field_code'];?>" disabled><?php echo $field['field_value'];?></textarea>
								</div><?php elseif ($field['field_type'] == 4):?><div class="col-sm-2">
									<input class="form-control datepicker" type="text" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>" value="<?php echo $field['field_value'];?>" disabled />
								</div><?php elseif ($field['field_type'] == 5):?><div class="col-sm-3">
									<select class="form-control select2" name="<?php echo $field['field_code'];?>" id="<?php echo $field['field_code'];?>" disabled>
										<?php foreach ($selections as $select):?><?php if ($select['field_id'] == $field['id']):?><option value="<?php echo $select['id'];?>"<?php if ($select['id'] == $field['field_value']):?> selected<?php endif;?>><?php echo $select['value_text'];?></option>
										<?php endif;?><?php endforeach;?>
									
									</select>
								</div><?php elseif ($field['field_type'] == 6):?><div class="col-sm-4">
									<select class="form-control select2" name="<?php echo $field['field_code'];?>[]" id="<?php echo $field['field_code'];?>" multiple disabled>
										<?php foreach ($selections as $select): if ($select['field_id'] == $field['id']):?><option value="<?php echo $select['id'];?>"<?php if (in_array($select['id'],$field['field_value'])):?> selected<?php endif;?>><?php echo $select['value_text'];?></option>
										<?php endif; endforeach;?>
									
									</select>
								</div><?php endif;?>
								
							</div>
							<?php endforeach;?>
							
							<?php if ($file_id > 0):?><div class="form-group">
								<label class="control-label col-sm-2" for="displayfile">File:</label>
								<div class="col-sm-3">
									<input class="form-control" type="text" name="displayfile" value="<?php echo $file_name;?>" disabled />
								</div>
								<div class="col-sm-1">
									<a href="<?php echo site_url(array('file','download',$this->hashids->encode($file_id)));?>"><button type="button" class="btn btn-success"><span class='glyphicon glyphicon-file' aria-hidden='true'></span></button></a>
								</div>
							</div><?php endif;?>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<a href="<?php echo site_url(array('document','supersede',$id_hash));?>"><button type="button" class="btn btn-primary">Supersede</button></a> <a href="<?php echo site_url(array('document','view',$project_id));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</div>
					</div>