    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form class="user" method="post" action="<?= base_url('auth/register?version=auth2') ?>">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input name="firstName" value="<?= set_value('firstName');?>" type="text" class="form-control form-control-user" id="exampleFirstName"
                                                    placeholder="First Name">
                                                <?= form_error('firstName', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="lastName" value="<?= set_value('lastName');?>" type="text" class="form-control form-control-user" id="exampleLastName"
                                                    placeholder="Last Name">
                                                <?= form_error('lastName', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="email" value="<?= set_value('email');?>" type="email" class="form-control form-control-user" id="exampleInputEmail"
                                                placeholder="Email Address">
                                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>');?>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input name="password" value="<?= set_value('password');?>" type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password">
                                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="repeat_password" value="<?= set_value('repeat_password');?>" type="password" class="form-control form-control-user"
                                                    id="exampleRepeatPassword" placeholder="Repeat Password">
                                                <?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Register with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/forgot_password?version=auth2') ?>">Forgot Password?</a>
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