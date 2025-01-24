<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <a href="/invoices/create" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Create Invoice
                                    </a>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <form id="searchForm" action="/invoices" method="POST" class="d-flex gap-2">
                                        <div class="input-group">
                                            <select class="form-control" id="searchField" name="search_field">
                                                <option value="names">Nombres</option>
                                                <option value="identification">Identificación</option>
                                                <option value="status">Estado</option>
                                            </select>
                                            <input type="text" id="searchInput" name="search_value" class="form-control" placeholder="Buscar...">
                                            <button type="submit" id="searchButton" class="btn btn-primary" disabled>
                                                <i class="fas fa-search"></i> Buscar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                                    ID
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Client
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Number
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                    Status
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                                    Invoice Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                    Total
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $invoice): ?>
                                                <tr class="odd">
                                                    <td class="dtr-control sorting_1" tabindex="0"><?= $invoice->id ?? null ?></td>
                                                    <td><?= $invoice->names ?? null ?></td>
                                                    <td><?= $invoice->number ?? null ?></td>
                                                    <td><span class="badge badge-<?= $invoice->status ? 'success' : 'warning' ?>"><?= $invoice->status ? 'Completed' : 'Pending' ?></span></td>
                                                    <td><?= $invoice->created_at ?? null ?></td>
                                                    <td><?= $invoice->total ?? null ?></td>
                                                    <td>
                                                        <a href="/invoices/show/<?= $invoice->number ?? null ?>" target="_blank" class="btn btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-success<?= !$invoice->number ? ' disabled' : '' ?>" href="<?= "/invoices/download/$invoice->number/pdf" ?? '#' ?>" onclick="window.open(this.href, '_blank', 'width=0,height=0'); return false;">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a class="btn btn-secondary<?= !$invoice->number ? ' disabled' : '' ?>" href="<?= "/invoices/download/$invoice->number/xml" ?? '#' ?>" onclick="window.open(this.href, '_blank', 'width=0,height=0'); return false;">
                                                            <i class="fas fa-file-code"></i>
                                                        </a>
                                                        <a href="<?= "/invoices/edit/$invoice->id" ?? '#' ?>" class="btn btn-primary<?= !$invoice->id ? ' disabled' : '' ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= "/invoices/delete/$invoice->reference_code" ?? '#' ?>" class="btn btn-danger<?= !$invoice->reference_code ? ' disabled' : '' ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">ID</th>
                                                <th rowspan="1" colspan="1">Number</th>
                                                <th rowspan="1" colspan="1">Status</th>
                                                <th rowspan="1" colspan="1">Invoice Date</th>
                                                <th rowspan="1" colspan="1">Total</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <?php if (isset($pagination)): ?>
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing 1 to <?= $pagination->per_page ?? null ?> of <?= $pagination->total ?? null ?> records
                                </div>
                                <?php Get::modules('paginations/pagination', ['pagination' => $pagination]) ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchField = document.getElementById('searchField');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const searchForm = document.getElementById('searchForm');

        // Función para manejar el cambio de tipo de búsqueda
        searchField.addEventListener('change', function() {
            searchInput.value = '';
            searchButton.disabled = true;

            if (this.value === 'status') {
                // Convertir input a select para estado
                const selectHTML = `
                <select class="form-control" name="search_value" id="searchInput">
                    <option value="">Seleccionar estado</option>
                    <option value="completed">Completado</option>
                    <option value="pending">Pendiente</option>
                </select>
            `;
                searchInput.outerHTML = selectHTML;
            } else {
                // Convertir select a input text si no es estado
                if (searchInput.tagName === 'SELECT') {
                    const inputHTML = `
                    <input type="text" id="searchInput" name="search_value" 
                           class="form-control" placeholder="Buscar...">
                `;
                    searchInput.outerHTML = inputHTML;
                }
            }
        });

        // Delegación de eventos para manejar cambios en input/select
        document.addEventListener('input', function(e) {
            if (e.target.id === 'searchInput') {
                searchButton.disabled = !e.target.value.trim();
            }
        });

        // Manejar cambios en select de estado
        document.addEventListener('change', function(e) {
            if (e.target.id === 'searchInput' && searchField.value === 'status') {
                searchButton.disabled = !e.target.value;
            }
        });

        // Manejar envío del formulario
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!searchButton.disabled) {
                this.submit();
            }
        });
    });
</script>