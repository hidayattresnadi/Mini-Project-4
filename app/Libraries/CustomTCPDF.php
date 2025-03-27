<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;
use TCPDF;

class CustomTCPDF extends TCPDF
{
    public function Header()
    {
        // Set font untuk judul
        $this->SetFont('helvetica', 'B', 14);

        // Tambahkan teks judul (di tengah atas)
        // $this->Cell(104, 50, 'STUDENT REPORT', 0, 1, 'C');

        // Geser posisi Y ke bawah untuk logo
        $this->SetY(20); // Atur posisi setelah judul

        // Tambahkan gambar logo (di tengah halaman)
        $this->Image(FCPATH . 'uploads/online-shopping-logo.png', 133, 10, 36, 36, 'PNG');
        // $this->Image(WRITEPATH . 'uploads/columbia_university.png', 15, 15, 30, 30, 'PNG');
        // $this->Image(WRITEPATH . 'uploads/rain-logo-round.jpg', 133, 15, 36, 36, 'JPG');

        // Geser posisi Y ke bawah setelah logo
        $this->SetY(50); // Sesuaikan agar garis tidak menabrak gambar

        // Tambahkan garis horizontal
        $this->SetLineWidth(0.5); // Ketebalan garis
        $this->Line(15, $this->GetY(), 280, $this->GetY()); // Garis dari kiri ke kanan
    }
}
