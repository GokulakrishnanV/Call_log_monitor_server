<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link rel="icon" href="<?= base_url() ?>images/favicon.ico" type="image/ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Reset Password</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Reset Password</div>
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
                <form method="post" action="<?php echo base_url(); ?>resetpassword/validation">
                    <div class="form-group">
                        <label>Enter your registered email</label>
                        <input type="text" name="user_email" class="form-control" value="<?php echo set_value('user_email'); ?>" />
                        <span class="text-danger"><?php echo form_error('user_email'); ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="resetpassword" value="Reset Password" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>