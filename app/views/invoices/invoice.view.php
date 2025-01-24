<div class="invoice p-3 mb-3">
    <div class="container" id="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <img src="<?= $invoice['company']->url_logo ?? null ?>" alt="Logo" class="img-fluid" style="width: 100px; height: auto;">
                    <?= $invoice['company']->name ?? null ?>
                    <small class="float-right">Date: <?= $invoice['bill']->created_at ?? null ?></small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <?= $invoice['company']->direction ?? null ?><br>
                    <?= $invoice['company']->municipality ?? null ?><br>
                    <?= $invoice['company']->phone ?? null ?><br>
                    <?= $invoice['company']->email ?? null ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                Client
                <address>
                    Names: <strong><?= $invoice['customer']->names ?? null ?></strong><br>
                    Identification: <?= $invoice['customer']->identification ?? null ?><br>
                    Company: <?= $invoice['customer']->company ?? null ?><br>
                    Address: <?= $invoice['customer']->address ?? null ?><br>
                    Phone: <?= $invoice['customer']->phone ?? null ?><br>
                    Email: <?= $invoice['customer']->email ?? null ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #<?= $invoice['bill']->number ?? null ?></b><br>
                <br>
                <b>Order ID:</b> <?= $invoice['bill']->reference_code ?? null ?><br>
                <b>Payment Due:</b> <?= $invoice['bill']->created_at ?? null ?><br>
                <b>Status:</b> <span class="badge badge-<?= $invoice['bill']->status ? 'success' : 'danger' ?>"><?= $invoice['bill']->status ? 'Paid' : 'Pending' ?></span><br>
                <b>Validated:</b> <span class="badge badge-<?= $invoice['bill']->validated ? 'success' : 'danger' ?>"><?= $invoice['bill']->validated ? 'Yes' : 'No' ?></span> <?= $invoice['bill']->validated ?? null ?><br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoice['items'] as $item): ?>
                            <tr>
                                <td><?= $item->code_reference ?? null ?></td>
                                <td><?= $item->name ?? null ?></td>
                                <td><?= $item->quantity ?? null ?></td>
                                <td><?= $item->price ?? null ?></td>
                                <td><?= $item->discount ?? null ?></td>
                                <td><?= $item->tax_amount ?? null ?></td>
                                <td><?= $item->total ?? null ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">Payment details:</p>
                <div class="row">
                    <div class="col-6">
                        <div class="text-align-left">
                            <p>
                                Payment Form: <?= $invoice['bill']->payment_form->name ?? null ?>
                            </p>
                            <p>
                                Payment Method: <?= $invoice['bill']->payment_method->name ?? null ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-align-right">
                            <p>
                                <strong>QR Code</strong>
                            </p>
                            <img class="img-fluid" src="<?= $invoice['bill']->qr_image ?? null ?>" alt="Logo">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">Amount Due <?= $invoice['bill']->created_at ?? null ?></p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>$<?= $invoice['bill']->taxable_amount ?? null ?></td>
                            </tr>
                            <tr>
                                <th>Tax:</th>
                                <td>$<?= $invoice['bill']->tax_amount ?? null ?></td>
                            </tr>
                            <tr>
                                <th>Discount:</th>
                                <td>$<?= $invoice['bill']->discount ?? null ?></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>$<?= $invoice['bill']->total ?? null ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="#" onclick="printInvoice()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <a href="<?= $invoice['bill']->qr ?>" target="_blank" class="btn btn-info float-right" style="margin-right: 5px;">
                <i class="fas fa-eye"></i> DIAN
            </a>
            <a href="/invoices/download/<?= $invoice['bill']->number?>/pdf" onclick="window.open(this.href, '_blank', 'width=0,height=0'); return false;" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="/invoices/download/<?= $invoice['bill']->number?>/xml" onclick="window.open(this.href, '_blank', 'width=0,height=0'); return false;" class="btn btn-secondary float-right" style="margin-right: 5px;">
                <i class="fas fa-file-code"></i> Download XML
            </a>
        </div>
    </div>
</div>

<script>
    // Función para imprimir la factura
    function printInvoice() {
        const invoiceContent = document.getElementById('invoice').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = invoiceContent;

        // Removemos la sección no-print
        const noPrintSection = document.querySelector('.no-print');
        if (noPrintSection) {
            noPrintSection.remove();
        }

        window.print();

        // Restauramos el contenido original
        document.body.innerHTML = originalContent;
    }


    // Actualizar los botones en el HTML
    document.addEventListener('DOMContentLoaded', function() {
        // Reemplazar los enlaces con botones
        const printBtn = document.querySelector('a[rel="noopener"]');
        printBtn.onclick = function(e) {
            e.preventDefault();
            printInvoice();
        };

        const downloadBtn = document.querySelector('a.btn-primary');
        downloadBtn.onclick = function(e) {
            e.preventDefault();
            downloadInvoicePDF();
        };
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>