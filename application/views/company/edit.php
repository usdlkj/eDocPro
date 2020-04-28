					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('company/edit/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="cname">Company Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="cname" value="<?php echo $company['company_name'];?>" required />
								</div>
								<div class="form-group">
									<label for="tname">Trading Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="tname" value="<?php echo $company['trading_name'];?>" required />
								</div>
								<div class="form-group">
									<label for="ccode">Company Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="ccode" value="<?php echo $company['company_code'];?>" pattern="\w*" required />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Submit</button> <a href="<?php echo site_url(array('company','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>