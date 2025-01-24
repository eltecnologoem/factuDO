<?php /*
    Este modulo espera la variable numerica $page, verificara que exista una peticion get con el parametro 'page' para determinar en que pagina se encuentra.
    Si no existe la variable $pages, no se mostrara el modulo.
    Si no existe la variable $_GET[_page'], el valor sera 1.
*/ ?>
<?php if (isset($pages) and !empty($pages) and is_numeric($pages)) : ?>
    <div class="col-sm-12">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm justify-content-center">
                <?php
                    $uri = Http::uri();
                    if(!$currentPage = Request::getKey($_GET, 'page')){
                        $currentPage = 1;
                    }

                    // Eliminar el parámetro 'page' existente de la URL
                    $uri = preg_replace('/(&|\?)?page=\d+/', '', $uri);

                    // Asegurarse de que la URL tenga el formato correcto antes de agregar 'page'

                    if (strpos($uri, '?') !== false) {
                        // Si ya hay un parámetro 'get', agregamos '&page='
                        $uri .= '&page=';
                    } else {
                        // Si no hay parámetros 'get', agregamos '?page='
                        $uri .= '?page=';
                    }

                    // Configuración de la ventana de paginación
                    $windowSize = 30;
                    $halfWindowSize = floor($windowSize / 2);

                    $start = max(1, $currentPage - $halfWindowSize);
                    $end = min($pages, $start + $windowSize - 1);

                    // Ajustar el inicio si estamos al final de las páginas
                    $start = max(1, $end - $windowSize + 1);

                    // Botón para ir a la página anterior
                    if ($currentPage > 1) {
                        echo '<li class="page-item"><a class="page-link" href="' . $uri . ($currentPage - 1) . '">Anterior</a></li>';
                    }

                    // Números de página
                    for ($i = $start; $i <= $end; $i++) {
                        echo '<li class="page-item ' . (($currentPage == $i) ? 'active' : '') . '"><a class="page-link" href="' . $uri . $i . '">' . $i . '</a></li>';
                    }

                    // Botón para ir a la página siguiente
                    if ($currentPage < $pages) {
                        echo '<li class="page-item"><a class="page-link" href="' . $uri . ($currentPage + 1) . '">Siguiente</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>