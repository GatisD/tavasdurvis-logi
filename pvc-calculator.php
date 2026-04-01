<?php
/**
 * Plugin Name: PVC Logu Kalkulators
 * Plugin URI: https://example.com/pvc-calculator
 * Description: Multi-step PVC window and door configuration calculator without pricing
 * Version: 1.0.0
 * Author: Your Company
 * Author URI: https://example.com
 * Text Domain: pvc-calculator
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('PVC_CALC_VERSION', '1.3.0');
define('PVC_CALC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PVC_CALC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include default data functions
require_once PVC_CALC_PLUGIN_DIR . 'includes/defaults.php';
require_once PVC_CALC_PLUGIN_DIR . 'includes/class-pdf-generator.php';

/**
 * Main Plugin Class
 */
class PVC_Calculator {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_pvc_submit_quote', array($this, 'handle_quote_submission'));
        add_action('wp_ajax_nopriv_pvc_submit_quote', array($this, 'handle_quote_submission'));
        add_shortcode('pvc_calculator', array($this, 'render_calculator'));
    }
    
    public function enqueue_frontend_assets() {
        if (!is_admin()) {
            wp_enqueue_style(
                'pvc-calculator-style',
                PVC_CALC_PLUGIN_URL . 'assets/css/calculator.css',
                array(),
                PVC_CALC_VERSION
            );
            
            wp_enqueue_script(
                'pvc-calculator-script',
                PVC_CALC_PLUGIN_URL . 'assets/js/calculator.js',
                array('jquery'),
                PVC_CALC_VERSION,
                true
            );
            
            wp_localize_script('pvc-calculator-script', 'pvcCalc', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('pvc_calculator_nonce'),
                'pluginUrl' => PVC_CALC_PLUGIN_URL,
                'settings' => pvc_get_calculator_settings(),
                'strings' => array(
                    'required' => __('Šis lauks ir obligāts', 'pvc-calculator'),
                    'invalidEmail' => __('Lūdzu, ievadiet derīgu e-pasta adresi', 'pvc-calculator'),
                    'submitSuccess' => __('Paldies! Mēs sazināsimies ar Jums tuvākajā laikā.', 'pvc-calculator'),
                    'submitError' => __('Radās kļūda. Lūdzu, mēģiniet vēlreiz.', 'pvc-calculator'),
                )
            ));
        }
    }
    
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_pvc-calculator' !== $hook) {
            return;
        }
        
        // Enqueue WordPress media uploader
        wp_enqueue_media();
        
        wp_enqueue_style(
            'pvc-calculator-admin',
            PVC_CALC_PLUGIN_URL . 'admin/css/admin.css',
            array(),
            PVC_CALC_VERSION
        );
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('PVC Kalkulators', 'pvc-calculator'),
            __('PVC Kalkulators', 'pvc-calculator'),
            'manage_options',
            'pvc-calculator',
            array($this, 'render_admin_page'),
            'dashicons-calculator',
            30
        );
    }
    
    public function render_admin_page() {
        include PVC_CALC_PLUGIN_DIR . 'admin/admin-settings.php';
    }
    
    public function render_calculator($atts) {
        $atts = shortcode_atts(array(), $atts);
        
        ob_start();
        include PVC_CALC_PLUGIN_DIR . 'includes/calculator-template.php';
        return ob_get_clean();
    }
    
    public function handle_quote_submission() {
        check_ajax_referer('pvc_calculator_nonce', 'nonce');
        
        $data = array(
            'product_type' => sanitize_text_field($_POST['product_type'] ?? ''),
            'profile' => sanitize_text_field($_POST['profile'] ?? ''),
            'division_type' => sanitize_text_field($_POST['division_type'] ?? ''),
            'division_svg' => wp_kses($_POST['division_svg'] ?? '', array(
                'svg' => array('viewBox' => true, 'class' => true, 'width' => true, 'height' => true),
                'rect' => array('x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true),
                'line' => array('x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-dasharray' => true),
                'path' => array('d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-dasharray' => true),
                'circle' => array('cx' => true, 'cy' => true, 'r' => true, 'fill' => true),
                'polygon' => array('points' => true, 'fill' => true),
            )),
            'opening_type' => sanitize_text_field($_POST['opening_type'] ?? ''),
            'opening_svg' => wp_kses($_POST['opening_svg'] ?? '', array(
                'svg' => array('viewBox' => true, 'class' => true, 'width' => true, 'height' => true),
                'rect' => array('x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true),
                'line' => array('x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-dasharray' => true),
                'path' => array('d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-dasharray' => true),
                'circle' => array('cx' => true, 'cy' => true, 'r' => true, 'fill' => true),
                'polygon' => array('points' => true, 'fill' => true),
            )),
            'width' => intval($_POST['width'] ?? 0),
            'height' => intval($_POST['height'] ?? 0),
            'outside_color' => sanitize_text_field($_POST['outside_color'] ?? ''),
            'outside_color_hex' => sanitize_hex_color($_POST['outside_color_hex'] ?? '#ffffff'),
            'inside_color' => sanitize_text_field($_POST['inside_color'] ?? ''),
            'inside_color_hex' => sanitize_hex_color($_POST['inside_color_hex'] ?? '#ffffff'),
            'glazing' => sanitize_text_field($_POST['glazing'] ?? ''),
            'handle' => sanitize_text_field($_POST['handle'] ?? ''),
            'name' => sanitize_text_field($_POST['customer_name'] ?? ''),
            'email' => sanitize_email($_POST['customer_email'] ?? ''),
            'phone' => sanitize_text_field($_POST['customer_phone'] ?? ''),
            'message' => sanitize_textarea_field($_POST['customer_message'] ?? ''),
        );
        
        // Validate required fields
        if (empty($data['name']) || empty($data['email']) || empty($data['phone'])) {
            wp_send_json_error(array('message' => __('Lūdzu, aizpildiet visus obligātos laukus.', 'pvc-calculator')));
        }
        
        // Try to generate PDF attachment (optional - email will work without it)
        $attachments = array();
        $uploaded_file_name = '';
        try {
            $pdf_generator = new PVC_PDF_Generator($data);
            $pdf_path = $pdf_generator->generate();
            if ($pdf_path && file_exists($pdf_path)) {
                $attachments[] = $pdf_path;
            }
        } catch (Exception $e) {
            // PDF generation failed - continue without attachment
            error_log('PVC Calculator PDF generation failed: ' . $e->getMessage());
        }

        if (!empty($_FILES['customer_file']['name'])) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $uploaded = wp_handle_upload($_FILES['customer_file'], array('test_form' => false));
            if (!isset($uploaded['error']) && !empty($uploaded['file']) && file_exists($uploaded['file'])) {
                $attachments[] = $uploaded['file'];
                $uploaded_file_name = basename($uploaded['file']);
            }
        }

        // Build email content
        $email_content = $this->build_email_content($data, $uploaded_file_name);
        
        // Get admin email
        $admin_email = get_option('pvc_calc_admin_email', get_option('admin_email'));
        
        // Send email (with or without PDF attachment)
        $subject = sprintf(__('Jauns PVC produkta pieprasījums no %s', 'pvc-calculator'), $data['name']);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $sent = wp_mail($admin_email, $subject, $email_content, $headers, $attachments);
        
        // Cleanup old files periodically
        if (mt_rand(1, 10) === 1) {
            PVC_PDF_Generator::cleanup_old_files();
        }
        
        if ($sent) {
            wp_send_json_success(array('message' => __('Paldies! Mēs sazināsimies ar Jums tuvākajā laikā.', 'pvc-calculator')));
        } else {
            wp_send_json_error(array('message' => __('Radās kļūda nosūtot e-pastu. Lūdzu, mēģiniet vēlreiz.', 'pvc-calculator')));
        }
    }
    
    private function build_email_content($data, $uploaded_file_name = '') {
        $product_types = array(
            'logs' => 'Logs',
            'ardurvis' => 'Ārdurvis',
            'bidamas' => 'Bīdāmās durvis'
        );
        
        $html = '<html><body style="font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5;">';
        $html .= '<div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">';
        $html .= '<div style="background: linear-gradient(135deg, #0066cc, #00aa88); padding: 25px; text-align: center;">';
        $html .= '<h2 style="color: #fff; margin: 0; font-size: 24px;">🪟 Jauns PVC pieprasījums</h2>';
        $html .= '</div>';
        $html .= '<div style="padding: 25px;">';
        
        // Product info table
        $html .= '<table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">';
        
        // Row helper function with optional icon
        $add_row = function($label, $value, $icon_html = null, $color_hex = null) {
            if (empty($value)) return '';
            $row = '<tr>';
            $row .= '<td style="padding: 12px 15px; border-bottom: 1px solid #eee; font-weight: 600; color: #555; width: 180px; vertical-align: middle;">' . esc_html($label) . '</td>';
            $row .= '<td style="padding: 12px 15px; border-bottom: 1px solid #eee; color: #333; vertical-align: middle;">';
            if ($icon_html) {
                $row .= '<div style="display: inline-block; width: 50px; height: 60px; vertical-align: middle; margin-right: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; padding: 5px; text-align: center;">' . $icon_html . '</div>';
            }
            if ($color_hex) {
                $row .= '<span style="display: inline-block; width: 24px; height: 24px; background: ' . esc_attr($color_hex) . '; border: 2px solid #ddd; border-radius: 4px; vertical-align: middle; margin-right: 10px;"></span>';
            }
            $row .= '<span style="vertical-align: middle;">' . esc_html($value) . '</span>';
            $row .= '</td></tr>';
            return $row;
        };
        
        $html .= $add_row('Produkta veids', $product_types[$data['product_type']] ?? $data['product_type']);
        $html .= $add_row('Profils', $data['profile']);
        $html .= $add_row('Dalījuma veids', $data['division_type']);
        $html .= $add_row('Vēršanās veids', $data['opening_type']);
        $html .= $add_row('Izmēri', $data['width'] . ' x ' . $data['height'] . ' mm');
        $html .= $add_row('Krāsa no ārpuses', $data['outside_color'], null, $data['outside_color_hex']);
        $html .= $add_row('Krāsa no iekšpuses', $data['inside_color'], null, $data['inside_color_hex']);
        $html .= $add_row('Stiklojums', $data['glazing']);
        $html .= $add_row('Rokturis', $data['handle']);
        
        $html .= '</table>';
        
        // Contact info section
        $html .= '<div style="background: #f9f9f9; border-radius: 6px; padding: 20px; margin-top: 15px;">';
        $html .= '<h3 style="color: #333; margin: 0 0 15px 0; font-size: 16px;">📞 Kontaktinformācija</h3>';
        $html .= '<p style="margin: 8px 0;"><strong>Vārds:</strong> ' . esc_html($data['name']) . '</p>';
        $html .= '<p style="margin: 8px 0;"><strong>E-pasts:</strong> <a href="mailto:' . esc_attr($data['email']) . '" style="color: #0066cc;">' . esc_html($data['email']) . '</a></p>';
        $html .= '<p style="margin: 8px 0;"><strong>Tālrunis:</strong> <a href="tel:' . esc_attr($data['phone']) . '" style="color: #0066cc;">' . esc_html($data['phone']) . '</a></p>';
        if (!empty($uploaded_file_name)) {
            $html .= '<p style="margin: 8px 0;"><strong>Pievienots fails:</strong> ' . esc_html($uploaded_file_name) . '</p>';
        }
        
        if (!empty($data['message'])) {
            $html .= '<p style="margin: 15px 0 8px 0;"><strong>Ziņojums:</strong></p>';
            $html .= '<div style="background: #fff; padding: 12px; border-radius: 4px; border-left: 3px solid #0066cc;">' . nl2br(esc_html($data['message'])) . '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</body></html>';
        
        return $html;
    }
}

// Initialize the plugin
function pvc_calculator_init() {
    PVC_Calculator::get_instance();
}
add_action('plugins_loaded', 'pvc_calculator_init');

// Activation hook
register_activation_hook(__FILE__, 'pvc_calculator_activate');
function pvc_calculator_activate() {
    // Set default options
    if (!get_option('pvc_calc_admin_email')) {
        update_option('pvc_calc_admin_email', get_option('admin_email'));
    }
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'pvc_calculator_deactivate');
function pvc_calculator_deactivate() {
    // Cleanup if needed
}
