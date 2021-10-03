<?php
include("header.php");
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab">
                            <h4> Forgot Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post" id="frmForgotPassword">
                                        <input type="email" name="user_email" placeholder="Email" required>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <a href="<?php echo FRONT_SITE_PATH?>login_register">Login</a>
                                            </div>
                                            <button type="submit" id="forgot_submit"><span>Submit</span></button>
                                            <input type="hidden" name="type" value="forgot" />
                                            <div id="form_forgot_msg" style="margin-top: 18px; margin-bottom: 3px; color: green;font: bolder;font-size: larger;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include("footer.php");
?>