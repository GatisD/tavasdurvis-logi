<?php
/**
 * Default data functions for PVC Calculator
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get default products
 */
function pvc_get_default_products() {
    return array(
        array(
            'id' => 'logs',
            'label' => 'Logs',
            'image' => '',
            'enabled' => 1
        ),
        array(
            'id' => 'ardurvis',
            'label' => 'Ārdurvis',
            'image' => '',
            'enabled' => 1
        ),
        array(
            'id' => 'bidamas',
            'label' => 'Bīdāmās durvis',
            'image' => '',
            'enabled' => 1
        )
    );
}

/**
 * Get default profiles
 */
function pvc_get_default_profiles() {
    return array(
        array(
            'id' => 'rehau-80',
            'label' => 'Rehau 80',
            'for_product' => 'logs',
            'image' => '',
            'uw' => '1.3',
            'depth' => '80 mm',
            'chambers' => '6',
            'enabled' => 1
        ),
        array(
            'id' => 'premium-82',
            'label' => 'Premium 82',
            'for_product' => 'logs',
            'image' => '',
            'uw' => '0.76',
            'depth' => '82 mm',
            'chambers' => '6',
            'enabled' => 1
        ),
        array(
            'id' => 'rehau-energy',
            'label' => 'REHAU Energy +',
            'for_product' => 'logs',
            'image' => '',
            'uw' => '0.74',
            'depth' => '80 mm',
            'chambers' => '7',
            'enabled' => 1
        ),
        array(
            'id' => 'rehau-energy-durvis',
            'label' => 'REHAU Energy + durvis',
            'for_product' => 'ardurvis',
            'image' => '',
            'uw' => '0.74',
            'depth' => '80 mm',
            'chambers' => '7',
            'enabled' => 1
        ),
        array(
            'id' => 'lift-slide-hs',
            'label' => 'Lift and Slide HS Salamander',
            'for_product' => 'bidamas',
            'image' => '',
            'uw' => '',
            'depth' => '76 mm',
            'chambers' => '',
            'enabled' => 1
        )
    );
}

/**
 * Get default colors
 */
function pvc_get_default_colors() {
    return array(
        array('id' => 'balts', 'label' => 'Balts', 'hex' => '#ffffff', 'is_wood' => 0, 'enabled' => 1),
        array('id' => 'antracits', 'label' => 'Antracīts', 'hex' => '#3d3d3d', 'is_wood' => 0, 'enabled' => 1),
        array('id' => 'bruns', 'label' => 'Brūns', 'hex' => '#5c4033', 'is_wood' => 0, 'enabled' => 1),
        array('id' => 'zelta-ozols', 'label' => 'Zelta ozols', 'hex' => '#d4a574', 'is_wood' => 1, 'enabled' => 1),
        array('id' => 'tumsais-ozols', 'label' => 'Tumšais ozols', 'hex' => '#5c4033', 'is_wood' => 1, 'enabled' => 1),
        array('id' => 'mahagons', 'label' => 'Mahagons', 'hex' => '#8b3a3a', 'is_wood' => 1, 'enabled' => 1),
        array('id' => 'peleks', 'label' => 'Pelēks', 'hex' => '#808080', 'is_wood' => 0, 'enabled' => 1),
        array('id' => 'kremkrasa', 'label' => 'Krēmkrāsa', 'hex' => '#f5f5dc', 'is_wood' => 0, 'enabled' => 1)
    );
}

/**
 * Get default glazing options
 */
function pvc_get_default_glazing() {
    return array(
        array('id' => '2-slanu', 'label' => '2 Slāņu', 'description' => 'Divkāršais stiklojums', 'enabled' => 1),
        array('id' => '3-slanu', 'label' => '3 Slāņu', 'description' => 'Trīskāršais stiklojums', 'enabled' => 1)
    );
}

/**
 * Get default handles
 */
function pvc_get_default_handles() {
    return array(
        array('id' => 'standart-balts', 'label' => 'Standarta balts', 'color' => '#ffffff', 'image' => '', 'enabled' => 1),
        array('id' => 'standart-antracits', 'label' => 'Standarta antracīts', 'color' => '#3d3d3d', 'image' => '', 'enabled' => 1),
        array('id' => 'premium-hroms', 'label' => 'Premium hroms', 'color' => '#c0c0c0', 'image' => '', 'enabled' => 1),
        array('id' => 'premium-zelts', 'label' => 'Premium zeltains', 'color' => '#ffd700', 'image' => '', 'enabled' => 1)
    );
}

/**
 * Get default division types
 */
function pvc_get_default_division_types() {
    return array(
        // Windows (logs)
        array('id' => '1', 'label' => 'Viena daļa', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '2', 'label' => 'Divas daļas vertikāli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '3', 'label' => 'Trīs daļas vertikāli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '4', 'label' => 'Četras daļas', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '5', 'label' => 'Ar augšējo daļu', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '6', 'label' => 'Augšējā + divas apakšā', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '7', 'label' => 'Augšējā + četras apakšā', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '8', 'label' => 'Ar labo sānu paneli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '9', 'label' => 'Ar kreiso sānu paneli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '10', 'label' => 'Ar abiem sānu paneļiem', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '11', 'label' => 'Liela + maza daļa', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '12', 'label' => 'Maza + liela daļa', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '13', 'label' => 'Trīs ar augšējo', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '14', 'label' => 'Divas ar augšējo', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '15', 'label' => 'Četras ar augšējo', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '16', 'label' => 'Asimetrisks 1:2', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '17', 'label' => 'Asimetrisks 2:1', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '18', 'label' => 'Trīs horizontāli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '19', 'label' => 'Divas horizontāli', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '20', 'label' => 'Komplekss dalījums', 'for_product' => 'logs', 'enabled' => 1),
        // Doors (ardurvis)
        array('id' => '1', 'label' => 'Viena vērtne', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '2', 'label' => 'Divas vērtnes', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '3', 'label' => 'Ar labo sānu paneli', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '4', 'label' => 'Ar kreiso sānu paneli', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '5', 'label' => 'Ar abiem sānu paneļiem', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '6', 'label' => 'Ar augšējo daļu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '7', 'label' => 'Divas vērtnes + augšējā', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '8', 'label' => 'Ar sānu un augšējo (labi)', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '9', 'label' => 'Ar sānu un augšējo (kreisi)', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '10', 'label' => 'Pilna ar paneļiem', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '11', 'label' => 'Stikla durvis', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '12', 'label' => 'Pusstikla durvis', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '13', 'label' => 'Ar dekoratīvu stiklu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '14', 'label' => 'Moderna ar sānu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '15', 'label' => 'Klasiska divvērtņu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '16', 'label' => 'Ar lodziņu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '17', 'label' => 'Divvērtņu ar lodziņu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '18', 'label' => 'Ar sānu lodziņu', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '19', 'label' => 'Industriāla stila', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '20', 'label' => 'Premium variants', 'for_product' => 'ardurvis', 'enabled' => 1)
    );
}

/**
 * Get default opening types
 */
function pvc_get_default_opening_types() {
    return array(
        // Windows (logs)
        array('id' => '1', 'label' => 'Fiksēts (neatveras)', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '2', 'label' => 'Grozāms (sānis)', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '3', 'label' => 'Verāms (augša)', 'for_product' => 'logs', 'enabled' => 1),
        array('id' => '4', 'label' => 'Grozāms + Verāms', 'for_product' => 'logs', 'enabled' => 1),
        // Doors (ardurvis)
        array('id' => '1', 'label' => 'Atveras pa labi (uz iekšu)', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '2', 'label' => 'Atveras pa kreisi (uz iekšu)', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '3', 'label' => 'Atveras pa labi (uz āru)', 'for_product' => 'ardurvis', 'enabled' => 1),
        array('id' => '4', 'label' => 'Atveras pa kreisi (uz āru)', 'for_product' => 'ardurvis', 'enabled' => 1),
        // Sliding doors (bidamas)
        array('id' => '1', 'label' => 'Bīdāms pa labi', 'for_product' => 'bidamas', 'enabled' => 1),
        array('id' => '2', 'label' => 'Bīdāms pa kreisi', 'for_product' => 'bidamas', 'enabled' => 1)
    );
}

/**
 * Get default size limits
 */
function pvc_get_default_size_limits() {
    return array(
        'min_width' => 400,
        'max_width' => 4000,
        'min_height' => 400,
        'max_height' => 3000,
        'default_width' => 1000,
        'default_height' => 1200
    );
}

/**
 * Get default labels
 */
function pvc_get_default_labels() {
    return array(
        'step1_title' => '1. PVC konstrukcija',
        'step1_desc' => 'Sāciet izvēloties PVC konstrukciju uz tās nospiežot. 👆',
        'step2_title' => '2. Profils',
        'step2_desc' => 'Izvēlieties profila veidu.',
        'step3_title' => '3. Dalījuma veids',
        'step3_desc' => 'Izvēlieties konstrukcijas dalījumu.',
        'step4_title' => '4. Vēršanās veids',
        'step4_desc' => 'Izvēlieties atvēršanās veidu.',
        'step5_title' => '5. Izmēri',
        'step5_desc' => 'Ievadiet konstrukcijas izmērus milimetros.',
        'step6_title' => '6. Krāsa no ārpuses',
        'step6_desc' => 'Izvēlieties krāsu no āra puses.',
        'step7_title' => '7. Krāsa no iekšpuses',
        'step7_desc' => 'Izvēlieties krāsu no iekšpuses.',
        'step8_title' => '8. Stiklojums',
        'step8_desc' => 'Izvēlieties stiklojuma veidu.',
        'step9_title' => '9. Rokturi',
        'step9_desc' => 'Izvēlieties roktura veidu.',
        'step10_title' => '10. Kontaktinformācija',
        'step10_desc' => 'Ievadiet savus kontaktdatus, lai saņemtu piedāvājumu.',
        'btn_next' => 'Tālāk →',
        'btn_prev' => '← Atpakaļ',
        'btn_submit' => 'Nosūtīt pieprasījumu',
        'same_color_label' => 'Tāda pati kā no ārpuses',
        'summary_title' => 'Jūsu izvēle',
        'success_title' => 'Paldies par Jūsu pieprasījumu!',
        'success_message' => 'Mēs sazināsimies ar Jums tuvākajā laikā.',
        'new_request_btn' => 'Jauns pieprasījums'
    );
}

/**
 * Get all calculator settings for frontend
 */
function pvc_get_calculator_settings() {
    return array(
        'products' => get_option('pvc_calc_products', pvc_get_default_products()),
        'profiles' => get_option('pvc_calc_profiles', pvc_get_default_profiles()),
        'divisionTypes' => get_option('pvc_calc_division_types', pvc_get_default_division_types()),
        'openingTypes' => get_option('pvc_calc_opening_types', pvc_get_default_opening_types()),
        'colors' => get_option('pvc_calc_colors', pvc_get_default_colors()),
        'glazing' => get_option('pvc_calc_glazing', pvc_get_default_glazing()),
        'handles' => get_option('pvc_calc_handles', pvc_get_default_handles()),
        'sizeLimits' => get_option('pvc_calc_size_limits', pvc_get_default_size_limits()),
        'labels' => get_option('pvc_calc_labels', pvc_get_default_labels())
    );
}

