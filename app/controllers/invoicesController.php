<?php

User::isAuth();
Get::Model('invoices');
class InvoicesController extends Controller {

        public function index(){
            //App::Debug(Session::get('authUser'));
            if(!$args = Request::getKeys($_POST, ['search_field', 'search_value'])){
                $args = [];
            }
            
            $data = InvoicesModel::getInvoices($args);
            $this->GetModules('head/head', ['title' => 'Invoices', 'breadcrumb' => 'Invoices']);
            $this->view('invoices/invoicesList', $data);
            $this->GetModules('footer/footer');
        }

        public function create(){
            $this->GetModules('head/head', ['title' => 'Create Invoice', 'breadcrumb' => 'Invoice / Create Invoice']);
            $this->view('invoices/createInvoice');
            $this->GetModules('footer/footer');
        }

        public function store(){
            if($response = InvoicesModel::createInvoice($_POST)){
                Alerts::set('Factura creada correctamente', 'success');

                if($invoice = Request::getKey($response, 'bill')){
                    Http::Redirect('/invoices/show/' . $invoice->number);
                }
            }

            Http::Redirect('/invoices/create');
        }

        public function show($invoiceNumber){
            $invoiceNumber = $invoiceNumber[0] ?? null;

            if(!$invoiceNumber){
                Http::Err(400, 'Invoice number is required');
            }

            if(!$data['invoice'] = InvoicesModel::getInvoiceByNumber($invoiceNumber)){
                Http::Err(404, 'Invoice not found');
            }

            $this->GetModules('head/head', ['title' => 'Show Invoice', 'breadcrumb' => 'Invoices / Show Invoice']);
            $this->view('invoices/invoice', $data);
            $this->GetModules('footer/footer');
        }

        public function download($inputs){
            $invoiceNumber = $inputs[0] ?? null;
            $format = $inputs[1] ?? null;

            if(!$invoiceNumber){
                Http::Err(400, 'Invoice Number is required');
            }

            $response = InvoicesModel::downloadInvoiceByNumber($invoiceNumber, $format);

            if(!$response){
                Http::Err(400, 'Invoice not found');
            }

            if(!$file_name = Request::getKey($response, 'file_name')){
                $file_name = 'fv-' . $invoiceNumber;
            }

            if($format == 'xml'){
                if(!$invoice = Request::getKey($response, 'xml_base_64_encoded')){
                    Http::Err(400, 'Invoice XML not found');
                }

                header('Content-Type: application/xml');
                header('Content-Disposition: attachment; filename="' . $file_name . '.xml"');
            }else if($format == 'pdf'){
                if(!$invoice = Request::getKey($response, 'pdf_base_64_encoded')){
                    Http::Err(400, 'Invoice PDF not found');
                }

                // Configurar los headers para forzar la descarga del PDF
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $file_name . '.pdf"');
            }else{
                Http::Err(400, 'File format or extension not supported');
            }
            
            // Decodifica y descarga la factura
            echo base64_decode($invoice);
            exit;
        }

        public function delete($reference_code){
            InvoicesModel::deleteInvoice($reference_code);
            Http::Redirect('/invoices');
        }
    }