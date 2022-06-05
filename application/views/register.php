<div class="container-fluid">
  <div class="card col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5 mx-auto my-5">
    <div class="card-header text-center">
      <h3 class="my-2">Register</h3>
    </div>
    <div class="card-body">
      <form method="post" action="<?= $action ?>">
        <?php foreach ($input_form as $i) :?>
          <?php if ($i['column'] == 'single'):?>
            <div class="form-floating mb-3">
              <input type="<?= $i['type'] ?>" class="form-control" id="<?= $i['name'] ?>" name="<?= $i['name'] ?>" placeholder="<?= $i['placeholder'] ?>">
              <label for="<?= $i['name'] ?>"><?= $i['label'] ?></label>
              <?= form_error($i['name'], '<small class="text-danger pl-3">', '</small>');?>
            </div>
          <?php elseif ($i['column'] == 'split1'):?>
            <div class="row g-2">
              <div class="col-md">
                <div class="form-floating mb-3">
                  <input type="<?= $i['type'] ?>" class="form-control" id="<?= $i['name'] ?>" name="<?= $i['name'] ?>" placeholder="<?= $i['placeholder'] ?>">
                  <label for="<?= $i['name'] ?>"><?= $i['label'] ?></label>
                  <?= form_error($i['name'], '<small class="text-danger pl-3">', '</small>');?>
                </div>
              </div>
          <?php elseif ($i['column'] == 'split2'):?>
              <div class="col-md">
                <div class="form-floating mb-3">
                  <input type="<?= $i['type'] ?>" class="form-control" id="<?= $i['name'] ?>" name="<?= $i['name'] ?>" placeholder="<?= $i['placeholder'] ?>">
                  <label for="<?= $i['name'] ?>"><?= $i['label'] ?></label>
                  <?= form_error($i['name'], '<small class="text-danger pl-3">', '</small>');?>
                </div>
              </div>
            </div>
          <?php endif?>
        <?php endforeach?>
        <button type="submit" class="btn btn-<?= $submit['bg'] ?> col-12 mt-2"><?= $submit['label'] ?></button>
      </form>
    </div>
    <div class="card-footer text-center my-2">
      <a href="">Have an account? Go to login</a>
    </div>
  </div>
</div>