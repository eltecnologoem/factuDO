<?php /*
    Este modulo espera la variable numerica $page, verificara que exista una peticion get con el parametro 'page' para determinar en que pagina se encuentra.
    Si no existe la variable $pages, no se mostrara el modulo.
    Si no existe la variable $_GET[_page'], el valor sera 1.
    */ ?>
<?php if (isset($pagination) && !empty($pagination->links)) : ?>
    <div class="col-sm-12">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm justify-content-center">
                <?php foreach ($pagination->links as $link): ?>
                    <?php
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    ?>
                    <?php if ($link->label == '« Anterior'): ?>
                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="/invoices?page=<?= $currentPage - 1 ?>">
                                <i class="fas fa-chevron-left"></i> Anterior
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($link->label == 'Siguiente »'): ?>
                        <li class="page-item <?= $currentPage >= $pagination->last_page ? 'disabled' : '' ?>">
                            <a class="page-link" href="/invoices?page=<?= $currentPage + 1 ?>">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($link->url)): ?>
                        <li class="page-item <?= $link->label == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= is_numeric($link->label) ? '/invoices?page=' . $link->label : '' ?>">
                                <?php if ($link->label == '« Anterior'): ?>
                                    <i class="fas fa-chevron-left"></i> Anterior
                                <?php endif; ?>
                                <?php if ($link->label == 'Siguiente »'): ?>
                                    Siguiente <i class="fas fa-chevron-right"></i>
                                <?php else: ?>
                                    <?= $link->label ?>
                                <?php endif; ?>
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if ($link->label == '...'): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>