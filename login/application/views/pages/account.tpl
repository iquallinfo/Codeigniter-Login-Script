<div id="wrapper">
 <div id="page" class="container">
   <div id="content">
    <div id="stwo-col">
     <div class="sbox1">
	<h2>Manage Account</h2>
          <?php if($msg){ ?>
             <div class="validation_pass">
                <p><?= $msg ?></p>
             </div>    
          
          <?php }else if(validation_errors()){ ?>
             <div class="validation_pass"><?= validation_errors() ?></div>
          
          <?php } echo form_open('admin/chg_password') ?> 
          <input placeholder="Enter Current Password" class="input" type="password" name="current_pwd" /><br />
          <input placeholder="Enter New Password" class="input" type="password" name="password" /><br />
          <input placeholder="Confirm Password" class="input" type="password" name="confirm_pwd" /><br />
          <input class="button" type="submit" name="submit" value="Change Password" />
         </form>
     </div>  
    </div>
  </div>
</div>

