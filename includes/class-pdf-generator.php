<?php
/**
 * PDF Generator for PVC Calculator using TCPDF
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include TCPDF
require_once PVC_CALC_PLUGIN_DIR . 'vendor/TCPDF-6.7.5/tcpdf.php';

class PVC_PDF_Generator {
    
    private $data;
    private $product_types;
    
    public function __construct($data) {
        $this->data = $data;
        $this->product_types = array(
            'logs' => 'Logs',
            'ardurvis' => 'Ārdurvis',
            'bidamas' => 'Bīdāmās durvis'
        );
    }
    
    /**
     * Generate PDF and return file path
     */
    public function generate() {
        $data = $this->data;
        $product_name = $this->product_types[$data['product_type']] ?? $data['product_type'];
        
        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('PVC Kalkulators');
        $pdf->SetAuthor($data['name']);
        $pdf->SetTitle('PVC Konfigurācija');
        
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Set margins
        $pdf->SetMargins(15, 15, 15);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(true, 15);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('dejavusans', '', 11);
        
        // Header
        $pdf->SetFillColor(0, 102, 204);
        $pdf->Rect(0, 0, 210, 35, 'F');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('dejavusans', 'B', 20);
        $pdf->SetY(10);
        $pdf->Cell(0, 10, 'PVC Konfigurācija', 0, 1, 'C');
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(0, 6, date('d.m.Y H:i'), 0, 1, 'C');
        
        // Reset text color
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(45);
        
        // Section: Product Info
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->SetTextColor(0, 102, 204);
        $pdf->Cell(0, 8, 'Produkta informācija', 0, 1, 'L');
        $pdf->SetDrawColor(0, 102, 204);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(5);
        
        // Reset colors
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('dejavusans', '', 10);
        
        // Product details table
        $this->addRow($pdf, 'Produkta veids', $product_name);
        $this->addRow($pdf, 'Profils', $data['profile']);
        
        // Division type with icon
        if (!empty($data['division_type'])) {
            $this->addSvgRow($pdf, 'Dalījuma veids', $data['division_type'], $data['division_svg'] ?? '');
        }
        
        // Opening type with icon
        if (!empty($data['opening_type'])) {
            $this->addSvgRow($pdf, 'Vēršanās veids', $data['opening_type'], $data['opening_svg'] ?? '');
        }
        
        $this->addRow($pdf, 'Izmēri', $data['width'] . ' x ' . $data['height'] . ' mm');
        
        // Colors with swatches
        $this->addColorRow($pdf, 'Krāsa no ārpuses', $data['outside_color'], $data['outside_color_hex']);
        $this->addColorRow($pdf, 'Krāsa no iekšpuses', $data['inside_color'], $data['inside_color_hex']);
        
        $this->addRow($pdf, 'Stiklojums', $data['glazing']);
        $this->addRow($pdf, 'Rokturis', $data['handle']);
        
        $pdf->Ln(10);
        
        // Section: Contact Info
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->SetTextColor(0, 102, 204);
        $pdf->Cell(0, 8, 'Kontaktinformācija', 0, 1, 'L');
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(5);
        
        // Contact details
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Rect(15, $pdf->GetY(), 180, 45 + (!empty($data['message']) ? 25 : 0), 'F');
        $pdf->Ln(3);
        
        $this->addRow($pdf, 'Vārds', $data['name'], 170);
        $this->addRow($pdf, 'E-pasts', $data['email'], 170);
        $this->addRow($pdf, 'Tālrunis', $data['phone'], 170);
        
        if (!empty($data['message'])) {
            $pdf->Ln(3);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->Cell(50, 6, 'Ziņojums:', 0, 1);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->SetX(20);
            $pdf->MultiCell(170, 6, $data['message'], 0, 'L');
        }
        
        // Footer
        $pdf->SetY(-25);
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell(0, 10, 'Ģenerēts automātiski ar PVC Kalkulatoru • ' . date('Y'), 0, 0, 'C');
        
        // Save PDF
        $upload_dir = wp_upload_dir();
        $pdf_dir = $upload_dir['basedir'] . '/pvc-quotes/';
        
        if (!file_exists($pdf_dir)) {
            wp_mkdir_p($pdf_dir);
            file_put_contents($pdf_dir . '.htaccess', 'deny from all');
        }
        
        $filename = 'pvc-quote-' . date('Y-m-d-His') . '-' . wp_generate_password(6, false) . '.pdf';
        $filepath = $pdf_dir . $filename;
        
        $pdf->Output($filepath, 'F');
        
        return $filepath;
    }
    
    /**
     * Add a simple row
     */
    private function addRow($pdf, $label, $value, $width = 180) {
        if (empty($value)) return;
        
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(50, 7, $label . ':', 0, 0);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell($width - 50, 7, $value, 0, 1);
    }
    
    /**
     * Add a row with SVG icon
     */
    private function addSvgRow($pdf, $label, $value, $svg) {
        if (empty($value)) return;
        
        $startY = $pdf->GetY();
        $rowHeight = 32; // Square-ish box for icons
        
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(50, $rowHeight, $label . ':', 0, 0);
        
        // Try to render SVG icon if provided
        if (!empty($svg)) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            
            // Draw container box - square proportions for icons
            $boxSize = 30;
            $pdf->SetFillColor(240, 248, 255);
            $pdf->SetDrawColor(180, 180, 180);
            $pdf->Rect($x, $y + 1, $boxSize, $boxSize, 'FD');
            
            // Try to render SVG
            try {
                $upload_dir = wp_upload_dir();
                $temp_svg = $upload_dir['basedir'] . '/pvc-quotes/temp-' . md5($svg) . '.svg';
                
                // Clean up SVG and add proper attributes
                $svg = trim($svg);
                // Remove any existing viewBox and add new one
                $svg = preg_replace('/viewBox="[^"]*"/', '', $svg);
                // Add preserveAspectRatio to prevent stretching
                $svg = preg_replace('/<svg/', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet"', $svg);
                
                $svg_content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $svg;
                file_put_contents($temp_svg, $svg_content);
                
                // Render SVG in PDF - square, centered
                @$pdf->ImageSVG($temp_svg, $x + 2, $y + 3, $boxSize - 4, $boxSize - 4, '', '', '', 0, false);
                
                @unlink($temp_svg);
            } catch (Exception $e) {
                // SVG rendering failed
            }
            
            $pdf->SetX($x + $boxSize + 5);
        }
        
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(95, $rowHeight, $value, 0, 1, 'L', false, '', 0, false, 'T', 'M');
        
        if ($pdf->GetY() < $startY + $rowHeight) {
            $pdf->SetY($startY + $rowHeight);
        }
    }
    
    /**
     * Add a color row with swatch
     */
    private function addColorRow($pdf, $label, $value, $hex) {
        if (empty($value)) return;
        
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->Cell(50, 7, $label . ':', 0, 0);
        
        // Draw color swatch
        $rgb = $this->hexToRgb($hex);
        $pdf->SetFillColor($rgb['r'], $rgb['g'], $rgb['b']);
        $pdf->SetDrawColor(150, 150, 150);
        $x = $pdf->GetX();
        $y = $pdf->GetY() + 1;
        $pdf->Rect($x, $y, 5, 5, 'FD');
        $pdf->SetX($x + 8);
        
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Cell(120, 7, $value, 0, 1);
    }
    
    /**
     * Convert hex color to RGB
     */
    private function hexToRgb($hex) {
        $hex = ltrim($hex, '#');
        if (strlen($hex) == 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return array(
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        );
    }
    
    /**
     * Clean up old PDF files
     */
    public static function cleanup_old_files() {
        $upload_dir = wp_upload_dir();
        $pdf_dir = $upload_dir['basedir'] . '/pvc-quotes/';
        
        if (!file_exists($pdf_dir)) return;
        
        $files = glob($pdf_dir . 'pvc-quote-*.*');
        $now = time();
        
        foreach ($files as $file) {
            if ($now - filemtime($file) > 7 * 24 * 60 * 60) {
                @unlink($file);
            }
        }
    }
}
