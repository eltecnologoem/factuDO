<?php

if ($alerts = Alerts::get()) {
    foreach ($alerts as $alert) {
        echo '<div class="alert alert-' . $alert['Alert'] . '">' . $alert['MSG'] . '</div>';
        //echo '<button type="button" class="btn btn-' . $alert['Alert'] . ' toastsDefault' . ucfirst($alert['Alert']) . '">' . $alert['MSG'] . '</button>';
    }

    Alerts::delete();
}
