<?php

namespace App\Controllers;

use App\Libraries\CustomTCPDF;
use App\Models\ProductModel;
use Myth\Auth\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Style\Alignment as Alignment;

class ReportController extends BaseController
{
    protected $enrollmentsData;
    protected $studentsData;
    private ProductModel $productModel;
    private UserModel $userModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function productbyCategoryForm()
    {
        $search = $this->request->getVar('search');

        $filteredData = $this->productModel->getFilteredProductsbyCategory($search);

        $data = [
            'title' => 'Product by Category Report',
            'products' => $filteredData,
            'filters' => [
                'search' => $search,
            ]
        ];

        return view('reports/product_by_category', $data);
    }

    public function productbyCategoryExcel()
    {

        $search = $this->request->getVar('search');

        $products = $this->productModel->getFilteredProductsbyCategory($search);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Product by Category Report');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Filter: Category');
        if (!empty($search)) {
            $sheet->setCellValue('B3', 'Category: ' . $search);
        }
        $sheet->getStyle('A3:B3')->getFont()->setBold(true);
        $headers = [
            'A5' => 'NO',
            'B5' => 'PRODUCT NAME',
            'C5' => 'CATEGORY',
            'D5' => 'PRICE',
            'E5' => 'STOCK',
            'F5' => 'DATE ADDED'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 6;
        $no = 1;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $product->name);
            $sheet->setCellValue('C' . $row, $product->category);
            $sheet->setCellValue('D' . $row, $product->price);
            $sheet->setCellValue('E' . $row, $product->stock);
            $sheet->setCellValue('F' . $row, $product->created_at);

            $row++;
            $no++;
        }
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Buat border untuk seluruh tabel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A5:F' . ($row - 1))->applyFromArray($styleArray);



        $filename = 'Product_by_Category_Report_' . date('Y-m-d-His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    private function initTcpdf()
    {
        $pdf = new CustomTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('CodeIgniter 4');
        $pdf->SetAuthor('Administrator');
        $pdf->SetTitle('Users Report');
        $pdf->SetSubject('Users Data Report');

        $pdf->SetPrintHeader(true);
        $pdf->SetPrintFooter(true);
        // $pdf->setHeaderData(WRITEPATH . 'uploads/columbia_university.png', 20, 'Laporan Mahasiswa');

        // $pdf->setHeaderFont(['helvetica', '', 12]);
        // $pdf->setFooterFont(['helvetica', '', 8]);

        $pdf->SetMargins(15, 55, 15); // Geser konten ke bawah (margin atas 90mm)

        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        $pdf->SetAutoPageBreak(true, 25);

        $pdf->SetFont('helvetica', '', 10);

        $pdf->AddPage();

        return $pdf;
    }


    public function userListReportForm()
    {
        $data = [
            'title' => 'User List Report',
        ];

        return view('reports/user_list_report', $data);
    }

    public function userListReportPdf()
    {
        // Generate PDF
        $pdf = $this->initTcpdf();
        $usersData = $this->userModel->findAll();

        $this->generatePdfHtmlContent($pdf, $usersData);

        // Output PDF
        $filename = 'user_list_report' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    public function generatePdfHtmlContent($pdf, $usersData)
    {
        // Set title and filters info
        $title = 'User List Data Report';

        $html = '<h2 style="text-align:center;">' . $title . '</h2>
      <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
        <thead>
          <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Registration Date</th>
          </tr>
         </thead>
         <tbody>';

        $no = 1;
        foreach ($usersData as $user) {
            $html .= '
        <tr>
         <td style="text-align:center;">' . $no . '</td>
         <td>' . $user->username . '</td>
         <td>' . $user->email . '</td>
         <td>' . $user->created_at . '</td>
        </tr>';
            $no++;
        }

        $html .= '
        </tbody>
      </table>

        <p style="margin-top:30px; text-align:left;">      
           <b> Total Users: ' . count($usersData) . '</b> 
        </p>

        <p style="margin-top:30px; text-align:right;">    
            <i>Printed Date: ' . date('d-m-Y H:i:s') .  '</i><br> 
        </p>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }
}
