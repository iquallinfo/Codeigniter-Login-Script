<!DOCTYPE html>
<html>
  <head>
 <?php $this->load->view('common/head'); ?>
   
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-box-body">
        <form  id="loginform" action="<?= base_url()?>users/getLogin" method="post">
        <div class="login-header">
        <div class="login-logo">
          <img src="<?= base_url()?>assets/images/logo.png" />
        </div><!-- /.login-logo -->
        <div class="login-box-msg"> 
            <h1>
                <i class="fa fa-lock"></i> <span class="blck">Login</span> <span class="red">Form</span>
            </h1>
        </div>
        </div>
        <div class="login-content">
             <?php if($this->session->flashdata('success')){?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="error">
                        <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <?= $this->session->flashdata('success') ?>
                        </div>
                    </div>
                </div>
            </div>
                
        <?php } ?>
          <div class="form-group has-feedback">
            <span class="fa fa-user-secret fa-2x form-control-feedback"></span>
            <input type="email" name="email" class="form-control" placeholder="Email" required="">
          </div>
          <div class="form-group has-feedback">
             <span class="fa fa-lock fa-2x form-control-feedback"></span>
             <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
           
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="checkbox text-right">
                <b>Show Password</b>: <label class="switch">
                    <input type="checkbox"  id="showpassword">
                    <div class="slider round"></div>
                  </label>
              </div>
            </div><!-- /.col -->
          </div>
            <?php if($this->session->flashdata('error')){?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="error">
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <?= $this->session->flashdata('error') ?>
                        </div>
                    </div>
                </div>
            </div>
                
        <?php } ?>
        </div>
        <div class="login-footer">
            <div class="col-xs-12">
            <div class="col-xs-6">
              <div class="forgot">
                Forgot your username or password? <a href="<?= base_url()?>users/forgot_password">Click here</a>
              </div>
            </div>
            <div class="col-xs-6">
            <div class="submitbtn">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign-In Now</button>
            </div><!-- /.col -->
            </div>
                <div class="signupnow">
                    Not registered? <a href="javascript;;" data-toggle="modal" data-target="#signupas">Create an account</a>
                </div>
            <div class="cleafix"></div>
            </div>
        </div>
         </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    
    <script src="<?= base_url()  ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= base_url()  ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!--    <script src="<?= base_url()  ?>assets/plugins/bootstrap-switch-master/js/bootstrap-switch.js"></script>
    <script>
        $("[name='my-checkbox']").bootstrapSwitch();
    </script>
    <script>
    $(document).ready(function(){
        $(".bootstrap-switch").click(function(){
           alert("hhhh");
        });
    });
    </script>-->
    <!-- Modal -->
    
    <div id="signupas" class="modal modal-red signuparea" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
              <h4 class="modal-title">Sign Up As</h4>
            </div>
            <div class="modal-body">
                <center>
                    <a href="<?= base_url() ?>users/signup?signupas=booker" class="btn btn-outline">Sign Up as Booker</a>
                    <a href="<?= base_url() ?>users/signup?signupas=fleetprovider" class="btn btn-outline">Sign Up as Fleet Provider</a>
                </center>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
    <script>
    $(document).ready(function(){
       $("#showpassword").change(function(){
           var ischk = $('#showpassword').is(":checked");
            if(ischk == true){
                $("#password").attr('type','text');
            }
            else{
                $("#password").attr('type','password');
            }
       }) 
    });
    </script>
  </body>

</html>

