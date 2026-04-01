<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="pvc-calculator-wrapper" id="pvc-calculator">
    <!-- Progress Steps -->
    <div class="pvc-progress">
        <div class="pvc-progress-step active" data-step="1">
            <span class="step-number">1</span>
            <span class="step-label">Konstrukcija</span>
        </div>
        <div class="pvc-progress-step" data-step="2">
            <span class="step-number">2</span>
            <span class="step-label">Profils</span>
        </div>
        <div class="pvc-progress-step" data-step="3">
            <span class="step-number">3</span>
            <span class="step-label">Dalījums</span>
        </div>
        <div class="pvc-progress-step" data-step="5">
            <span class="step-number">4</span>
            <span class="step-label">Izmēri</span>
        </div>
        <div class="pvc-progress-step" data-step="6">
            <span class="step-number">5</span>
            <span class="step-label">Krāsa</span>
        </div>
        <div class="pvc-progress-step" data-step="8">
            <span class="step-number">6</span>
            <span class="step-label">Stiklojums</span>
        </div>
        <div class="pvc-progress-step" data-step="10">
            <span class="step-number">7</span>
            <span class="step-label">Kontakti</span>
        </div>
    </div>

    <!-- Calculator Content -->
    <div class="pvc-calculator-content">
        
        <!-- Step 1: PVC Konstrukcija -->
        <div class="pvc-step active" data-step="1">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">1. PVC konstrukcija</h2>
                <p class="pvc-step-description">Sāciet izvēloties PVC konstrukciju uz tās nospiežot. 👆</p>
            </div>
            <div class="pvc-options-grid pvc-options-3">
                <div class="pvc-option" data-value="logs">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 100 100" class="pvc-icon">
                            <rect x="15" y="15" width="70" height="70" fill="none" stroke="#666" stroke-width="3"/>
                            <rect x="20" y="20" width="60" height="60" fill="#e8f4fc" stroke="#999" stroke-width="1"/>
                            <line x1="50" y1="20" x2="50" y2="80" stroke="#999" stroke-width="1" stroke-dasharray="5,5"/>
                        </svg>
                    </div>
                    <span class="pvc-option-label">Logs</span>
                </div>
                <div class="pvc-option" data-value="ardurvis">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 80 100" class="pvc-icon">
                            <rect x="10" y="10" width="60" height="85" fill="none" stroke="#666" stroke-width="3"/>
                            <rect x="15" y="15" width="23" height="75" fill="#e8f4fc" stroke="#999" stroke-width="1"/>
                            <rect x="42" y="15" width="23" height="75" fill="#e8f4fc" stroke="#999" stroke-width="1"/>
                            <circle cx="36" cy="55" r="3" fill="#666"/>
                        </svg>
                    </div>
                    <span class="pvc-option-label">Ārdurvis</span>
                </div>
                <div class="pvc-option" data-value="bidamas">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 120 100" class="pvc-icon">
                            <rect x="10" y="15" width="100" height="70" fill="none" stroke="#666" stroke-width="3"/>
                            <rect x="15" y="20" width="43" height="60" fill="#e8f4fc" stroke="#999" stroke-width="1"/>
                            <rect x="62" y="20" width="43" height="60" fill="#e8f4fc" stroke="#999" stroke-width="1"/>
                            <path d="M58 50 L50 45 L50 55 Z" fill="#666"/>
                        </svg>
                    </div>
                    <span class="pvc-option-label">Bīdāmās durvis</span>
                </div>
            </div>
        </div>

        <!-- Step 2: Profils -->
        <div class="pvc-step" data-step="2">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">2. Profils</h2>
                <p class="pvc-step-description">Izvēlieties profila veidu.</p>
            </div>
            
            <!-- Profiles for Logs -->
            <div class="pvc-options-grid pvc-options-3 pvc-profiles-logs" style="display: none;">
                <div class="pvc-option pvc-profile-option" data-value="rehau-80">
                    <div class="pvc-option-image pvc-profile-image">
                        <img src="<?php echo esc_url(PVC_CALC_PLUGIN_URL . 'assets/TavasDurvis-Logi-Images/DRUTEX LOGI/IGLO 5 CLASSIC.png'); ?>" alt="Rehau 80">
                    </div>
                    <span class="pvc-option-label">Rehau 80</span>
                    <div class="pvc-profile-specs">
                        <small>Siltuma koef. Uw=1.3</small>
                        <small>Iebūves dziļums – 80 mm</small>
                        <small>Kameru skaits – 6</small>
                    </div>
                </div>
                <div class="pvc-option pvc-profile-option" data-value="premium-82">
                    <div class="pvc-option-image pvc-profile-image">
                        <img src="<?php echo esc_url(PVC_CALC_PLUGIN_URL . 'assets/TavasDurvis-Logi-Images/DRUTEX LOGI/IGLO EDGE.png'); ?>" alt="Premium 82">
                    </div>
                    <span class="pvc-option-label">Premium 82</span>
                    <div class="pvc-profile-specs">
                        <small>Siltuma koef. Uw=0.76</small>
                        <small>Iebūves dziļums – 82 mm</small>
                        <small>Kameru skaits – 6</small>
                    </div>
                </div>
                <div class="pvc-option pvc-profile-option" data-value="rehau-energy">
                    <div class="pvc-option-image pvc-profile-image">
                        <img src="<?php echo esc_url(PVC_CALC_PLUGIN_URL . 'assets/TavasDurvis-Logi-Images/DRUTEX LOGI/IGLO ENERGY CLASSIC.png'); ?>" alt="REHAU Energy +">
                    </div>
                    <span class="pvc-option-label">REHAU Energy +</span>
                    <div class="pvc-profile-specs">
                        <small>Siltuma koef. Uw=0.74</small>
                        <small>Iebūves dziļums – 80 mm</small>
                        <small>Kameru skaits – 7</small>
                    </div>
                </div>
            </div>
            
            <!-- Profile for Ardurvis -->
            <div class="pvc-options-grid pvc-options-1 pvc-profiles-ardurvis" style="display: none;">
                <div class="pvc-option pvc-profile-option selected" data-value="rehau-energy-durvis">
                    <div class="pvc-option-image pvc-profile-image">
                        <img src="<?php echo esc_url(PVC_CALC_PLUGIN_URL . 'assets/TavasDurvis-Logi-Images/PVC ARDURVIS/1.jpg'); ?>" alt="REHAU Energy + durvis">
                    </div>
                    <span class="pvc-option-label">REHAU Energy + durvis</span>
                    <div class="pvc-profile-specs">
                        <small>Siltuma koef. Uw=0.74</small>
                        <small>Iebūves dziļums – 80 mm</small>
                        <small>Kameru skaits – 7</small>
                    </div>
                </div>
            </div>
            
            <!-- Profile for Bidamas -->
            <div class="pvc-options-grid pvc-options-1 pvc-profiles-bidamas" style="display: none;">
                <div class="pvc-option pvc-profile-option selected" data-value="lift-slide-hs">
                    <div class="pvc-option-image pvc-profile-image">
                        <img src="<?php echo esc_url(PVC_CALC_PLUGIN_URL . 'assets/TavasDurvis-Logi-Images/ALUMINIJA LOGI/MB 86 N SI.png'); ?>" alt="Lift and Slide HS Salamander">
                    </div>
                    <span class="pvc-option-label">Lift and Slide HS Salamander</span>
                    <div class="pvc-profile-specs">
                        <small>Premium bīdāmo durvju sistēma</small>
                        <small>Iebūves dziļums – 76 mm</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Dalījuma veids -->
        <div class="pvc-step" data-step="3">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">3. Dalījuma veids</h2>
                <p class="pvc-step-description">Izvēlieties konstrukcijas dalījumu.</p>
            </div>
            <div class="pvc-options-grid pvc-options-5 pvc-division-types">
                <!-- Division types will be generated by JS based on product type -->
            </div>
        </div>

        <!-- Step 5: Izmēri -->
        <div class="pvc-step" data-step="5">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">4. Izmēri</h2>
                <p class="pvc-step-description">Ievadiet konstrukcijas izmērus milimetros.</p>
            </div>
            <div class="pvc-size-inputs">
                <div class="pvc-size-preview">
                    <div class="pvc-size-preview-window">
                        <div id="pvc-size-division-preview" class="pvc-size-division-preview"></div>
                        <div class="pvc-size-width">
                            <span class="pvc-size-value" id="preview-width">1000</span>
                            <span class="pvc-size-unit">mm</span>
                        </div>
                        <div class="pvc-size-height">
                            <span class="pvc-size-value" id="preview-height">1200</span>
                            <span class="pvc-size-unit">mm</span>
                        </div>
                    </div>
                </div>
                <div class="pvc-size-fields">
                    <div class="pvc-input-group">
                        <label for="pvc-width">Platums (mm)</label>
                        <input type="number" id="pvc-width" name="width" min="400" max="4000" value="1000" step="10">
                        <span class="pvc-input-hint">400 - 4000 mm</span>
                    </div>
                    <div class="pvc-input-group">
                        <label for="pvc-height">Augstums (mm)</label>
                        <input type="number" id="pvc-height" name="height" min="400" max="3000" value="1200" step="10">
                        <span class="pvc-input-hint">400 - 3000 mm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6: Krāsa -->
        <div class="pvc-step" data-step="6">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">5. Krāsa</h2>
                <p class="pvc-step-description">Izvēlieties krāsu no āra un iekšpuses.</p>
            </div>
            <p class="pvc-color-section-label"><strong>Krāsa no ārpuses</strong></p>
            <div class="pvc-options-grid pvc-options-6 pvc-color-options">
                <div class="pvc-option pvc-color-option" data-value="balts">
                    <div class="pvc-color-swatch" style="background: #ffffff; border: 1px solid #ddd;"></div>
                    <span class="pvc-option-label">Balts</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="antracits">
                    <div class="pvc-color-swatch" style="background: #3d3d3d;"></div>
                    <span class="pvc-option-label">Antracīts</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="bruns">
                    <div class="pvc-color-swatch" style="background: #5c4033;"></div>
                    <span class="pvc-option-label">Brūns</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="zelta-ozols">
                    <div class="pvc-color-swatch" style="background: linear-gradient(135deg, #d4a574 0%, #8b6914 50%, #d4a574 100%);"></div>
                    <span class="pvc-option-label">Zelta ozols</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="tumsais-ozols">
                    <div class="pvc-color-swatch" style="background: linear-gradient(135deg, #5c4033 0%, #3d2817 50%, #5c4033 100%);"></div>
                    <span class="pvc-option-label">Tumšais ozols</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="mahagons">
                    <div class="pvc-color-swatch" style="background: linear-gradient(135deg, #8b3a3a 0%, #5c1a1a 50%, #8b3a3a 100%);"></div>
                    <span class="pvc-option-label">Mahagons</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="peleks">
                    <div class="pvc-color-swatch" style="background: #808080;"></div>
                    <span class="pvc-option-label">Pelēks</span>
                </div>
                <div class="pvc-option pvc-color-option" data-value="kremkrasa">
                    <div class="pvc-color-swatch" style="background: #f5f5dc;"></div>
                    <span class="pvc-option-label">Krēmkrāsa</span>
                </div>
            </div>
            <div class="pvc-same-color-option" style="margin-top: 25px; margin-bottom: 10px;">
                <label class="pvc-checkbox-label">
                    <input type="checkbox" id="pvc-same-color" name="same_color">
                    <span class="pvc-checkbox-custom"></span>
                    <span>Tāda pati kā no ārpuses</span>
                </label>
            </div>
            <p class="pvc-color-section-label pvc-inside-color-label"><strong>Krāsa no iekšpuses</strong></p>
            <div class="pvc-options-grid pvc-options-6 pvc-color-options pvc-inside-colors">
                <div class="pvc-option pvc-color-option" data-value="balts"><div class="pvc-color-swatch" style="background: #ffffff; border: 1px solid #ddd;"></div><span class="pvc-option-label">Balts</span></div>
                <div class="pvc-option pvc-color-option" data-value="antracits"><div class="pvc-color-swatch" style="background: #3d3d3d;"></div><span class="pvc-option-label">Antracīts</span></div>
                <div class="pvc-option pvc-color-option" data-value="bruns"><div class="pvc-color-swatch" style="background: #5c4033;"></div><span class="pvc-option-label">Brūns</span></div>
                <div class="pvc-option pvc-color-option" data-value="zelta-ozols"><div class="pvc-color-swatch" style="background: linear-gradient(135deg, #d4a574 0%, #8b6914 50%, #d4a574 100%);"></div><span class="pvc-option-label">Zelta ozols</span></div>
                <div class="pvc-option pvc-color-option" data-value="tumsais-ozols"><div class="pvc-color-swatch" style="background: linear-gradient(135deg, #5c4033 0%, #3d2817 50%, #5c4033 100%);"></div><span class="pvc-option-label">Tumšais ozols</span></div>
                <div class="pvc-option pvc-color-option" data-value="mahagons"><div class="pvc-color-swatch" style="background: linear-gradient(135deg, #8b3a3a 0%, #5c1a1a 50%, #8b3a3a 100%);"></div><span class="pvc-option-label">Mahagons</span></div>
                <div class="pvc-option pvc-color-option" data-value="peleks"><div class="pvc-color-swatch" style="background: #808080;"></div><span class="pvc-option-label">Pelēks</span></div>
                <div class="pvc-option pvc-color-option" data-value="kremkrasa"><div class="pvc-color-swatch" style="background: #f5f5dc;"></div><span class="pvc-option-label">Krēmkrāsa</span></div>
            </div>
        </div>

        <!-- Step 8: Stiklojums -->
        <div class="pvc-step" data-step="8">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">6. Stiklojums</h2>
                <p class="pvc-step-description">Izvēlieties stiklojuma veidu.</p>
            </div>
            <div class="pvc-options-grid pvc-options-4 pvc-glazing-options">
                <div class="pvc-option pvc-glazing-option" data-value="2-slanu">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 80 100" class="pvc-icon">
                            <rect x="15" y="10" width="50" height="80" fill="#e8f4fc" stroke="#666" stroke-width="2"/>
                            <line x1="15" y1="50" x2="65" y2="50" stroke="#999" stroke-width="1"/>
                            <text x="40" y="35" text-anchor="middle" font-size="10" fill="#666">2</text>
                            <text x="40" y="70" text-anchor="middle" font-size="10" fill="#666">slāņi</text>
                        </svg>
                    </div>
                    <span class="pvc-option-label">2 Slāņu</span>
                    <div class="pvc-glazing-specs">
                        <small>Divkāršais stiklojums</small>
                    </div>
                </div>
                <div class="pvc-option pvc-glazing-option" data-value="3-slanu">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 80 100" class="pvc-icon">
                            <rect x="15" y="10" width="50" height="80" fill="#e8f4fc" stroke="#666" stroke-width="2"/>
                            <line x1="15" y1="37" x2="65" y2="37" stroke="#999" stroke-width="1"/>
                            <line x1="15" y1="63" x2="65" y2="63" stroke="#999" stroke-width="1"/>
                            <text x="40" y="28" text-anchor="middle" font-size="10" fill="#666">3</text>
                            <text x="40" y="55" text-anchor="middle" font-size="10" fill="#666">slāņi</text>
                        </svg>
                    </div>
                    <span class="pvc-option-label">3 Slāņu</span>
                    <div class="pvc-glazing-specs">
                        <small>Trīskāršais stiklojums</small>
                    </div>
                </div>
                <div class="pvc-option pvc-glazing-option" data-value="2-slanu-termo">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 80 100" class="pvc-icon">
                            <rect x="15" y="10" width="50" height="80" fill="#e8f4fc" stroke="#666" stroke-width="2"/>
                            <line x1="15" y1="50" x2="65" y2="50" stroke="#999" stroke-width="1"/>
                            <text x="40" y="30" text-anchor="middle" font-size="10" fill="#666">2</text>
                            <text x="40" y="70" text-anchor="middle" font-size="8" fill="#e53935">TERMO</text>
                        </svg>
                    </div>
                    <span class="pvc-option-label">2 Slāņu ar termo</span>
                    <div class="pvc-glazing-specs">
                        <small>Divkāršais ar termo</small>
                    </div>
                </div>
                <div class="pvc-option pvc-glazing-option" data-value="3-slanu-termo">
                    <div class="pvc-option-image">
                        <svg viewBox="0 0 80 100" class="pvc-icon">
                            <rect x="15" y="10" width="50" height="80" fill="#e8f4fc" stroke="#666" stroke-width="2"/>
                            <line x1="15" y1="37" x2="65" y2="37" stroke="#999" stroke-width="1"/>
                            <line x1="15" y1="63" x2="65" y2="63" stroke="#999" stroke-width="1"/>
                            <text x="40" y="26" text-anchor="middle" font-size="10" fill="#666">3</text>
                            <text x="40" y="56" text-anchor="middle" font-size="8" fill="#e53935">TERMO</text>
                        </svg>
                    </div>
                    <span class="pvc-option-label">3 Slāņu ar termo</span>
                    <div class="pvc-glazing-specs">
                        <small>Trīskāršais ar termo</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 10: Contact Form -->
        <div class="pvc-step" data-step="10">
            <div class="pvc-step-header">
                <h2 class="pvc-step-title">7. Kontaktinformācija</h2>
                <p class="pvc-step-description">Ievadiet savus kontaktdatus, lai saņemtu piedāvājumu.</p>
            </div>
            
            <!-- Summary -->
            <div class="pvc-summary">
                <h3>Jūsu izvēle</h3>
                <div class="pvc-summary-grid" id="pvc-summary-content">
                    <!-- Summary will be populated by JS -->
                </div>
            </div>
            
            <!-- Contact Form -->
            <form id="pvc-contact-form" class="pvc-contact-form">
                <div class="pvc-form-row">
                    <div class="pvc-input-group">
                        <label for="customer-name">Vārds, Uzvārds *</label>
                        <input type="text" id="customer-name" name="customer_name" required>
                    </div>
                </div>
                <div class="pvc-form-row pvc-form-row-2">
                    <div class="pvc-input-group">
                        <label for="customer-email">E-pasts *</label>
                        <input type="email" id="customer-email" name="customer_email" required>
                    </div>
                    <div class="pvc-input-group">
                        <label for="customer-phone">Tālrunis *</label>
                        <input type="tel" id="customer-phone" name="customer_phone" required>
                    </div>
                </div>
                <div class="pvc-form-row">
                    <div class="pvc-input-group">
                        <label for="customer-message">Papildu komentāri</label>
                        <textarea id="customer-message" name="customer_message" rows="4"></textarea>
                    </div>
                </div>
                <div class="pvc-form-row">
                    <div class="pvc-input-group">
                        <label for="customer-file">Pievienot failu (PDF, JPG, PNG — maks. 5 MB)</label>
                        <input type="file" id="customer-file" name="customer_file" accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
                    </div>
                </div>
                <div class="pvc-form-submit">
                    <button type="submit" class="pvc-btn pvc-btn-primary pvc-btn-submit">
                        <span class="btn-text">Nosūtīt pieprasījumu</span>
                        <span class="btn-loader" style="display: none;">
                            <svg class="spinner" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="30 70"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
            
            <!-- Success Message -->
            <div class="pvc-success-message" id="pvc-success-message" style="display: none;">
                <div class="pvc-success-icon">✓</div>
                <h3>Paldies par Jūsu pieprasījumu!</h3>
                <p>Mēs sazināsimies ar Jums tuvākajā laikā.</p>
                <button type="button" class="pvc-btn pvc-btn-secondary" id="pvc-start-over">Jauns pieprasījums</button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="pvc-navigation">
        <button type="button" class="pvc-btn pvc-btn-secondary pvc-btn-prev" style="display: none;">
            ← Atpakaļ
        </button>
        <button type="button" class="pvc-btn pvc-btn-primary pvc-btn-next" disabled>
            Tālāk →
        </button>
    </div>
</div>
