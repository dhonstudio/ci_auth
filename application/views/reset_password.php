        <div id="layoutAuthentication"> 
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Enter your new password.</div>
                                        <form method="post" action="<?= base_url("auth/reset_password?email={$email}&token={$token}") ?>">
                                            <div class="form-floating mb-3">
                                                <input name="password" value="<?= set_value('password');?>" class="form-control" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input name="repeat_password" class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm Password" />
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                                <?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>');?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="<?= base_url('auth') ?>">Return to login</a>
                                                <button type="submit" class="btn btn-primary" href="login.html">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="<?= base_url('auth/register') ?>">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>