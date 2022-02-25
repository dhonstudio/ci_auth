<div class="container mb-5">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Password Recovery</h1>
                                    <p class="mb-4">Enter your new password.</p>
                                </div>
                                <form class="user" method="post" action="<?= base_url("auth/reset_password?email={$email}&token={$token}&version=auth2") ?>">
                                    <div class="form-group">
                                        <input name="password" value="<?= set_value('password');?>" type="password" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="passwordHelp"
                                            placeholder="Enter Your New Password...">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                                    </div>
                                    <div class="form-group">
                                        <input name="repeat_password" value="<?= set_value('repeat_password');?>" type="password" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="repeatPasswordHelp"
                                            placeholder="Repeat Enter Your New Password...">
                                        <?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>');?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/register?version=auth2') ?>">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('?version=auth2') ?>">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>