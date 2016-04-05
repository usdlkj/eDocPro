					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('selectvalue/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="value_code">Selection Code: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="value_code" placeholder="Selection Code" pattern="\w*" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="value_text">Selection Text: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="value_text" placeholder="Selection Text" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('selectvalue','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>