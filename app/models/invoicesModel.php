<?php

class InvoicesModel extends Model
{
    //v1/bills?filter[identification]&filter[names]&filter[number]&filter[prefix]&filter[reference_code]&filter[status]
    public function __construct()
    {
        parent::__construct();
    }

    public static function getInvoices(array $args = []){

        $payload = [
            'method' => 'GET',
            'uri' => '/v1/bills'
        ];

        // Construir la URI con los filtros de búsqueda
        $queryParams = [];
        
        if($page = Request::getKey($_GET, 'page')){
            $queryParams['page'] = $page;
        }

        // Agregar parámetros de búsqueda si existen
        if(!empty($args['search_field']) && !empty($args['search_value'])) {
            switch($args['search_field']) {
                case 'names':
                    $queryParams['filter[names]'] = $args['search_value'];
                    break;
                case 'identification':
                    $queryParams['filter[identification]'] = $args['search_value'];
                    break;
                case 'status':
                    $queryParams['filter[status]'] = $args['search_value'] == 'completed' ? '1' : '0';
                    break;
                case 'reference_code':
                    $queryParams['filter[reference_code]'] = $args['search_value'];
                    break;
            }
        }

        // Construir la URI con los parámetros
        if (!empty($queryParams)) {
            $payload['uri'] .= '?' . http_build_query($queryParams);
        }


        $response = self::ApiCall($payload);
        if(!$response){
            return [];
        }
        
        $response = get_object_vars($response);
        return $response;
    }

    public static function getInvoiceByNumber(string $invoiceNumber){

        $payload = [
            'method' => 'GET',
            'uri' => '/v1/bills/show/'.$invoiceNumber
        ];

        $response = self::ApiCall($payload);
        
        if(!$response){
            return [];
        }
        
        $response = get_object_vars($response);
        return $response;
    }

    public static function downloadInvoiceByNumber(string $invoiceNumber, string $format = 'pdf'){
        $formats = ['pdf', 'xml'];
        $format = strtolower($format);
        if(!in_array($format, $formats)){
            Alerts::set('File format or extension not supported', 'danger');
            return false;
        }

        $payload = [
            'method' => 'GET',
            'uri' => '/v1/bills/download-'.$format.'/'.$invoiceNumber
        ];

        $response = self::ApiCall($payload);
        return $response;
    }

    public static function createInvoice(array $data){
        $payload = [
            'method' => 'POST',
            'uri' => '/v1/bills/validate',
            'payload' => json_encode($data)
        ];

        $response = self::ApiCall($payload);

        if(!$response){
            Alerts::Server('Error al crear la factura');
            Alerts::set('Error al crear la factura Reference Code: '.$data['reference_code'], 'danger');
            return false;
        }

        return $response;
    }

    public static function deleteInvoice(string $invoice_reference_code){
        $payload = [
            'method' => 'DELETE',
            'uri' => '/v1/bills/delete/'.$invoice_reference_code
        ];

        $response = self::ApiCall($payload);

        if(!$response){
            Alerts::Server('Error al eliminar la factura Reference Code: '.$invoice_reference_code);
            Alerts::set('Error al eliminar la factura Reference Code: '.$invoice_reference_code, 'danger');
            return false;
        }
        
        return $response;
    }
}
