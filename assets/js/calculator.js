/**
 * PVC Calculator JavaScript
 */
(function ($) {
    'use strict';

    // Calculator State
    const state = {
        currentStep: 1,
        totalSteps: 10,
        selections: {
            productType: null,
            profile: null,
            divisionType: null,
            openingType: null,
            width: 1000,
            height: 1200,
            outsideColor: null,
            insideColor: null,
            sameColor: false,
            glazing: null,
            handle: null
        }
    };

    // Division Types Configuration
    const divisionTypes = {
        logs: [
            { id: 1, label: 'Viens', svg: createDivisionSVG([['full']]) },
            { id: 2, label: 'Divi vertikāli', svg: createDivisionSVG([['half', 'half']]) },
            { id: 3, label: 'Trīs vertikāli', svg: createDivisionSVG([['third', 'third', 'third']]) },
            { id: 4, label: 'Četri', svg: createDivisionSVG([['half', 'half'], ['half', 'half']]) },
            { id: 5, label: 'Ar augšējo', svg: createDivisionSVG([['full'], ['full']], true) },
            { id: 6, label: 'Ar augšējo 2', svg: createDivisionSVG([['full'], ['half', 'half']], true) },
            { id: 7, label: 'Ar augšējo 3', svg: createDivisionSVG([['half', 'half'], ['half', 'half']], true) },
            { id: 8, label: 'Ar sānu', svg: createDivisionSVG([['quarter', 'threequarter']]) },
            { id: 9, label: 'Ar sānu 2', svg: createDivisionSVG([['threequarter', 'quarter']]) },
            { id: 10, label: 'Ar sāniem', svg: createDivisionSVG([['quarter', 'half', 'quarter']]) },
            { id: 11, label: 'Liels un mazs', svg: createDivisionSVG([['twothird', 'third']]) },
            { id: 12, label: 'Mazs un liels', svg: createDivisionSVG([['third', 'twothird']]) },
            { id: 13, label: 'Trīs ar augšu', svg: createDivisionSVG([['third', 'third', 'third'], ['third', 'third', 'third']], true) },
            { id: 14, label: 'Divi ar augšu', svg: createDivisionSVG([['half', 'half'], ['full']], true) },
            { id: 15, label: 'Četri ar augšu', svg: createDivisionSVG([['half', 'half'], ['half', 'half'], ['full']], true) },
            { id: 16, label: 'Asimetrisks', svg: createDivisionSVG([['third', 'twothird']]) },
            { id: 17, label: 'Asimetrisks 2', svg: createDivisionSVG([['twothird', 'third']]) },
            { id: 18, label: 'Trīs horizontāli', svg: createDivisionSVG([['full'], ['full'], ['full']]) },
            { id: 19, label: 'Divi horizontāli', svg: createDivisionSVG([['full'], ['full']]) },
            { id: 20, label: 'Komplekss', svg: createDivisionSVG([['quarter', 'half', 'quarter'], ['quarter', 'half', 'quarter']], true) }
        ],
        ardurvis: [
            { id: 1, label: 'Viena vērtne', svg: createDoorSVG(1) },
            { id: 2, label: 'Divas vērtnes', svg: createDoorSVG(2) },
            { id: 3, label: 'Ar sānu paneli', svg: createDoorSVG(1, 'right') },
            { id: 4, label: 'Ar kreiso paneli', svg: createDoorSVG(1, 'left') },
            { id: 5, label: 'Ar abiem paneļiem', svg: createDoorSVG(1, 'both') },
            { id: 6, label: 'Ar augšējo', svg: createDoorSVG(1, null, true) },
            { id: 7, label: 'Divas ar augšējo', svg: createDoorSVG(2, null, true) },
            { id: 8, label: 'Ar sānu un augšējo', svg: createDoorSVG(1, 'right', true) },
            { id: 9, label: 'Ar kreiso un augšējo', svg: createDoorSVG(1, 'left', true) },
            { id: 10, label: 'Pilna ar paneļiem', svg: createDoorSVG(1, 'both', true) },
            { id: 11, label: 'Stikla durvis', svg: createDoorSVG(1, null, false, true) },
            { id: 12, label: 'Puslogam', svg: createDoorSVG(1, null, false, false, true) },
            { id: 13, label: 'Ar dekoratīvu', svg: createDoorSVG(2, null, false, true) },
            { id: 14, label: 'Moderna', svg: createDoorSVG(1, 'right', false, true) },
            { id: 15, label: 'Klasiska', svg: createDoorSVG(2, 'both', false, false) },
            { id: 16, label: 'Ar logu', svg: createDoorSVG(1, null, false, false, false, true) },
            { id: 17, label: 'Divvērtņu ar logu', svg: createDoorSVG(2, null, false, false, false, true) },
            { id: 18, label: 'Ar sānu logu', svg: createDoorSVG(1, 'right', false, false, false, true) },
            { id: 19, label: 'Industriāla', svg: createDoorSVG(2, null, true, false, false, true) },
            { id: 20, label: 'Premium', svg: createDoorSVG(2, 'both', true, true, false, false) }
        ],
        bidamas: [] // Skipped for sliding doors
    };

    // Opening Types Configuration
    const openingTypes = {
        logs: [
            { id: 1, label: 'Fiksēts', svg: createOpeningSVG('fixed') },
            { id: 2, label: 'Grozāms', svg: createOpeningSVG('turn') },
            { id: 3, label: 'Verāms', svg: createOpeningSVG('tilt') },
            { id: 4, label: 'Grozāms/Verāms', svg: createOpeningSVG('tilt-turn') }
        ],
        ardurvis: [
            { id: 1, label: 'Pa labi', svg: createDoorOpeningSVG('right') },
            { id: 2, label: 'Pa kreisi', svg: createDoorOpeningSVG('left') },
            { id: 3, label: 'Pa labi (uz āru)', svg: createDoorOpeningSVG('right-out') },
            { id: 4, label: 'Pa kreisi (uz āru)', svg: createDoorOpeningSVG('left-out') }
        ],
        bidamas: [
            { id: 1, label: 'Bīdāms pa labi', svg: createSlidingSVG('right') },
            { id: 2, label: 'Bīdāms pa kreisi', svg: createSlidingSVG('left') }
        ]
    };

    // Helper function to get label from settings
    function getLabel(type, id, productType = null) {
        const settings = pvcCalc.settings || {};
        if (type === 'product') {
            const products = settings.products || [];
            const product = products.find(p => p.id === id);
            return product ? product.label : id;
        }
        if (type === 'profile') {
            const profiles = settings.profiles || [];
            const profile = profiles.find(p => p.id === id);
            return profile ? profile.label : id;
        }
        if (type === 'division') {
            // Use local divisionTypes object (same as UI)
            const types = divisionTypes[productType] || divisionTypes.logs || [];
            const division = types.find(d => d.id == id);
            return division ? division.label : `Dalījums #${id}`;
        }
        if (type === 'opening') {
            // Use local openingTypes object (same as UI)
            const types = openingTypes[productType] || openingTypes.logs || [];
            const opening = types.find(o => o.id == id);
            return opening ? opening.label : `Vēršanās #${id}`;
        }
        if (type === 'color') {
            const colors = settings.colors || [];
            const color = colors.find(c => c.id === id);
            return color ? color.label : id;
        }
        if (type === 'glazing') {
            const glazingOptions = settings.glazing || [];
            const glaze = glazingOptions.find(g => g.id === id);
            return glaze ? glaze.label : id;
        }
        if (type === 'handle') {
            const handles = settings.handles || [];
            const handle = handles.find(h => h.id === id);
            return handle ? handle.label : id;
        }
        return id;
    }

    // Get division info (label + SVG) for email
    function getDivisionInfo(id, productType) {
        const types = divisionTypes[productType] || divisionTypes.logs || [];
        const division = types.find(d => d.id == id);
        return division || { label: `Dalījums #${id}`, svg: '' };
    }

    // Get opening info (label + SVG) for email
    function getOpeningInfo(id, productType) {
        const types = openingTypes[productType] || openingTypes.logs || [];
        const opening = types.find(o => o.id == id);
        return opening || { label: `Vēršanās #${id}`, svg: '' };
    }

    // Get label settings
    function getLabels() {
        return pvcCalc.settings?.labels || {};
    }

    // Get color hex value from settings
    function getColorHex(colorId) {
        const settings = pvcCalc.settings || {};
        const colors = settings.colors || [];
        const color = colors.find(c => c.id === colorId);
        return color ? color.hex : '#ffffff';
    }

    // Initialize Calculator
    function init() {
        bindEvents();
        updateNavigation();
        renderDivisionTypes();
        renderOpeningTypes();
    }

    // Bind Events
    function bindEvents() {
        // Step 1: Product Type Selection
        $('.pvc-step[data-step="1"] .pvc-option').on('click', function () {
            selectOption($(this), 'productType');
            showProfilesForProduct(state.selections.productType);
            renderDivisionTypes();
            renderOpeningTypes();
        });

        // Step 2: Profile Selection
        $(document).on('click', '.pvc-step[data-step="2"] .pvc-option', function () {
            selectOption($(this), 'profile');
        });

        // Step 3: Division Type Selection
        $(document).on('click', '.pvc-step[data-step="3"] .pvc-option', function () {
            selectOption($(this), 'divisionType');
            renderOpeningTypes();
        });

        // Step 4: Opening Type Selection
        $(document).on('click', '.pvc-step[data-step="4"] .pvc-option', function () {
            selectOption($(this), 'openingType');
        });

        // Step 5: Size Inputs
        $('#pvc-width, #pvc-height').on('input', function () {
            const field = $(this).attr('id') === 'pvc-width' ? 'width' : 'height';
            state.selections[field] = parseInt($(this).val()) || 0;
            updateSizePreview();
            updateNavigation();
        });

        // Step 6: Outside Color Selection
        $('.pvc-step[data-step="6"] .pvc-option').on('click', function () {
            selectOption($(this), 'outsideColor');
        });

        // Step 7: Same Color Checkbox
        $('#pvc-same-color').on('change', function () {
            state.selections.sameColor = $(this).is(':checked');
            if (state.selections.sameColor) {
                state.selections.insideColor = state.selections.outsideColor;
                $('.pvc-inside-colors').addClass('disabled');
                // Select the same color visually
                $('.pvc-inside-colors .pvc-option').removeClass('selected');
                $(`.pvc-inside-colors .pvc-option[data-value="${state.selections.outsideColor}"]`).addClass('selected');
            } else {
                $('.pvc-inside-colors').removeClass('disabled');
            }
            updateNavigation();
        });

        // Step 7: Inside Color Selection
        $('.pvc-step[data-step="7"] .pvc-inside-colors .pvc-option').on('click', function () {
            if (!state.selections.sameColor) {
                selectOption($(this), 'insideColor');
            }
        });

        // Step 8: Glazing Selection
        $('.pvc-step[data-step="8"] .pvc-option').on('click', function () {
            selectOption($(this), 'glazing');
        });

        // Step 9: Handle Selection
        $('.pvc-step[data-step="9"] .pvc-option').on('click', function () {
            selectOption($(this), 'handle');
        });

        // Navigation
        $('.pvc-btn-next').on('click', nextStep);
        $('.pvc-btn-prev').on('click', prevStep);

        // Progress Step Click
        $('.pvc-progress-step').on('click', function () {
            const step = parseInt($(this).data('step'));
            if (step < state.currentStep) {
                goToStep(step);
            }
        });

        // Contact Form Submission
        $('#pvc-contact-form').on('submit', function (e) {
            e.preventDefault();
            submitForm();
        });

        // Start Over
        $('#pvc-start-over').on('click', function () {
            resetCalculator();
        });
    }

    // Select Option
    function selectOption($element, field) {
        const container = $element.closest('.pvc-options-grid, .pvc-step');
        container.find('.pvc-option').removeClass('selected');
        $element.addClass('selected');
        state.selections[field] = $element.data('value');
        updateNavigation();
    }

    // Show Profiles for Product Type
    function showProfilesForProduct(productType) {
        $('.pvc-profiles-logs, .pvc-profiles-ardurvis, .pvc-profiles-bidamas').hide();

        if (productType === 'logs') {
            $('.pvc-profiles-logs').show();
            // Clear selection
            state.selections.profile = null;
            $('.pvc-profiles-logs .pvc-option').removeClass('selected');
        } else if (productType === 'ardurvis') {
            $('.pvc-profiles-ardurvis').show();
            // Auto-select the only option
            state.selections.profile = 'rehau-energy-durvis';
        } else if (productType === 'bidamas') {
            $('.pvc-profiles-bidamas').show();
            // Auto-select the only option
            state.selections.profile = 'lift-slide-hs';
        }
    }

    // Render Division Types
    function renderDivisionTypes() {
        const container = $('.pvc-division-types');
        container.empty();

        const types = divisionTypes[state.selections.productType] || divisionTypes.logs;

        types.forEach(type => {
            const html = `
                <div class="pvc-option pvc-division-option" data-value="${type.id}">
                    <div class="pvc-option-image">
                        ${type.svg}
                    </div>
                    <span class="pvc-option-label">${type.label}</span>
                </div>
            `;
            container.append(html);
        });
    }

    // Render Opening Types
    function renderOpeningTypes() {
        const container = $('.pvc-opening-types');
        container.empty();

        const productType = state.selections.productType || 'logs';
        const types = openingTypes[productType] || openingTypes.logs;

        // Update title for sliding doors
        if (productType === 'bidamas') {
            $('.pvc-opening-title').text('4. Bīdīšanās veids');
        } else {
            $('.pvc-opening-title').text('4. Vēršanās veids');
        }

        types.forEach(type => {
            const html = `
                <div class="pvc-option" data-value="${type.id}">
                    <div class="pvc-option-image">
                        ${type.svg}
                    </div>
                    <span class="pvc-option-label">${type.label}</span>
                </div>
            `;
            container.append(html);
        });
    }

    // Update Size Preview
    function updateSizePreview() {
        $('#preview-width').text(state.selections.width);
        $('#preview-height').text(state.selections.height);
    }

    // Navigation
    function nextStep() {
        let nextStepNum = state.currentStep + 1;

        // Skip division step for sliding doors
        if (state.selections.productType === 'bidamas' && nextStepNum === 3) {
            nextStepNum = 4;
        }

        if (nextStepNum <= state.totalSteps) {
            goToStep(nextStepNum);
        }
    }

    function prevStep() {
        let prevStepNum = state.currentStep - 1;

        // Skip division step for sliding doors when going back
        if (state.selections.productType === 'bidamas' && prevStepNum === 3) {
            prevStepNum = 2;
        }

        if (prevStepNum >= 1) {
            goToStep(prevStepNum);
        }
    }

    function goToStep(step) {
        // Update progress
        $('.pvc-progress-step').removeClass('active');
        $('.pvc-progress-step').each(function () {
            const stepNum = parseInt($(this).data('step'));
            if (stepNum < step) {
                $(this).addClass('completed');
            } else {
                $(this).removeClass('completed');
            }
            if (stepNum === step) {
                $(this).addClass('active');
            }
        });

        // Update content
        $('.pvc-step').removeClass('active');
        $(`.pvc-step[data-step="${step}"]`).addClass('active');

        state.currentStep = step;
        updateNavigation();

        // Generate summary on last step
        if (step === 10) {
            generateSummary();
        }

        // Scroll to top of calculator
        $('html, body').animate({
            scrollTop: $('#pvc-calculator').offset().top - 20
        }, 300);
    }

    function updateNavigation() {
        const $prevBtn = $('.pvc-btn-prev');
        const $nextBtn = $('.pvc-btn-next');

        // Show/hide prev button
        if (state.currentStep === 1) {
            $prevBtn.hide();
        } else {
            $prevBtn.show();
        }

        // Hide next on last step (form submit handles it)
        if (state.currentStep === 10) {
            $nextBtn.hide();
        } else {
            $nextBtn.show();
        }

        // Enable/disable next based on selection
        $nextBtn.prop('disabled', !canProceed());
    }

    function canProceed() {
        switch (state.currentStep) {
            case 1:
                return !!state.selections.productType;
            case 2:
                return !!state.selections.profile;
            case 3:
                // Skip for sliding doors
                if (state.selections.productType === 'bidamas') {
                    return true;
                }
                return !!state.selections.divisionType;
            case 4:
                return !!state.selections.openingType;
            case 5:
                return state.selections.width >= 400 && state.selections.width <= 4000 &&
                    state.selections.height >= 400 && state.selections.height <= 3000;
            case 6:
                return !!state.selections.outsideColor;
            case 7:
                return !!state.selections.insideColor || state.selections.sameColor;
            case 8:
                return !!state.selections.glazing;
            case 9:
                return !!state.selections.handle;
            default:
                return true;
        }
    }

    // Generate Summary
    function generateSummary() {
        const container = $('#pvc-summary-content');
        container.empty();

        const items = [
            { label: 'Produkta veids', value: getLabel('product', state.selections.productType) },
            { label: 'Profils', value: getLabel('profile', state.selections.profile) },
            { label: 'Dalījuma veids', value: state.selections.divisionType ? getLabel('division', state.selections.divisionType, state.selections.productType) : 'Nav' },
            { label: 'Vēršanās veids', value: state.selections.openingType ? getLabel('opening', state.selections.openingType, state.selections.productType) : '' },
            { label: 'Izmēri', value: `${state.selections.width} x ${state.selections.height} mm` },
            { label: 'Krāsa ārā', value: getLabel('color', state.selections.outsideColor) },
            { label: 'Krāsa iekšā', value: state.selections.sameColor ? getLabel('color', state.selections.outsideColor) : getLabel('color', state.selections.insideColor) },
            { label: 'Stiklojums', value: getLabel('glazing', state.selections.glazing) },
            { label: 'Rokturis', value: getLabel('handle', state.selections.handle) }
        ];

        items.forEach(item => {
            if (item.value) {
                const html = `
                    <div class="pvc-summary-item">
                        <span class="pvc-summary-label">${item.label}</span>
                        <span class="pvc-summary-value">${item.value}</span>
                    </div>
                `;
                container.append(html);
            }
        });
    }

    // Submit Form
    function submitForm() {
        const $form = $('#pvc-contact-form');
        const $submitBtn = $form.find('.pvc-btn-submit');
        const $btnText = $submitBtn.find('.btn-text');
        const $btnLoader = $submitBtn.find('.btn-loader');

        // Validate
        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return;
        }

        // Show loader
        $btnText.hide();
        $btnLoader.show();
        $submitBtn.prop('disabled', true);

        // Get division and opening info
        const divisionInfo = state.selections.divisionType ? getDivisionInfo(state.selections.divisionType, state.selections.productType) : null;
        const openingInfo = state.selections.openingType ? getOpeningInfo(state.selections.openingType, state.selections.productType) : null;

        // Prepare data
        const data = {
            action: 'pvc_submit_quote',
            nonce: pvcCalc.nonce,
            product_type: state.selections.productType,
            profile: getLabel('profile', state.selections.profile),
            division_type: divisionInfo ? divisionInfo.label : '',
            division_svg: divisionInfo ? divisionInfo.svg : '',
            opening_type: openingInfo ? openingInfo.label : '',
            opening_svg: openingInfo ? openingInfo.svg : '',
            width: state.selections.width,
            height: state.selections.height,
            outside_color: getLabel('color', state.selections.outsideColor),
            outside_color_hex: getColorHex(state.selections.outsideColor),
            inside_color: state.selections.sameColor ? getLabel('color', state.selections.outsideColor) : getLabel('color', state.selections.insideColor),
            inside_color_hex: state.selections.sameColor ? getColorHex(state.selections.outsideColor) : getColorHex(state.selections.insideColor),
            glazing: getLabel('glazing', state.selections.glazing),
            handle: getLabel('handle', state.selections.handle),
            customer_name: $('#customer-name').val(),
            customer_email: $('#customer-email').val(),
            customer_phone: $('#customer-phone').val(),
            customer_message: $('#customer-message').val()
        };

        // Submit via AJAX
        $.post(pvcCalc.ajaxUrl, data)
            .done(function (response) {
                if (response.success) {
                    // Show success message
                    $form.hide();
                    $('.pvc-summary').hide();
                    $('#pvc-success-message').show();
                    $('.pvc-navigation').hide();
                } else {
                    alert(response.data.message || pvcCalc.strings.submitError);
                }
            })
            .fail(function () {
                alert(pvcCalc.strings.submitError);
            })
            .always(function () {
                $btnText.show();
                $btnLoader.hide();
                $submitBtn.prop('disabled', false);
            });
    }

    // Reset Calculator
    function resetCalculator() {
        state.currentStep = 1;
        state.selections = {
            productType: null,
            profile: null,
            divisionType: null,
            openingType: null,
            width: 1000,
            height: 1200,
            outsideColor: null,
            insideColor: null,
            sameColor: false,
            glazing: null,
            handle: null
        };

        // Reset UI
        $('.pvc-option').removeClass('selected');
        $('#pvc-width').val(1000);
        $('#pvc-height').val(1200);
        $('#pvc-same-color').prop('checked', false);
        $('#pvc-contact-form')[0].reset();
        $('#pvc-contact-form').show();
        $('.pvc-summary').show();
        $('#pvc-success-message').hide();
        $('.pvc-navigation').show();
        $('.pvc-inside-colors').removeClass('disabled');

        updateSizePreview();
        goToStep(1);
    }

    // SVG Helper Functions
    function createDivisionSVG(rows, hasTransom = false) {
        let svg = '<svg viewBox="0 0 80 100" class="pvc-icon">';
        svg += '<rect x="5" y="5" width="70" height="90" fill="none" stroke="#666" stroke-width="2"/>';

        const startY = hasTransom ? 25 : 10;
        const availableHeight = hasTransom ? 70 : 85;
        const rowHeight = availableHeight / rows.length;

        if (hasTransom) {
            // Top transom
            svg += '<rect x="8" y="8" width="64" height="15" fill="#e8f4fc" stroke="#999" stroke-width="1"/>';
            svg += '<line x1="8" y1="23" x2="72" y2="23" stroke="#999" stroke-width="1"/>';
        }

        rows.forEach((cols, rowIndex) => {
            const y = startY + (rowIndex * rowHeight);
            let x = 8;

            cols.forEach((colSize, colIndex) => {
                let width;
                switch (colSize) {
                    case 'full': width = 64; break;
                    case 'half': width = 32; break;
                    case 'third': width = 21; break;
                    case 'quarter': width = 16; break;
                    case 'twothird': width = 42; break;
                    case 'threequarter': width = 48; break;
                    default: width = 64;
                }

                svg += `<rect x="${x}" y="${y}" width="${width}" height="${rowHeight - 3}" fill="#e8f4fc" stroke="#999" stroke-width="1"/>`;
                x += width;
            });
        });

        svg += '</svg>';
        return svg;
    }

    function createDoorSVG(panels, sidePanel = null, hasTransom = false, isGlass = false, hasHalfGlass = false, hasWindow = false) {
        let svg = '<svg viewBox="0 0 80 100" class="pvc-icon">';
        svg += '<rect x="5" y="5" width="70" height="90" fill="none" stroke="#666" stroke-width="2"/>';

        const startY = hasTransom ? 20 : 8;
        const panelHeight = hasTransom ? 75 : 87;

        if (hasTransom) {
            svg += '<rect x="8" y="8" width="64" height="10" fill="#e8f4fc" stroke="#999" stroke-width="1"/>';
        }

        let startX = 8;
        let mainWidth = 64;

        if (sidePanel === 'left' || sidePanel === 'both') {
            svg += `<rect x="8" y="${startY}" width="15" height="${panelHeight}" fill="#e8f4fc" stroke="#999" stroke-width="1"/>`;
            startX = 23;
            mainWidth -= 15;
        }

        if (sidePanel === 'right' || sidePanel === 'both') {
            svg += `<rect x="57" y="${startY}" width="15" height="${panelHeight}" fill="#e8f4fc" stroke="#999" stroke-width="1"/>`;
            mainWidth -= 15;
        }

        const panelWidth = mainWidth / panels;
        for (let i = 0; i < panels; i++) {
            const fill = isGlass ? '#d0e8f7' : '#ddd';
            svg += `<rect x="${startX + (i * panelWidth)}" y="${startY}" width="${panelWidth}" height="${panelHeight}" fill="${fill}" stroke="#999" stroke-width="1"/>`;

            if (hasWindow) {
                const windowY = startY + 10;
                svg += `<rect x="${startX + (i * panelWidth) + 5}" y="${windowY}" width="${panelWidth - 10}" height="25" fill="#e8f4fc" stroke="#999" stroke-width="1"/>`;
            }

            // Door handle
            svg += `<circle cx="${startX + (i * panelWidth) + panelWidth - 8}" cy="${startY + panelHeight / 2}" r="2" fill="#666"/>`;
        }

        svg += '</svg>';
        return svg;
    }

    function createOpeningSVG(type) {
        let svg = '<svg viewBox="0 0 80 100" class="pvc-icon">';
        svg += '<rect x="10" y="10" width="60" height="80" fill="#e8f4fc" stroke="#666" stroke-width="2"/>';

        switch (type) {
            case 'fixed':
                // No opening indicator
                svg += '<line x1="10" y1="10" x2="70" y2="90" stroke="#999" stroke-width="1" stroke-dasharray="5,5"/>';
                svg += '<line x1="70" y1="10" x2="10" y2="90" stroke="#999" stroke-width="1" stroke-dasharray="5,5"/>';
                break;
            case 'turn':
                // Arrow from hinge side
                svg += '<path d="M 65 50 L 25 30 L 25 70 Z" fill="none" stroke="#e53935" stroke-width="2"/>';
                break;
            case 'tilt':
                // Arrow from bottom
                svg += '<path d="M 40 85 L 20 55 L 60 55 Z" fill="none" stroke="#e53935" stroke-width="2"/>';
                break;
            case 'tilt-turn':
                // Both arrows
                svg += '<path d="M 65 50 L 35 35 L 35 65 Z" fill="none" stroke="#e53935" stroke-width="2"/>';
                svg += '<path d="M 40 85 L 25 65 L 55 65 Z" fill="none" stroke="#e53935" stroke-width="2"/>';
                break;
        }

        svg += '</svg>';
        return svg;
    }

    function createDoorOpeningSVG(direction) {
        let svg = '<svg viewBox="0 0 80 100" class="pvc-icon">';
        svg += '<rect x="15" y="10" width="50" height="80" fill="#ddd" stroke="#666" stroke-width="2"/>';

        // Door handle
        const handleX = direction.includes('right') ? 55 : 25;
        svg += `<circle cx="${handleX}" cy="50" r="3" fill="#666"/>`;

        // Opening direction arrow
        if (direction === 'right') {
            svg += '<path d="M 40 50 C 40 30, 65 30, 65 50" fill="none" stroke="#e53935" stroke-width="2" stroke-dasharray="3,3"/>';
            svg += '<polygon points="65,45 65,55 72,50" fill="#e53935"/>';
        } else if (direction === 'left') {
            svg += '<path d="M 40 50 C 40 30, 15 30, 15 50" fill="none" stroke="#e53935" stroke-width="2" stroke-dasharray="3,3"/>';
            svg += '<polygon points="15,45 15,55 8,50" fill="#e53935"/>';
        } else if (direction === 'right-out') {
            svg += '<path d="M 40 50 C 40 70, 65 70, 65 50" fill="none" stroke="#e53935" stroke-width="2" stroke-dasharray="3,3"/>';
            svg += '<polygon points="65,45 65,55 72,50" fill="#e53935"/>';
        } else if (direction === 'left-out') {
            svg += '<path d="M 40 50 C 40 70, 15 70, 15 50" fill="none" stroke="#e53935" stroke-width="2" stroke-dasharray="3,3"/>';
            svg += '<polygon points="15,45 15,55 8,50" fill="#e53935"/>';
        }

        svg += '</svg>';
        return svg;
    }

    function createSlidingSVG(direction) {
        let svg = '<svg viewBox="0 0 100 80" class="pvc-icon">';
        svg += '<rect x="5" y="5" width="90" height="70" fill="none" stroke="#666" stroke-width="2"/>';
        svg += '<rect x="8" y="8" width="42" height="64" fill="#e8f4fc" stroke="#999" stroke-width="1"/>';
        svg += '<rect x="50" y="8" width="42" height="64" fill="#d0e8f7" stroke="#999" stroke-width="1"/>';

        // Sliding arrow
        if (direction === 'right') {
            svg += '<path d="M 55 40 L 85 40" stroke="#e53935" stroke-width="3"/>';
            svg += '<polygon points="82,35 82,45 92,40" fill="#e53935"/>';
        } else {
            svg += '<path d="M 45 40 L 15 40" stroke="#e53935" stroke-width="3"/>';
            svg += '<polygon points="18,35 18,45 8,40" fill="#e53935"/>';
        }

        svg += '</svg>';
        return svg;
    }

    // Initialize on DOM Ready
    $(document).ready(init);

})(jQuery);
