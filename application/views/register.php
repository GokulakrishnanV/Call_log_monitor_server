<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="icon" href="<?= base_url() ?>images/favicon.ico" type="image/ico"/>
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Registration</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Register</div>
            <div class="panel-body">
                <?php
                if ($this->session->flashdata('message')) {
                    echo '
                    <div class="alert alert-danger">
                        ' . $this->session->flashdata("message") . '
                    </div>
                    ';
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>register/validation">
                    <div class="form-group">
                        <label>Enter your name</label>
                        <input type="text" name="user_name" class="form-control" value="<?php echo set_value('user_name'); ?>" />
                        <span class="text-danger"><?php echo form_error('user_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter a valid email</label>
                        <input type="text" name="user_email" class="form-control" value="<?php echo set_value('user_email'); ?>" />
                        <span class="text-danger"><?php echo form_error('user_email'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Enter new password</label>
                        <input type="password" name="user_password" class="form-control" value="<?php echo set_value('user_password'); ?>" />
                        <span class="text-danger"><?php echo form_error('user_password'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="register" value="Register" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>