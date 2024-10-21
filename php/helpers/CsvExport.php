<?php
namespace helpers;
class CSVExport {
    private $data;
    private $headers;

    public function __construct(array $data, array $headers = []) {
        $this->data = $data;
        $this->headers = $headers;
    }

    public function export($filename = 'export.csv') {
    
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

      
        $output = fopen('php://output', 'w');

   
        if (!empty($this->headers)) {
            fputcsv($output, $this->headers);
        }

    
        foreach ($this->data as $row) {
            fputcsv($output, $row);
        }


        fclose($output);
    }
}