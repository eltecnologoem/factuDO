<?php if(Alerts::check()): ?>
    <?php foreach(Alerts::get() as $m): ?>
        <div class="d-flex p-2 bd-highlight justify-content-center">
            <div class="alert alert-<?= $m['Alert'] ?>" role="alert">
            <strong><?= $m['MSG'] ?></strong>
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> -->
            </div>
        </div>
    <?php endforeach; Alerts::delete();?>
<?php endif ?>
