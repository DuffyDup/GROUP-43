<?php
require_once('tcpdf/tcpdf.php');
require 'connectdb.php';

// Extend TCPDF class for custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'Sales Report', 0, 1, 'C');
    }
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create new PDF document
$pdf = new MYPDF();
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Query to get top-selling products
$sql = "
    SELECT p.name AS product_name, 
           SUM(pur.quantity) AS total_quantity_sold, 
           SUM(pur.quantity * p.price) AS total_revenue
    FROM Purchased pur
    JOIN Products p ON pur.product_id = p.product_id
    GROUP BY pur.product_id
    ORDER BY total_quantity_sold DESC
    LIMIT 10";
$stmt = $db->prepare($sql);
$stmt->execute();
$top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the table
$html = '<h2>Top Selling Products</h2>
        <table border="1" cellspacing="3" cellpadding="4">
            <thead>
                <tr>
                    <th><b>Product Name</b></th>
                    <th><b>Total Sold</b></th>
                    <th><b>Total Revenue (£)</b></th>
                </tr>
            </thead>
            <tbody>';

foreach ($top_products as $product) {
    $html .= '<tr>
                <td>' . htmlspecialchars($product['product_name']) . '</td>
                <td>' . number_format($product['total_quantity_sold']) . '</td>
                <td>£' . number_format($product['total_revenue'], 2) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output table to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('Sales_Report.pdf', 'D');
?>
