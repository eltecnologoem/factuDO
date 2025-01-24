<!-- Contenido principal -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Formulario principal de Factura -->
        <div class="card card-primary">
          <div class="card-body">
            <!-- Ajusta el action y method para tu MVC -->
            <form id="invoiceForm" action="/invoices/store" method="POST">
              <!-- Encabezado - Filas principales -->
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Rango de Numeración</label>
                    <select class="form-control select2" style="width: 100%;" name="numbering_range_id">
                      <option value="8" selected>Factura de Venta (8)</option>
                      <option value="9">Nota Crédito (9)</option>
                      <option value="10">Nota Débito (10)</option>
                      <!-- Agrega más si los tuvieras -->
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Código de Referencia</label>
                    <input type="text" class="form-control" name="reference_code" value="<?= rand(100000, 999999) ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Observación</label>
                    <input type="text" class="form-control" name="observation" value="Factura de Venta creada por Eliezer con fines de prueba">
                  </div>
                </div>
              </div>
              <!-- /.row -->

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Forma de Pago</label>
                    <select class="form-control select2" style="width: 100%;" name="payment_form">
                      <option value="1" selected>Contado</option>
                      <option value="2">Crédito</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Fecha de Vencimiento</label>
                    <div class="input-group date" id="payment_due_date" data-target-input="nearest">
                      <input type="date" class="form-control datetimepicker-input" data-target="#payment_due_date" name="payment_due_date" value="<?= date('Y-m-d', strtotime('+1 month')) ?>" />
                      <div class="input-group-append" data-target="#payment_due_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Método de Pago</label>
                    <select class="form-control select2" style="width: 100%;" name="payment_method_code" value="10">
                      <option value="10" selected>Efectivo</option>
                      <option value="11">Cheque</option>
                      <option value="12">Tarjeta de Crédito</option>
                      <option value="13">Tarjeta de Débito</option>
                      <option value="14">Transferencia Electrónica</option>
                      <option value="15">Depósito Bancario</option>
                      <option value="16">Pago en Línea</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.row -->

              <!-- Periodo de Facturación -->
              <h5 class="mt-4">Periodo de Facturación</h5>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <div class="input-group date" id="billing_start_date" data-target-input="nearest">
                      <input type="date" class="form-control" name="billing_period[start_date]" value="<?= date('Y-m-d') ?>" />
                      <div class="input-group-append" data-target="#billing_start_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Hora Inicio</label>
                    <div class="input-group date" id="billing_start_time" data-target-input="nearest">
                      <input type="time" class="form-control" name="billing_period[start_time]" value="<?= date('H:i:s') ?>" />
                      <div class="input-group-append" data-target="#billing_start_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Fecha Fin</label>
                    <div class="input-group date" id="billing_end_date" data-target-input="nearest">
                      <input type="date" class="form-control" name="billing_period[end_date]" value="<?= date('Y-m-d', strtotime('+5 days')) ?>" />
                      <div class="input-group-append" data-target="#billing_end_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Hora Fin</label>
                    <div class="input-group date" id="billing_end_time" data-target-input="nearest">
                      <input type="time" class="form-control" name="billing_period[end_time]" value="18:00:00" />
                      <div class="input-group-append" data-target="#billing_end_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row -->

              <!-- Información del Cliente -->
              <h5 class="mt-4">Información del Cliente</h5>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Identificación</label>
                    <input type="text" class="form-control" name="customer[identification]" value="425259469">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label>DV</label>
                    <input type="text" class="form-control" name="customer[dv]" value="3">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" name="customer[names]" value="Eliezer M.">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="customer[phone]" value="8095555555">
                  </div>
                </div>
              </div>
              <!-- segunda fila de customer -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name="customer[address]" value="Av. 27 de febrero # 100">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="customer[email]" value="developers@molinatec.com">
                  </div>
                </div>
              </div>
              <!-- tercera fila -->
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Company</label>
                    <input type="text" class="form-control" name="customer[company]" value="Molina Tech">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Trade Name</label>
                    <input type="text" class="form-control" name="customer[trade_name]" value="Molina Tech">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Legal Org. ID</label>
                    <input type="text" class="form-control" name="customer[legal_organization_id]" value="2">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tribute ID</label>
                    <input type="text" class="form-control" name="customer[tribute_id]" value="21">
                  </div>
                </div>
              </div>
              <!-- cuarta fila -->
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Ident. Doc. ID</label>
                    <input type="text" class="form-control" name="customer[identification_document_id]" value="3">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Municipality ID</label>
                    <input type="text" class="form-control" name="customer[municipality_id]" value="980">
                  </div>
                </div>
              </div>

              <!-- Items -->
              <h5 class="mt-4">Items</h5>
              <div class="items-container">
                <!-- Plantilla oculta, clonada con JS -->

                <!-- Fin .item-template -->

                <!-- Contenedor real para items generados -->
                <div id="itemsList"></div>
  
                <!-- Botón para agregar un item -->
                <button type="button" class="btn btn-success btn-sm" id="addItemBtn">
                  <i class="fas fa-plus"></i> Agregar Item
                </button>
              </div>
              <!-- /.items-container -->

              <hr>

              <!-- Botón final -->
              <button type="submit" class="btn btn-primary float-right">Guardar Factura</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<!-- Reemplazar todos los scripts anteriores por nuestro JavaScript vanilla -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;

    // Función para manejar los selects
    function initializeCustomSelects() {
      document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          this.setAttribute('value', selectedOption.value);
        });
      });
    }

    // Función para manejar los datepickers
    function initializeDateInputs() {
      // Manejar campos de fecha
      const dateInputs = ['payment_due_date', 'billing_start_date', 'billing_end_date'];
      dateInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          input.type = 'date';
          if (input.getAttribute('value')) {
            input.value = input.getAttribute('value');
          }
        }
      });

      // Manejar campos de hora
      const timeInputs = ['billing_start_time', 'billing_end_time'];
      timeInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          input.type = 'time';
          input.step = '1'; // Permite segundos
          if (input.getAttribute('value')) {
            // Asegurarse de que solo se use la parte de la hora
            const timeValue = input.getAttribute('value').split(' ')[1] || input.getAttribute('value');
            input.value = timeValue;
          }
        }
      });
    }

    // Función para crear HTML de un item
    function createItemHtml(index, itemData = null) {
      return `
        <div class="card mb-3 item-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Código Ref</label>
                            <input type="text" class="form-control" name="items[${index}][code_reference]" 
                                   value="${itemData ? itemData.code_reference : ''}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="items[${index}][name]" 
                                   value="${itemData ? itemData.name : ''}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control" name="items[${index}][quantity]" 
                                   value="${itemData ? itemData.quantity : '1'}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Descuento %</label>
                            <input type="number" class="form-control" name="items[${index}][discount_rate]" 
                                   value="${itemData ? itemData.discount_rate : '0'}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" class="form-control" name="items[${index}][price]" 
                                   value="${itemData ? itemData.price : '0'}" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tax Rate</label>
                            <input type="text" class="form-control" name="items[${index}][tax_rate]" 
                                   value="${itemData ? itemData.tax_rate : '19.00'}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Unit Measure ID</label>
                            <input type="text" class="form-control" name="items[${index}][unit_measure_id]" 
                                   value="${itemData ? itemData.unit_measure_id : '70'}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Standard Code ID</label>
                            <input type="text" class="form-control" name="items[${index}][standard_code_id]" 
                                   value="${itemData ? itemData.standard_code_id : '1'}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Is Excluded</label>
                            <input type="number" class="form-control" name="items[${index}][is_excluded]" 
                                   value="${itemData ? itemData.is_excluded : '0'}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tribute ID</label>
                            <input type="text" class="form-control" name="items[${index}][tribute_id]" 
                                   value="${itemData ? itemData.tribute_id : '1'}" required>
                        </div>
                    </div>
                </div>

                <div class="withholding-taxes-container mt-3">
                    <label>Retenciones (withholding_taxes)</label>
                    <div class="withholding-taxes-list" data-item-index="${index}">
                        ${createWithholdingTaxesHtml(index, itemData?.withholding_taxes || [])}
                    </div>
                    <button type="button" class="btn btn-info btn-sm mt-2 add-withholding-tax">
                        <i class="fas fa-plus"></i> Agregar Retención
                    </button>
                </div>

                <button type="button" class="btn btn-danger mt-3 remove-item">
                    <i class="fas fa-trash"></i> Eliminar Item
                </button>
            </div>
        </div>
    `;
    }

    // Agregar esta nueva función después de createItemHtml
    function createWithholdingTaxesHtml(itemIndex, taxes = []) {
      return taxes.map((tax, taxIndex) => 
        createWithholdingTaxRow(itemIndex, taxIndex, tax)
      ).join('');
    }

    function createWithholdingTaxRow(itemIndex, taxIndex, taxData = null) {
      return `
        <div class="row mb-2 withholding-tax-row">
          <div class="col-md-2">
            <input type="text" class="form-control" placeholder="Code" 
                   name="items[${itemIndex}][withholding_taxes][${taxIndex}][code]" 
                   value="${taxData ? taxData.code : ''}" required>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" placeholder="Rate" 
                   name="items[${itemIndex}][withholding_taxes][${taxIndex}][withholding_tax_rate]" 
                   value="${taxData ? taxData.withholding_tax_rate : ''}" required>
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-withholding-tax">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      `;
    }

    // Event Listeners
    document.getElementById('addItemBtn').addEventListener('click', function() {
      const itemsList = document.getElementById('itemsList');
      itemsList.insertAdjacentHTML('beforeend', createItemHtml(itemIndex));
      itemIndex++;
    });

    // Delegación de eventos para elementos dinámicos
    document.addEventListener('click', function(e) {
      // Eliminar item
      if (e.target.closest('.remove-item')) {
        e.target.closest('.item-card').remove();
      }

      // Agregar retención
      if (e.target.closest('.add-withholding-tax')) {
        const container = e.target.closest('.withholding-taxes-container').querySelector('.withholding-taxes-list');
        const itemIndex = container.dataset.itemIndex;
        const currentTaxes = container.querySelectorAll('.withholding-tax-row').length;
        container.insertAdjacentHTML('beforeend', createWithholdingTaxRow(itemIndex, currentTaxes));
      }

      // Eliminar retención
      if (e.target.closest('.remove-withholding-tax')) {
        e.target.closest('.withholding-tax-row').remove();
        // Reindexar las retenciones restantes
        const container = e.target.closest('.withholding-taxes-list');
        const itemIndex = container.dataset.itemIndex;
        const rows = container.querySelectorAll('.withholding-tax-row');
        rows.forEach((row, taxIndex) => {
          row.querySelectorAll('input').forEach(input => {
            const fieldName = input.name.split('][').pop();
            input.name = `items[${itemIndex}][withholding_taxes][${taxIndex}][${fieldName}`;
          });
        });
      }
    });

    // Inicializar componentes
    initializeCustomSelects();
    initializeDateInputs();

    // Cargar items predefinidos
    const predefinedItems = [{
        code_reference: "43217",
        name: "Alojamiento Web vPro4",
        quantity: 2,
        discount_rate: 10,
        price: 20000,
        tax_rate: "19.00",
        unit_measure_id: 70,
        standard_code_id: 1,
        is_excluded: 0,
        tribute_id: 1,
        withholding_taxes: []
        /* withholding_taxes: [{
            code: "06",
            withholding_tax_rate: "7.00"
          },
          {
            code: "05",
            withholding_tax_rate: "15.00"
          }
        ] */
      },
      {
        code_reference: "54321",
        name: "Alojamiento correo eCloud2",
        quantity: 1,
        discount_rate: 0,
        price: 10000,
        tax_rate: "5.00",
        unit_measure_id: 70,
        standard_code_id: 1,
        is_excluded: 0,
        tribute_id: 1,
        withholding_taxes: []
      }
    ];

    // Cargar items predefinidos
    predefinedItems.forEach(item => {
      document.getElementById('itemsList').insertAdjacentHTML('beforeend', createItemHtml(itemIndex, item));
      itemIndex++;
    });
  });
</script>