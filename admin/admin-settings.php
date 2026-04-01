<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get current tab
$current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';

// Handle settings save
if (isset($_POST['pvc_calc_save_settings']) && check_admin_referer('pvc_calc_settings_nonce')) {
    
    switch ($current_tab) {
        case 'general':
            update_option('pvc_calc_admin_email', sanitize_email($_POST['pvc_calc_admin_email']));
            break;
            
        case 'products':
            $products = array();
            if (!empty($_POST['products'])) {
                foreach ($_POST['products'] as $product) {
                    if (!empty($product['id']) && !empty($product['label'])) {
                        $products[] = array(
                            'id' => sanitize_key($product['id']),
                            'label' => sanitize_text_field($product['label']),
                            'image' => esc_url_raw($product['image'] ?? ''),
                            'enabled' => isset($product['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_products', $products);
            break;
            
        case 'profiles':
            $profiles = array();
            if (!empty($_POST['profiles'])) {
                foreach ($_POST['profiles'] as $profile) {
                    if (!empty($profile['id']) && !empty($profile['label'])) {
                        $profiles[] = array(
                            'id' => sanitize_key($profile['id']),
                            'label' => sanitize_text_field($profile['label']),
                            'for_product' => sanitize_key($profile['for_product'] ?? 'logs'),
                            'image' => esc_url_raw($profile['image'] ?? ''),
                            'uw' => sanitize_text_field($profile['uw'] ?? ''),
                            'depth' => sanitize_text_field($profile['depth'] ?? ''),
                            'chambers' => sanitize_text_field($profile['chambers'] ?? ''),
                            'enabled' => isset($profile['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_profiles', $profiles);
            break;
            
        case 'colors':
            $colors = array();
            if (!empty($_POST['colors'])) {
                foreach ($_POST['colors'] as $color) {
                    if (!empty($color['id']) && !empty($color['label'])) {
                        $colors[] = array(
                            'id' => sanitize_key($color['id']),
                            'label' => sanitize_text_field($color['label']),
                            'hex' => sanitize_hex_color($color['hex'] ?? '#ffffff'),
                            'is_wood' => isset($color['is_wood']) ? 1 : 0,
                            'enabled' => isset($color['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_colors', $colors);
            break;
            
        case 'glazing':
            $glazing = array();
            if (!empty($_POST['glazing'])) {
                foreach ($_POST['glazing'] as $item) {
                    if (!empty($item['id']) && !empty($item['label'])) {
                        $glazing[] = array(
                            'id' => sanitize_key($item['id']),
                            'label' => sanitize_text_field($item['label']),
                            'description' => sanitize_text_field($item['description'] ?? ''),
                            'enabled' => isset($item['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_glazing', $glazing);
            break;
            
        case 'handles':
            $handles = array();
            if (!empty($_POST['handles'])) {
                foreach ($_POST['handles'] as $handle) {
                    if (!empty($handle['id']) && !empty($handle['label'])) {
                        $handles[] = array(
                            'id' => sanitize_key($handle['id']),
                            'label' => sanitize_text_field($handle['label']),
                            'image' => esc_url_raw($handle['image'] ?? ''),
                            'color' => sanitize_hex_color($handle['color'] ?? '#ffffff'),
                            'enabled' => isset($handle['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_handles', $handles);
            break;
            
        case 'sizes':
            update_option('pvc_calc_size_limits', array(
                'min_width' => intval($_POST['min_width'] ?? 400),
                'max_width' => intval($_POST['max_width'] ?? 4000),
                'min_height' => intval($_POST['min_height'] ?? 400),
                'max_height' => intval($_POST['max_height'] ?? 3000),
                'default_width' => intval($_POST['default_width'] ?? 1000),
                'default_height' => intval($_POST['default_height'] ?? 1200),
            ));
            break;
            
        case 'labels':
            $labels = array();
            foreach ($_POST['labels'] as $key => $value) {
                $labels[sanitize_key($key)] = sanitize_text_field($value);
            }
            update_option('pvc_calc_labels', $labels);
            break;
            
        case 'division_types':
            $division_types = array();
            if (!empty($_POST['division_types'])) {
                foreach ($_POST['division_types'] as $item) {
                    if (!empty($item['id']) && !empty($item['label'])) {
                        $division_types[] = array(
                            'id' => sanitize_text_field($item['id']),
                            'label' => sanitize_text_field($item['label']),
                            'for_product' => sanitize_key($item['for_product'] ?? 'logs'),
                            'custom_image' => esc_url_raw($item['custom_image'] ?? ''),
                            'enabled' => isset($item['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_division_types', $division_types);
            break;
            
        case 'opening_types':
            $opening_types = array();
            if (!empty($_POST['opening_types'])) {
                foreach ($_POST['opening_types'] as $item) {
                    if (!empty($item['id']) && !empty($item['label'])) {
                        $opening_types[] = array(
                            'id' => sanitize_text_field($item['id']),
                            'label' => sanitize_text_field($item['label']),
                            'for_product' => sanitize_key($item['for_product'] ?? 'logs'),
                            'custom_image' => esc_url_raw($item['custom_image'] ?? ''),
                            'enabled' => isset($item['enabled']) ? 1 : 0
                        );
                    }
                }
            }
            update_option('pvc_calc_opening_types', $opening_types);
            break;
    }
    
    echo '<div class="notice notice-success is-dismissible"><p>' . __('Iestatījumi saglabāti!', 'pvc-calculator') . '</p></div>';
}

// Get saved options
$admin_email = get_option('pvc_calc_admin_email', get_option('admin_email'));
$products = get_option('pvc_calc_products', pvc_get_default_products());
$profiles = get_option('pvc_calc_profiles', pvc_get_default_profiles());
$division_types = get_option('pvc_calc_division_types', pvc_get_default_division_types());
$opening_types = get_option('pvc_calc_opening_types', pvc_get_default_opening_types());
$colors = get_option('pvc_calc_colors', pvc_get_default_colors());
$glazing = get_option('pvc_calc_glazing', pvc_get_default_glazing());
$handles = get_option('pvc_calc_handles', pvc_get_default_handles());
$size_limits = get_option('pvc_calc_size_limits', pvc_get_default_size_limits());
$labels = get_option('pvc_calc_labels', pvc_get_default_labels());

// Tabs configuration
$tabs = array(
    'general' => __('Vispārīgi', 'pvc-calculator'),
    'products' => __('Produkti', 'pvc-calculator'),
    'profiles' => __('Profili', 'pvc-calculator'),
    'division_types' => __('Dalījumi', 'pvc-calculator'),
    'opening_types' => __('Vēršanās', 'pvc-calculator'),
    'colors' => __('Krāsas', 'pvc-calculator'),
    'glazing' => __('Stiklojums', 'pvc-calculator'),
    'handles' => __('Rokturi', 'pvc-calculator'),
    'sizes' => __('Izmēri', 'pvc-calculator'),
    'labels' => __('Teksti', 'pvc-calculator'),
);
?>

<style>
.pvc-admin-wrap {
    max-width: 1200px;
}
.pvc-admin-wrap .nav-tab-wrapper {
    margin-bottom: 20px;
}
.pvc-items-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border: 1px solid #ccd0d4;
}
.pvc-items-table th,
.pvc-items-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}
.pvc-items-table th {
    background: #f9f9f9;
    font-weight: 600;
}
.pvc-items-table input[type="text"],
.pvc-items-table input[type="url"],
.pvc-items-table select {
    width: 100%;
}
.pvc-items-table .pvc-color-preview {
    width: 30px;
    height: 30px;
    border-radius: 4px;
    border: 1px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    margin-right: 8px;
}
.pvc-add-btn {
    margin-top: 15px;
}
.pvc-remove-row {
    color: #dc3232;
    cursor: pointer;
    text-decoration: none;
}
.pvc-remove-row:hover {
    color: #a00;
}
.pvc-image-preview {
    max-width: 60px;
    max-height: 60px;
    border-radius: 4px;
}
.pvc-image-upload-btn {
    margin-top: 5px;
}
.pvc-drag-handle {
    cursor: move;
    color: #999;
}
.pvc-section-title {
    margin-top: 30px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}
.pvc-help-text {
    color: #666;
    font-style: italic;
    margin-bottom: 20px;
}
</style>

<div class="wrap pvc-admin-wrap">
    <h1><?php _e('PVC Kalkulatora Iestatījumi', 'pvc-calculator'); ?></h1>
    
    <nav class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab_id => $tab_name): ?>
            <a href="?page=pvc-calculator&tab=<?php echo esc_attr($tab_id); ?>" 
               class="nav-tab <?php echo $current_tab === $tab_id ? 'nav-tab-active' : ''; ?>">
                <?php echo esc_html($tab_name); ?>
            </a>
        <?php endforeach; ?>
    </nav>
    
    <form method="post" action="" id="pvc-settings-form">
        <?php wp_nonce_field('pvc_calc_settings_nonce'); ?>
        
        <?php if ($current_tab === 'general'): ?>
            <!-- General Settings -->
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="pvc_calc_admin_email"><?php _e('Administratora e-pasts', 'pvc-calculator'); ?></label>
                    </th>
                    <td>
                        <input type="email" 
                               id="pvc_calc_admin_email" 
                               name="pvc_calc_admin_email" 
                               value="<?php echo esc_attr($admin_email); ?>" 
                               class="regular-text">
                        <p class="description"><?php _e('E-pasta adrese, uz kuru tiks nosūtīti pieprasījumi.', 'pvc-calculator'); ?></p>
                    </td>
                </tr>
            </table>
            
            <hr style="margin: 40px 0;">
            
            <h2><?php _e('Lietošana', 'pvc-calculator'); ?></h2>
            <p><?php _e('Lai pievienotu kalkulatoru jebkurā lapā vai ierakstā, izmantojiet šo īskodu:', 'pvc-calculator'); ?></p>
            <code style="display: block; padding: 15px; background: #f0f0f0; border-radius: 4px; font-size: 14px;">[pvc_calculator]</code>
            
        <?php elseif ($current_tab === 'products'): ?>
            <!-- Products Settings -->
            <h2 class="pvc-section-title"><?php _e('Produktu veidi (1. solis)', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Pievienojiet vai rediģējiet produktu veidus, kas parādīsies pirmajā solī.', 'pvc-calculator'); ?></p>
            
            <table class="pvc-items-table" id="products-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 120px;"><?php _e('ID', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 200px;"><?php _e('Attēls', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $i => $product): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="products[<?php echo $i; ?>][enabled]" value="1" <?php checked($product['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <input type="text" name="products[<?php echo $i; ?>][id]" value="<?php echo esc_attr($product['id']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="products[<?php echo $i; ?>][label]" value="<?php echo esc_attr($product['label']); ?>" required>
                        </td>
                        <td>
                            <input type="url" name="products[<?php echo $i; ?>][image]" value="<?php echo esc_url($product['image'] ?? ''); ?>" class="pvc-image-url" placeholder="Attēla URL">
                            <button type="button" class="button pvc-upload-image"><?php _e('Izvēlēties', 'pvc-calculator'); ?></button>
                            <?php if (!empty($product['image'])): ?>
                                <br><img src="<?php echo esc_url($product['image']); ?>" class="pvc-image-preview">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row" title="<?php _e('Noņemt', 'pvc-calculator'); ?>">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="products-table"><?php _e('+ Pievienot produktu', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'profiles'): ?>
            <!-- Profiles Settings -->
            <h2 class="pvc-section-title"><?php _e('Profili (2. solis)', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Norādiet kuram produktam pieder katrs profils.', 'pvc-calculator'); ?></p>
            
            <table class="pvc-items-table" id="profiles-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('Produkts', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('ID', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 70px;"><?php _e('Uw', 'pvc-calculator'); ?></th>
                        <th style="width: 70px;"><?php _e('Dziļums', 'pvc-calculator'); ?></th>
                        <th style="width: 70px;"><?php _e('Kameras', 'pvc-calculator'); ?></th>
                        <th style="width: 150px;"><?php _e('Attēls', 'pvc-calculator'); ?></th>
                        <th style="width: 40px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profiles as $i => $profile): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="profiles[<?php echo $i; ?>][enabled]" value="1" <?php checked($profile['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <select name="profiles[<?php echo $i; ?>][for_product]">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo esc_attr($product['id']); ?>" <?php selected($profile['for_product'] ?? '', $product['id']); ?>>
                                        <?php echo esc_html($product['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="profiles[<?php echo $i; ?>][id]" value="<?php echo esc_attr($profile['id']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="profiles[<?php echo $i; ?>][label]" value="<?php echo esc_attr($profile['label']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="profiles[<?php echo $i; ?>][uw]" value="<?php echo esc_attr($profile['uw'] ?? ''); ?>" placeholder="0.76">
                        </td>
                        <td>
                            <input type="text" name="profiles[<?php echo $i; ?>][depth]" value="<?php echo esc_attr($profile['depth'] ?? ''); ?>" placeholder="80 mm">
                        </td>
                        <td>
                            <input type="text" name="profiles[<?php echo $i; ?>][chambers]" value="<?php echo esc_attr($profile['chambers'] ?? ''); ?>" placeholder="6">
                        </td>
                        <td>
                            <input type="url" name="profiles[<?php echo $i; ?>][image]" value="<?php echo esc_url($profile['image'] ?? ''); ?>" class="pvc-image-url" placeholder="URL">
                            <button type="button" class="button pvc-upload-image"><?php _e('Izvēlēties', 'pvc-calculator'); ?></button>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="profiles-table"><?php _e('+ Pievienot profilu', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'division_types'): ?>
            <!-- Division Types Settings -->
            <h2 class="pvc-section-title"><?php _e('Dalījuma veidi (3. solis)', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Rediģējiet dalījuma veidu nosaukumus un bildes. Ja nav pielāgota bilde, tiks izmantota noklusējuma SVG ikona.', 'pvc-calculator'); ?></p>
            
            <table class="pvc-items-table" id="division-types-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('Produkts', 'pvc-calculator'); ?></th>
                        <th style="width: 60px;"><?php _e('Nr.', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 220px;"><?php _e('Pielāgota bilde', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($division_types as $i => $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="division_types[<?php echo $i; ?>][enabled]" value="1" <?php checked($item['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <select name="division_types[<?php echo $i; ?>][for_product]">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo esc_attr($product['id']); ?>" <?php selected($item['for_product'] ?? '', $product['id']); ?>>
                                        <?php echo esc_html($product['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="division_types[<?php echo $i; ?>][id]" value="<?php echo esc_attr($item['id']); ?>" style="width: 50px;" required>
                        </td>
                        <td>
                            <input type="text" name="division_types[<?php echo $i; ?>][label]" value="<?php echo esc_attr($item['label']); ?>" required>
                        </td>
                        <td>
                            <input type="url" name="division_types[<?php echo $i; ?>][custom_image]" value="<?php echo esc_url($item['custom_image'] ?? ''); ?>" class="pvc-image-url" placeholder="Nav (default SVG)" style="width: 130px;">
                            <button type="button" class="button pvc-upload-image"><?php _e('📷', 'pvc-calculator'); ?></button>
                            <?php if (!empty($item['custom_image'])): ?>
                            <img src="<?php echo esc_url($item['custom_image']); ?>" style="width: 30px; height: 30px; vertical-align: middle; margin-left: 5px; border: 1px solid #ccc;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="division-types-table"><?php _e('+ Pievienot dalījumu', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'opening_types'): ?>
            <!-- Opening Types Settings -->
            <h2 class="pvc-section-title"><?php _e('Vēršanās veidi (4. solis)', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Rediģējiet vēršanās veidu nosaukumus un bildes. Ja nav pielāgota bilde, tiks izmantota noklusējuma SVG ikona.', 'pvc-calculator'); ?></p>
            
            <table class="pvc-items-table" id="opening-types-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('Produkts', 'pvc-calculator'); ?></th>
                        <th style="width: 60px;"><?php _e('Nr.', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 220px;"><?php _e('Pielāgota bilde', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opening_types as $i => $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="opening_types[<?php echo $i; ?>][enabled]" value="1" <?php checked($item['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <select name="opening_types[<?php echo $i; ?>][for_product]">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo esc_attr($product['id']); ?>" <?php selected($item['for_product'] ?? '', $product['id']); ?>>
                                        <?php echo esc_html($product['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="opening_types[<?php echo $i; ?>][id]" value="<?php echo esc_attr($item['id']); ?>" style="width: 50px;" required>
                        </td>
                        <td>
                            <input type="text" name="opening_types[<?php echo $i; ?>][label]" value="<?php echo esc_attr($item['label']); ?>" required>
                        </td>
                        <td>
                            <input type="url" name="opening_types[<?php echo $i; ?>][custom_image]" value="<?php echo esc_url($item['custom_image'] ?? ''); ?>" class="pvc-image-url" placeholder="Nav (default SVG)" style="width: 130px;">
                            <button type="button" class="button pvc-upload-image"><?php _e('📷', 'pvc-calculator'); ?></button>
                            <?php if (!empty($item['custom_image'])): ?>
                            <img src="<?php echo esc_url($item['custom_image']); ?>" style="width: 30px; height: 30px; vertical-align: middle; margin-left: 5px; border: 1px solid #ccc;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="opening-types-table"><?php _e('+ Pievienot vēršanos', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'colors'): ?>
            <!-- Colors Settings -->
            <h2 class="pvc-section-title"><?php _e('Krāsas (6. un 7. solis)', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Šīs krāsas tiks izmantotas gan ārpuses, gan iekšpuses krāsu izvēlei.', 'pvc-calculator'); ?></p>
            
            <table class="pvc-items-table" id="colors-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 120px;"><?php _e('ID', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 150px;"><?php _e('Krāsa', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('Koka tekstūra', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($colors as $i => $color): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="colors[<?php echo $i; ?>][enabled]" value="1" <?php checked($color['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <input type="text" name="colors[<?php echo $i; ?>][id]" value="<?php echo esc_attr($color['id']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="colors[<?php echo $i; ?>][label]" value="<?php echo esc_attr($color['label']); ?>" required>
                        </td>
                        <td>
                            <span class="pvc-color-preview" style="background: <?php echo esc_attr($color['hex'] ?? '#fff'); ?>;"></span>
                            <input type="color" name="colors[<?php echo $i; ?>][hex]" value="<?php echo esc_attr($color['hex'] ?? '#ffffff'); ?>" style="width: 60px; vertical-align: middle;">
                        </td>
                        <td>
                            <input type="checkbox" name="colors[<?php echo $i; ?>][is_wood]" value="1" <?php checked($color['is_wood'] ?? 0, 1); ?>>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="colors-table"><?php _e('+ Pievienot krāsu', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'glazing'): ?>
            <!-- Glazing Settings -->
            <h2 class="pvc-section-title"><?php _e('Stiklojums (8. solis)', 'pvc-calculator'); ?></h2>
            
            <table class="pvc-items-table" id="glazing-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 120px;"><?php _e('ID', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th><?php _e('Apraksts', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($glazing as $i => $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="glazing[<?php echo $i; ?>][enabled]" value="1" <?php checked($item['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <input type="text" name="glazing[<?php echo $i; ?>][id]" value="<?php echo esc_attr($item['id']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="glazing[<?php echo $i; ?>][label]" value="<?php echo esc_attr($item['label']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="glazing[<?php echo $i; ?>][description]" value="<?php echo esc_attr($item['description'] ?? ''); ?>">
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="glazing-table"><?php _e('+ Pievienot stiklojumu', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'handles'): ?>
            <!-- Handles Settings -->
            <h2 class="pvc-section-title"><?php _e('Rokturi (9. solis)', 'pvc-calculator'); ?></h2>
            
            <table class="pvc-items-table" id="handles-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e('Aktīvs', 'pvc-calculator'); ?></th>
                        <th style="width: 120px;"><?php _e('ID', 'pvc-calculator'); ?></th>
                        <th><?php _e('Nosaukums', 'pvc-calculator'); ?></th>
                        <th style="width: 100px;"><?php _e('Krāsa', 'pvc-calculator'); ?></th>
                        <th style="width: 200px;"><?php _e('Attēls', 'pvc-calculator'); ?></th>
                        <th style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($handles as $i => $handle): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="handles[<?php echo $i; ?>][enabled]" value="1" <?php checked($handle['enabled'] ?? 1, 1); ?>>
                        </td>
                        <td>
                            <input type="text" name="handles[<?php echo $i; ?>][id]" value="<?php echo esc_attr($handle['id']); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="handles[<?php echo $i; ?>][label]" value="<?php echo esc_attr($handle['label']); ?>" required>
                        </td>
                        <td>
                            <input type="color" name="handles[<?php echo $i; ?>][color]" value="<?php echo esc_attr($handle['color'] ?? '#ffffff'); ?>">
                        </td>
                        <td>
                            <input type="url" name="handles[<?php echo $i; ?>][image]" value="<?php echo esc_url($handle['image'] ?? ''); ?>" class="pvc-image-url" placeholder="URL">
                            <button type="button" class="button pvc-upload-image"><?php _e('Izvēlēties', 'pvc-calculator'); ?></button>
                        </td>
                        <td>
                            <a href="#" class="pvc-remove-row">✕</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="button pvc-add-btn" data-table="handles-table"><?php _e('+ Pievienot rokturi', 'pvc-calculator'); ?></button>
            
        <?php elseif ($current_tab === 'sizes'): ?>
            <!-- Sizes Settings -->
            <h2 class="pvc-section-title"><?php _e('Izmēru ierobežojumi (5. solis)', 'pvc-calculator'); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th><?php _e('Minimālais platums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="min_width" value="<?php echo esc_attr($size_limits['min_width']); ?>" min="100" max="10000"></td>
                </tr>
                <tr>
                    <th><?php _e('Maksimālais platums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="max_width" value="<?php echo esc_attr($size_limits['max_width']); ?>" min="100" max="10000"></td>
                </tr>
                <tr>
                    <th><?php _e('Minimālais augstums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="min_height" value="<?php echo esc_attr($size_limits['min_height']); ?>" min="100" max="10000"></td>
                </tr>
                <tr>
                    <th><?php _e('Maksimālais augstums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="max_height" value="<?php echo esc_attr($size_limits['max_height']); ?>" min="100" max="10000"></td>
                </tr>
                <tr>
                    <th><?php _e('Noklusējuma platums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="default_width" value="<?php echo esc_attr($size_limits['default_width']); ?>" min="100" max="10000"></td>
                </tr>
                <tr>
                    <th><?php _e('Noklusējuma augstums (mm)', 'pvc-calculator'); ?></th>
                    <td><input type="number" name="default_height" value="<?php echo esc_attr($size_limits['default_height']); ?>" min="100" max="10000"></td>
                </tr>
            </table>
            
        <?php elseif ($current_tab === 'labels'): ?>
            <!-- Labels/Text Settings -->
            <h2 class="pvc-section-title"><?php _e('Teksti un nosaukumi', 'pvc-calculator'); ?></h2>
            <p class="pvc-help-text"><?php _e('Mainiet kalkulatorā redzamos tekstus.', 'pvc-calculator'); ?></p>
            
            <table class="form-table">
                <tr>
                    <th><?php _e('1. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step1_title]" value="<?php echo esc_attr($labels['step1_title'] ?? '1. PVC konstrukcija'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('1. soļa apraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step1_desc]" value="<?php echo esc_attr($labels['step1_desc'] ?? 'Sāciet izvēloties PVC konstrukciju uz tās nospiežot.'); ?>" class="large-text"></td>
                </tr>
                <tr>
                    <th><?php _e('2. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step2_title]" value="<?php echo esc_attr($labels['step2_title'] ?? '2. Profils'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('3. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step3_title]" value="<?php echo esc_attr($labels['step3_title'] ?? '3. Dalījuma veids'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('4. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step4_title]" value="<?php echo esc_attr($labels['step4_title'] ?? '4. Vēršanās veids'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('5. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step5_title]" value="<?php echo esc_attr($labels['step5_title'] ?? '5. Izmēri'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('6. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step6_title]" value="<?php echo esc_attr($labels['step6_title'] ?? '6. Krāsa no ārpuses'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('7. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step7_title]" value="<?php echo esc_attr($labels['step7_title'] ?? '7. Krāsa no iekšpuses'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('8. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step8_title]" value="<?php echo esc_attr($labels['step8_title'] ?? '8. Stiklojums'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('9. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step9_title]" value="<?php echo esc_attr($labels['step9_title'] ?? '9. Rokturi'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('10. soļa virsraksts', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[step10_title]" value="<?php echo esc_attr($labels['step10_title'] ?? '10. Kontaktinformācija'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('Poga "Tālāk"', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[btn_next]" value="<?php echo esc_attr($labels['btn_next'] ?? 'Tālāk →'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('Poga "Atpakaļ"', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[btn_prev]" value="<?php echo esc_attr($labels['btn_prev'] ?? '← Atpakaļ'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><?php _e('Poga "Nosūtīt"', 'pvc-calculator'); ?></th>
                    <td><input type="text" name="labels[btn_submit]" value="<?php echo esc_attr($labels['btn_submit'] ?? 'Nosūtīt pieprasījumu'); ?>" class="regular-text"></td>
                </tr>
            </table>
        <?php endif; ?>
        
        <p class="submit">
            <input type="submit" name="pvc_calc_save_settings" class="button-primary" value="<?php _e('Saglabāt iestatījumus', 'pvc-calculator'); ?>">
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Remove row
    $(document).on('click', '.pvc-remove-row', function(e) {
        e.preventDefault();
        if (confirm('<?php _e('Vai tiešām vēlaties dzēst šo ierakstu?', 'pvc-calculator'); ?>')) {
            $(this).closest('tr').remove();
        }
    });
    
    // Add row - clone last row and clear values
    $('.pvc-add-btn').on('click', function() {
        var tableId = $(this).data('table');
        var $tbody = $('#' + tableId + ' tbody');
        var $lastRow = $tbody.find('tr:last');
        var $newRow = $lastRow.clone();
        var newIndex = $tbody.find('tr').length;
        
        // Update names with new index
        $newRow.find('input, select').each(function() {
            var name = $(this).attr('name');
            if (name) {
                name = name.replace(/\[\d+\]/, '[' + newIndex + ']');
                $(this).attr('name', name);
            }
            
            // Clear values except checkboxes
            if ($(this).attr('type') !== 'checkbox') {
                $(this).val('');
            } else {
                $(this).prop('checked', true);
            }
        });
        
        // Remove image preview
        $newRow.find('.pvc-image-preview').remove();
        
        $tbody.append($newRow);
    });
    
    // Media uploader
    $(document).on('click', '.pvc-upload-image', function(e) {
        e.preventDefault();
        var $button = $(this);
        var $input = $button.siblings('.pvc-image-url');
        
        var mediaUploader = wp.media({
            title: '<?php _e('Izvēlieties attēlu', 'pvc-calculator'); ?>',
            button: {
                text: '<?php _e('Izmantot attēlu', 'pvc-calculator'); ?>'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $input.val(attachment.url);
            
            // Show preview
            $button.siblings('.pvc-image-preview').remove();
            $button.after('<br><img src="' + attachment.url + '" class="pvc-image-preview">');
        });
        
        mediaUploader.open();
    });
    
    // Update color preview on change
    $(document).on('change', 'input[type="color"]', function() {
        $(this).siblings('.pvc-color-preview').css('background', $(this).val());
    });
});
</script>
