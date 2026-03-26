@extends('layouts.app')

@section('title', 'Tell us about your business')

@section('content')
@php
$languages = [
    ['name'=>'English','code'=>'en'],
    ['name'=>'Spanish','code'=>'es'],
    ['name'=>'French','code'=>'fr'],
    ['name'=>'German','code'=>'de'],
    ['name'=>'Chinese (Simplified)','code'=>'zh-CN'],
    ['name'=>'Chinese (Traditional)','code'=>'zh-TW'],
    ['name'=>'Japanese','code'=>'ja'],
    ['name'=>'Korean','code'=>'ko'],
    ['name'=>'Arabic','code'=>'ar'],
    ['name'=>'Hindi','code'=>'hi'],
    ['name'=>'Russian','code'=>'ru'],
    ['name'=>'Portuguese','code'=>'pt'],
    ['name'=>'Italian','code'=>'it'],
    ['name'=>'Dutch','code'=>'nl'],
    ['name'=>'Turkish','code'=>'tr'],
    ['name'=>'Vietnamese','code'=>'vi'],
    ['name'=>'Thai','code'=>'th'],
    ['name'=>'Indonesian','code'=>'id'],
    ['name'=>'Malay','code'=>'ms'],
    ['name'=>'Filipino / Tagalog','code'=>'tl'],
    ['name'=>'Polish','code'=>'pl'],
    ['name'=>'Ukrainian','code'=>'uk'],
    ['name'=>'Greek','code'=>'el'],
    ['name'=>'Czech','code'=>'cs'],
    ['name'=>'Romanian','code'=>'ro'],
    ['name'=>'Hungarian','code'=>'hu'],
    ['name'=>'Swedish','code'=>'sv'],
    ['name'=>'Danish','code'=>'da'],
    ['name'=>'Finnish','code'=>'fi'],
    ['name'=>'Norwegian','code'=>'no'],
];
@endphp

<link rel="stylesheet" href="{{ asset('assets/css/admin/login/info.css') }}">

<div class="business-page">
    <div class="business-shell">
        <div class="business-card reveal">

            <div class="business-header">
                <h1>Tell us about your business</h1>
            </div>

            <div class="business-body">
                <div class="invite-banner">
                    Accept Invite and Join as Staff, Partner, or Manager
                </div>

               <form class="business-form" id="businessInfoForm" method="POST" action="{{ route('admin.login.info.store') }}">
    @csrf
                    <div class="field-card guide-business-type-dim-target" id="businessTypeField">
                        <label class="field-label">Please Select Business Type</label>

                       <div class="chip-group" id="businessTypeGroup">
    <button type="button" class="type-chip" data-value="Small Retail Store">Small Retail Store</button>
    <button type="button" class="type-chip" data-value="Grocery / Mini Mart">Grocery / Mini Mart</button>
    <button type="button" class="type-chip" data-value="Restaurant / Café">Restaurant / Café</button>
    <button type="button" class="type-chip" data-value="Pharmacy">Pharmacy</button>
    <button type="button" class="type-chip" data-value="Hardware Store">Hardware Store</button>
    <button type="button" class="type-chip" data-value="Office Supply Store">Office Supply Store</button>
    <button type="button" class="type-chip" data-value="Warehouse / Stockroom">Warehouse / Stockroom</button>
    <button type="button" class="type-chip other-chip" id="otherBusinessTypeBtn" data-value="Other">Other</button>
</div>

<input type="hidden" name="business_type" id="businessTypeInput">
<p class="custom-business-preview" id="customBusinessPreview"></p>
                    </div>

                   <div class="field-card">
    <label class="field-label" for="businessName">Business Name</label>
    <div class="input-row">
        <span class="field-icon" id="businessNameCheckIcon">✓</span>
        <input
            type="text"
            id="businessName"
            name="business_name"
            class="text-input"
            placeholder="Enter business name"
        >
    </div>
</div>
<div class="two-col">
    <div class="field-card phone-code-card country-picker-trigger" id="countryPickerTrigger">
        
        <label class="field-label" for="phoneCode">Phone iST Code</label>
        <div class="input-row no-gap">
            <span class="phone-code-value" id="phoneCode">+63</span>
        </div>
        <input type="hidden" id="phoneIstCodeInput" name="phone_ist_code" value="+63">
    </div>

    <div class="field-card">
        <label class="field-label" for="mobileNo">Mobile Number</label>
        <div class="input-row">
            <input
    type="text"
    id="mobileNo"
    name="mobile_no"
    class="text-input"
    placeholder="Enter mobile no"
    inputmode="numeric"
    autocomplete="tel-national"
>
        </div>
    </div>
</div>

<div class="field-card">
    <label class="field-label" for="countryDisplay">Select Country</label>
    <div class="input-row select-wrap">
        <span class="field-icon" id="countryCheckIcon">✓</span>
        <input
            type="text"
            id="countryDisplay"
            name="country_name"
            class="text-input"
            placeholder="Selected country will appear here"
            readonly
        >
    </div>
    <input type="hidden" id="countryCodeValue" name="country_code">
</div>
                    <button type="submit" class="continue-btn">CONTINUE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="businessTypeGuideOverlay" class="business-type-guide-overlay">
    <div id="businessTypeGuideSpotlight" class="business-type-guide-spotlight"></div>

    <div id="businessTypeGuideCard" class="business-type-guide-card">
        <div class="business-type-guide-arrow"></div>
        <h3 id="businessTypeGuideTitle">Select your business type</h3>
        <p id="businessTypeGuideText">Choose the category that best matches your store so iSTOCK can set up your business profile correctly.</p>
        <button type="button" id="businessTypeGuideBtn" class="business-type-guide-btn">Got it</button>
    </div>
</div>
<div id="businessTypeModal" class="business-type-modal-overlay">
    <div class="business-type-modal">
        <div class="business-type-modal-head">
            <h3>Custom Business Type</h3>
            <button type="button" class="business-type-modal-close" id="closeBusinessTypeModal">×</button>
        </div>

        <div class="business-type-modal-body">
            <label for="customBusinessTypeInput" class="business-type-modal-label">Business Type</label>
            <input
                type="text"
                id="customBusinessTypeInput"
                class="business-type-modal-input"
                placeholder="Type your business type"
            >
        </div>

        <div class="business-type-modal-actions">
            <button type="button" class="business-type-modal-btn soft" id="cancelBusinessTypeModal">Cancel</button>
            <button type="button" class="business-type-modal-btn primary" id="saveBusinessTypeModal">Save</button>
        </div>
    </div>
</div>

<div id="countryModal" class="country-modal-overlay">
    <div class="country-modal">
        <div class="country-modal-head">
            <h3>Select Country</h3>
            <button type="button" class="country-modal-close" id="closeCountryModal">×</button>
        </div>

        <div class="country-modal-body">
            <input
                type="text"
                id="countrySearchInput"
                class="country-search-input"
                placeholder="Search country"
            >

            <div class="country-list" id="countryList">
                <!-- injected by JS -->
            </div>
        </div>
    </div>
</div>

<script>
function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}
function onlyDigits(value) {
    return value.replace(/\D/g, '');
}

function getPhoneFormatConfig(countryCode) {
    const formats = {
        PH: { max: 10, placeholder: '912 345 6789', pattern: [3, 3, 4] },
        US: { max: 10, placeholder: '201 555 0123', pattern: [3, 3, 4] },
        CA: { max: 10, placeholder: '204 234 5678', pattern: [3, 3, 4] },
        GB: { max: 10, placeholder: '7123 456 789', pattern: [4, 3, 3] },
        AU: { max: 9, placeholder: '412 345 678', pattern: [3, 3, 3] },
        NZ: { max: 9, placeholder: '211 234 567', pattern: [3, 3, 3] },
        IN: { max: 10, placeholder: '91234 56789', pattern: [5, 5] },
        JP: { max: 10, placeholder: '90 1234 5678', pattern: [2, 4, 4] },
        KR: { max: 10, placeholder: '10 1234 5678', pattern: [2, 4, 4] },
        CN: { max: 11, placeholder: '131 2345 6789', pattern: [3, 4, 4] },
        TW: { max: 9, placeholder: '912 345 678', pattern: [3, 3, 3] },
        SG: { max: 8, placeholder: '8123 4567', pattern: [4, 4] },
        MY: { max: 10, placeholder: '12 345 6789', pattern: [2, 3, 4] },
        ID: { max: 10, placeholder: '812 3456 7890', pattern: [3, 4, 3] },
        TH: { max: 9, placeholder: '81 234 5678', pattern: [2, 3, 4] },
        VN: { max: 9, placeholder: '912 345 678', pattern: [3, 3, 3] },
        AE: { max: 9, placeholder: '50 123 4567', pattern: [2, 3, 4] },
        SA: { max: 9, placeholder: '50 123 4567', pattern: [2, 3, 4] },
        QA: { max: 8, placeholder: '3312 3456', pattern: [4, 4] },
        KW: { max: 8, placeholder: '5123 4567', pattern: [4, 4] },
        BH: { max: 8, placeholder: '3600 1234', pattern: [4, 4] },
        OM: { max: 8, placeholder: '9212 3456', pattern: [4, 4] },
        DE: { max: 11, placeholder: '1512 3456789', pattern: [4, 7] },
        FR: { max: 9, placeholder: '6 12 34 56 78', pattern: [1, 2, 2, 2, 2] },
        ES: { max: 9, placeholder: '612 34 56 78', pattern: [3, 2, 2, 2] },
        IT: { max: 10, placeholder: '312 345 6789', pattern: [3, 3, 4] },
        PT: { max: 9, placeholder: '912 345 678', pattern: [3, 3, 3] },
        NL: { max: 9, placeholder: '6 12345678', pattern: [1, 8] },
        BE: { max: 9, placeholder: '470 12 34 56', pattern: [3, 2, 2, 2] },
        CH: { max: 9, placeholder: '79 123 45 67', pattern: [2, 3, 2, 2] },
        AT: { max: 10, placeholder: '664 1234567', pattern: [3, 7] },
        SE: { max: 9, placeholder: '70 123 45 67', pattern: [2, 3, 2, 2] },
        NO: { max: 8, placeholder: '412 34 567', pattern: [3, 2, 3] },
        DK: { max: 8, placeholder: '20 12 34 56', pattern: [2, 2, 2, 2] },
        FI: { max: 9, placeholder: '40 123 4567', pattern: [2, 3, 4] },
        IE: { max: 9, placeholder: '83 123 4567', pattern: [2, 3, 4] },
        PL: { max: 9, placeholder: '512 345 678', pattern: [3, 3, 3] },
        CZ: { max: 9, placeholder: '601 123 456', pattern: [3, 3, 3] },
        SK: { max: 9, placeholder: '901 123 456', pattern: [3, 3, 3] },
        HU: { max: 9, placeholder: '20 123 4567', pattern: [2, 3, 4] },
        RO: { max: 9, placeholder: '712 345 678', pattern: [3, 3, 3] },
        GR: { max: 10, placeholder: '691 234 5678', pattern: [3, 3, 4] },
        TR: { max: 10, placeholder: '532 123 4567', pattern: [3, 3, 4] },
        RU: { max: 10, placeholder: '912 345 67 89', pattern: [3, 3, 2, 2] },
        UA: { max: 9, placeholder: '50 123 45 67', pattern: [2, 3, 2, 2] },
        BR: { max: 11, placeholder: '11 91234 5678', pattern: [2, 5, 4] },
        MX: { max: 10, placeholder: '222 123 4567', pattern: [3, 3, 4] },
        AR: { max: 10, placeholder: '11 2345 6789', pattern: [2, 4, 4] },
        CL: { max: 9, placeholder: '9 1234 5678', pattern: [1, 4, 4] },
        CO: { max: 10, placeholder: '312 345 6789', pattern: [3, 3, 4] },
        PE: { max: 9, placeholder: '912 345 678', pattern: [3, 3, 3] },
        ZA: { max: 9, placeholder: '82 123 4567', pattern: [2, 3, 4] },
        NG: { max: 10, placeholder: '802 123 4567', pattern: [3, 3, 4] },
        EG: { max: 10, placeholder: '100 123 4567', pattern: [3, 3, 4] }
    };

    return formats[countryCode] || { max: 12, placeholder: '123 456 7890', pattern: [3, 3, 4, 2] };
}

function applyPattern(digits, pattern) {
    const parts = [];
    let index = 0;

    for (const size of pattern) {
        if (index >= digits.length) break;
        parts.push(digits.slice(index, index + size));
        index += size;
    }

    if (index < digits.length) {
        parts.push(digits.slice(index));
    }

    return parts.join(' ');
}

function formatPhoneForCountry(rawValue, countryCode) {
    const config = getPhoneFormatConfig(countryCode);
    const digits = onlyDigits(rawValue).slice(0, config.max);
    return applyPattern(digits, config.pattern);
}

document.addEventListener('DOMContentLoaded', function () {
    const typeButtons = document.querySelectorAll('.type-chip');
    const typeInput = document.getElementById('businessTypeInput');

    const businessNameInput = document.getElementById('businessName');
    const businessNameCheckIcon = document.getElementById('businessNameCheckIcon');
const mobileNoInput = document.getElementById('mobileNo');
    const phoneCode = document.getElementById('phoneCode');
const countryPickerTrigger = document.getElementById('countryPickerTrigger');
const phoneCodeCard = countryPickerTrigger;
    const countryDisplay = document.getElementById('countryDisplay');
    const countryCodeValue = document.getElementById('countryCodeValue');
    const countryCheckIcon = document.getElementById('countryCheckIcon');

    const countryModal = document.getElementById('countryModal');
    const closeCountryModal = document.getElementById('closeCountryModal');
    const countrySearchInput = document.getElementById('countrySearchInput');
    const countryList = document.getElementById('countryList');
    const phoneIstCodeInput = document.getElementById('phoneIstCodeInput');

    const otherBusinessTypeBtn = document.getElementById('otherBusinessTypeBtn');
    const businessTypeModal = document.getElementById('businessTypeModal');
    const closeBusinessTypeModal = document.getElementById('closeBusinessTypeModal');
    const cancelBusinessTypeModal = document.getElementById('cancelBusinessTypeModal');
    const saveBusinessTypeModal = document.getElementById('saveBusinessTypeModal');
    const customBusinessTypeInput = document.getElementById('customBusinessTypeInput');
    const customBusinessPreview = document.getElementById('customBusinessPreview');

    const countries = [
    { name: 'Afghanistan', code: 'AF', dial: '+93' },
    { name: 'Albania', code: 'AL', dial: '+355' },
    { name: 'Algeria', code: 'DZ', dial: '+213' },
    { name: 'Andorra', code: 'AD', dial: '+376' },
    { name: 'Angola', code: 'AO', dial: '+244' },
    { name: 'Antigua and Barbuda', code: 'AG', dial: '+1-268' },
    { name: 'Argentina', code: 'AR', dial: '+54' },
    { name: 'Armenia', code: 'AM', dial: '+374' },
    { name: 'Australia', code: 'AU', dial: '+61' },
    { name: 'Austria', code: 'AT', dial: '+43' },
    { name: 'Azerbaijan', code: 'AZ', dial: '+994' },
    { name: 'Bahamas', code: 'BS', dial: '+1-242' },
    { name: 'Bahrain', code: 'BH', dial: '+973' },
    { name: 'Bangladesh', code: 'BD', dial: '+880' },
    { name: 'Barbados', code: 'BB', dial: '+1-246' },
    { name: 'Belarus', code: 'BY', dial: '+375' },
    { name: 'Belgium', code: 'BE', dial: '+32' },
    { name: 'Belize', code: 'BZ', dial: '+501' },
    { name: 'Benin', code: 'BJ', dial: '+229' },
    { name: 'Bhutan', code: 'BT', dial: '+975' },
    { name: 'Bolivia', code: 'BO', dial: '+591' },
    { name: 'Bosnia and Herzegovina', code: 'BA', dial: '+387' },
    { name: 'Botswana', code: 'BW', dial: '+267' },
    { name: 'Brazil', code: 'BR', dial: '+55' },
    { name: 'Brunei', code: 'BN', dial: '+673' },
    { name: 'Bulgaria', code: 'BG', dial: '+359' },
    { name: 'Burkina Faso', code: 'BF', dial: '+226' },
    { name: 'Burundi', code: 'BI', dial: '+257' },
    { name: 'Cabo Verde', code: 'CV', dial: '+238' },
    { name: 'Cambodia', code: 'KH', dial: '+855' },
    { name: 'Cameroon', code: 'CM', dial: '+237' },
    { name: 'Canada', code: 'CA', dial: '+1' },
    { name: 'Central African Republic', code: 'CF', dial: '+236' },
    { name: 'Chad', code: 'TD', dial: '+235' },
    { name: 'Chile', code: 'CL', dial: '+56' },
    { name: 'China', code: 'CN', dial: '+86' },
    { name: 'Colombia', code: 'CO', dial: '+57' },
    { name: 'Comoros', code: 'KM', dial: '+269' },
    { name: 'Congo', code: 'CG', dial: '+242' },
    { name: 'Costa Rica', code: 'CR', dial: '+506' },
    { name: 'Croatia', code: 'HR', dial: '+385' },
    { name: 'Cuba', code: 'CU', dial: '+53' },
    { name: 'Cyprus', code: 'CY', dial: '+357' },
    { name: 'Czech Republic', code: 'CZ', dial: '+420' },
    { name: 'Democratic Republic of the Congo', code: 'CD', dial: '+243' },
    { name: 'Denmark', code: 'DK', dial: '+45' },
    { name: 'Djibouti', code: 'DJ', dial: '+253' },
    { name: 'Dominica', code: 'DM', dial: '+1-767' },
    { name: 'Dominican Republic', code: 'DO', dial: '+1-809' },
    { name: 'Ecuador', code: 'EC', dial: '+593' },
    { name: 'Egypt', code: 'EG', dial: '+20' },
    { name: 'El Salvador', code: 'SV', dial: '+503' },
    { name: 'Equatorial Guinea', code: 'GQ', dial: '+240' },
    { name: 'Eritrea', code: 'ER', dial: '+291' },
    { name: 'Estonia', code: 'EE', dial: '+372' },
    { name: 'Eswatini', code: 'SZ', dial: '+268' },
    { name: 'Ethiopia', code: 'ET', dial: '+251' },
    { name: 'Fiji', code: 'FJ', dial: '+679' },
    { name: 'Finland', code: 'FI', dial: '+358' },
    { name: 'France', code: 'FR', dial: '+33' },
    { name: 'Gabon', code: 'GA', dial: '+241' },
    { name: 'Gambia', code: 'GM', dial: '+220' },
    { name: 'Georgia', code: 'GE', dial: '+995' },
    { name: 'Germany', code: 'DE', dial: '+49' },
    { name: 'Ghana', code: 'GH', dial: '+233' },
    { name: 'Greece', code: 'GR', dial: '+30' },
    { name: 'Grenada', code: 'GD', dial: '+1-473' },
    { name: 'Guatemala', code: 'GT', dial: '+502' },
    { name: 'Guinea', code: 'GN', dial: '+224' },
    { name: 'Guinea-Bissau', code: 'GW', dial: '+245' },
    { name: 'Guyana', code: 'GY', dial: '+592' },
    { name: 'Haiti', code: 'HT', dial: '+509' },
    { name: 'Honduras', code: 'HN', dial: '+504' },
    { name: 'Hungary', code: 'HU', dial: '+36' },
    { name: 'Iceland', code: 'IS', dial: '+354' },
    { name: 'India', code: 'IN', dial: '+91' },
    { name: 'Indonesia', code: 'ID', dial: '+62' },
    { name: 'Iran', code: 'IR', dial: '+98' },
    { name: 'Iraq', code: 'IQ', dial: '+964' },
    { name: 'Ireland', code: 'IE', dial: '+353' },
    { name: 'Israel', code: 'IL', dial: '+972' },
    { name: 'Italy', code: 'IT', dial: '+39' },
    { name: 'Jamaica', code: 'JM', dial: '+1-876' },
    { name: 'Japan', code: 'JP', dial: '+81' },
    { name: 'Jordan', code: 'JO', dial: '+962' },
    { name: 'Kazakhstan', code: 'KZ', dial: '+7' },
    { name: 'Kenya', code: 'KE', dial: '+254' },
    { name: 'Kiribati', code: 'KI', dial: '+686' },
    { name: 'Kuwait', code: 'KW', dial: '+965' },
    { name: 'Kyrgyzstan', code: 'KG', dial: '+996' },
    { name: 'Laos', code: 'LA', dial: '+856' },
    { name: 'Latvia', code: 'LV', dial: '+371' },
    { name: 'Lebanon', code: 'LB', dial: '+961' },
    { name: 'Lesotho', code: 'LS', dial: '+266' },
    { name: 'Liberia', code: 'LR', dial: '+231' },
    { name: 'Libya', code: 'LY', dial: '+218' },
    { name: 'Liechtenstein', code: 'LI', dial: '+423' },
    { name: 'Lithuania', code: 'LT', dial: '+370' },
    { name: 'Luxembourg', code: 'LU', dial: '+352' },
    { name: 'Madagascar', code: 'MG', dial: '+261' },
    { name: 'Malawi', code: 'MW', dial: '+265' },
    { name: 'Malaysia', code: 'MY', dial: '+60' },
    { name: 'Maldives', code: 'MV', dial: '+960' },
    { name: 'Mali', code: 'ML', dial: '+223' },
    { name: 'Malta', code: 'MT', dial: '+356' },
    { name: 'Marshall Islands', code: 'MH', dial: '+692' },
    { name: 'Mauritania', code: 'MR', dial: '+222' },
    { name: 'Mauritius', code: 'MU', dial: '+230' },
    { name: 'Mexico', code: 'MX', dial: '+52' },
    { name: 'Micronesia', code: 'FM', dial: '+691' },
    { name: 'Moldova', code: 'MD', dial: '+373' },
    { name: 'Monaco', code: 'MC', dial: '+377' },
    { name: 'Mongolia', code: 'MN', dial: '+976' },
    { name: 'Montenegro', code: 'ME', dial: '+382' },
    { name: 'Morocco', code: 'MA', dial: '+212' },
    { name: 'Mozambique', code: 'MZ', dial: '+258' },
    { name: 'Myanmar', code: 'MM', dial: '+95' },
    { name: 'Namibia', code: 'NA', dial: '+264' },
    { name: 'Nauru', code: 'NR', dial: '+674' },
    { name: 'Nepal', code: 'NP', dial: '+977' },
    { name: 'Netherlands', code: 'NL', dial: '+31' },
    { name: 'New Zealand', code: 'NZ', dial: '+64' },
    { name: 'Nicaragua', code: 'NI', dial: '+505' },
    { name: 'Niger', code: 'NE', dial: '+227' },
    { name: 'Nigeria', code: 'NG', dial: '+234' },
    { name: 'North Korea', code: 'KP', dial: '+850' },
    { name: 'North Macedonia', code: 'MK', dial: '+389' },
    { name: 'Norway', code: 'NO', dial: '+47' },
    { name: 'Oman', code: 'OM', dial: '+968' },
    { name: 'Pakistan', code: 'PK', dial: '+92' },
    { name: 'Palau', code: 'PW', dial: '+680' },
    { name: 'Palestine', code: 'PS', dial: '+970' },
    { name: 'Panama', code: 'PA', dial: '+507' },
    { name: 'Papua New Guinea', code: 'PG', dial: '+675' },
    { name: 'Paraguay', code: 'PY', dial: '+595' },
    { name: 'Peru', code: 'PE', dial: '+51' },
    { name: 'Philippines', code: 'PH', dial: '+63' },
    { name: 'Poland', code: 'PL', dial: '+48' },
    { name: 'Portugal', code: 'PT', dial: '+351' },
    { name: 'Qatar', code: 'QA', dial: '+974' },
    { name: 'Romania', code: 'RO', dial: '+40' },
    { name: 'Russia', code: 'RU', dial: '+7' },
    { name: 'Rwanda', code: 'RW', dial: '+250' },
    { name: 'Saint Kitts and Nevis', code: 'KN', dial: '+1-869' },
    { name: 'Saint Lucia', code: 'LC', dial: '+1-758' },
    { name: 'Saint Vincent and the Grenadines', code: 'VC', dial: '+1-784' },
    { name: 'Samoa', code: 'WS', dial: '+685' },
    { name: 'San Marino', code: 'SM', dial: '+378' },
    { name: 'Sao Tome and Principe', code: 'ST', dial: '+239' },
    { name: 'Saudi Arabia', code: 'SA', dial: '+966' },
    { name: 'Senegal', code: 'SN', dial: '+221' },
    { name: 'Serbia', code: 'RS', dial: '+381' },
    { name: 'Seychelles', code: 'SC', dial: '+248' },
    { name: 'Sierra Leone', code: 'SL', dial: '+232' },
    { name: 'Singapore', code: 'SG', dial: '+65' },
    { name: 'Slovakia', code: 'SK', dial: '+421' },
    { name: 'Slovenia', code: 'SI', dial: '+386' },
    { name: 'Solomon Islands', code: 'SB', dial: '+677' },
    { name: 'Somalia', code: 'SO', dial: '+252' },
    { name: 'South Africa', code: 'ZA', dial: '+27' },
    { name: 'South Korea', code: 'KR', dial: '+82' },
    { name: 'South Sudan', code: 'SS', dial: '+211' },
    { name: 'Spain', code: 'ES', dial: '+34' },
    { name: 'Sri Lanka', code: 'LK', dial: '+94' },
    { name: 'Sudan', code: 'SD', dial: '+249' },
    { name: 'Suriname', code: 'SR', dial: '+597' },
    { name: 'Sweden', code: 'SE', dial: '+46' },
    { name: 'Switzerland', code: 'CH', dial: '+41' },
    { name: 'Syria', code: 'SY', dial: '+963' },
    { name: 'Taiwan', code: 'TW', dial: '+886' },
    { name: 'Tajikistan', code: 'TJ', dial: '+992' },
    { name: 'Tanzania', code: 'TZ', dial: '+255' },
    { name: 'Thailand', code: 'TH', dial: '+66' },
    { name: 'Timor-Leste', code: 'TL', dial: '+670' },
    { name: 'Togo', code: 'TG', dial: '+228' },
    { name: 'Tonga', code: 'TO', dial: '+676' },
    { name: 'Trinidad and Tobago', code: 'TT', dial: '+1-868' },
    { name: 'Tunisia', code: 'TN', dial: '+216' },
    { name: 'Turkey', code: 'TR', dial: '+90' },
    { name: 'Turkmenistan', code: 'TM', dial: '+993' },
    { name: 'Tuvalu', code: 'TV', dial: '+688' },
    { name: 'Uganda', code: 'UG', dial: '+256' },
    { name: 'Ukraine', code: 'UA', dial: '+380' },
    { name: 'United Arab Emirates', code: 'AE', dial: '+971' },
    { name: 'United Kingdom', code: 'GB', dial: '+44' },
    { name: 'United States', code: 'US', dial: '+1' },
    { name: 'Uruguay', code: 'UY', dial: '+598' },
    { name: 'Uzbekistan', code: 'UZ', dial: '+998' },
    { name: 'Vanuatu', code: 'VU', dial: '+678' },
    { name: 'Vatican City', code: 'VA', dial: '+379' },
    { name: 'Venezuela', code: 'VE', dial: '+58' },
    { name: 'Vietnam', code: 'VN', dial: '+84' },
    { name: 'Yemen', code: 'YE', dial: '+967' },
    { name: 'Zambia', code: 'ZM', dial: '+260' },
    { name: 'Zimbabwe', code: 'ZW', dial: '+263' },

    /* useful extra territories */
    { name: 'Hong Kong', code: 'HK', dial: '+852' },
    { name: 'Macau', code: 'MO', dial: '+853' },
    { name: 'Puerto Rico', code: 'PR', dial: '+1-787' },
    { name: 'Guam', code: 'GU', dial: '+1-671' },
    { name: 'Bermuda', code: 'BM', dial: '+1-441' },
    { name: 'Cayman Islands', code: 'KY', dial: '+1-345' },
    { name: 'Aruba', code: 'AW', dial: '+297' },
    { name: 'Greenland', code: 'GL', dial: '+299' }
];
selectCountry({
    name: 'Philippines',
    code: 'PH',
    dial: '+63'
});
function updateMobileFormatUI(countryCode) {
    const config = getPhoneFormatConfig(countryCode);
    const spaces = Math.max(0, config.pattern.length - 1);

    mobileNoInput.placeholder = config.placeholder;
    mobileNoInput.setAttribute('maxlength', config.max + spaces);
}
    function updateBusinessNameCheck() {
        const hasValue = businessNameInput.value.trim().length > 0;
        businessNameCheckIcon.classList.toggle('is-valid', hasValue);
    }

    function clearChipSelection() {
        typeButtons.forEach(item => item.classList.remove('active'));
    }

    function openBusinessTypeModal() {
        businessTypeModal.classList.add('show');
        document.body.classList.add('business-type-modal-open');
        setTimeout(() => customBusinessTypeInput.focus(), 50);
    }

    function closeBusinessTypeModalFn() {
        businessTypeModal.classList.remove('show');
        document.body.classList.remove('business-type-modal-open');
    }

    function saveCustomBusinessType() {
        const customValue = customBusinessTypeInput.value.trim();
        if (!customValue) return;

        clearChipSelection();
        otherBusinessTypeBtn.classList.add('active');
        otherBusinessTypeBtn.textContent = customValue;

        typeInput.value = customValue;
        customBusinessPreview.textContent = 'Selected: ' + customValue;

        closeBusinessTypeModalFn();
    }

   function openCountryModal() {
    countrySearchInput.value = '';
    countryModal.classList.add('show');
    document.body.classList.add('country-modal-open');
    renderCountryList('');
    setTimeout(() => countrySearchInput.focus(), 60);
}
    function closeCountryModalFn() {
        countryModal.classList.remove('show');
        document.body.classList.remove('country-modal-open');
    }

    function selectCountry(country) {
    countryDisplay.value = country.name;
    countryCodeValue.value = country.code;
    phoneCode.textContent = country.dial;
    phoneIstCodeInput.value = country.dial;
    countryCheckIcon.classList.add('is-valid');
    phoneCodeCard.classList.add('has-country');

    updateMobileFormatUI(country.code);
    mobileNoInput.value = formatPhoneForCountry(mobileNoInput.value, country.code);

    closeCountryModalFn();
}
mobileNoInput.addEventListener('input', function () {
    const selectedCountryCode = countryCodeValue.value || 'PH';
    this.value = formatPhoneForCountry(this.value, selectedCountryCode);
});
    function renderCountryList(search = '') {
        const keyword = search.toLowerCase();

        const filtered = countries.filter(country =>
            country.name.toLowerCase().includes(keyword) ||
            country.code.toLowerCase().includes(keyword) ||
            country.dial.toLowerCase().includes(keyword)
        );

        if (!filtered.length) {
            countryList.innerHTML = `<div class="country-empty">No country found</div>`;
            return;
        }

        countryList.innerHTML = filtered.map(country => `
            <button
                type="button"
                class="country-item"
                data-name="${country.name}"
                data-code="${country.code}"
                data-dial="${country.dial}"
            >
                <span>${country.name}</span>
                <strong>${country.dial}</strong>
            </button>
        `).join('');

        countryList.querySelectorAll('.country-item').forEach(item => {
            item.addEventListener('click', function () {
                selectCountry({
                    name: this.dataset.name,
                    code: this.dataset.code,
                    dial: this.dataset.dial
                });
            });
        });
    }

    updateBusinessNameCheck();
    businessNameInput.addEventListener('input', updateBusinessNameCheck);

    typeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.id === 'otherBusinessTypeBtn') {
                openBusinessTypeModal();
                return;
            }

            clearChipSelection();
            this.classList.add('active');
            typeInput.value = this.dataset.value;
            customBusinessPreview.textContent = '';
        });
    });

    closeBusinessTypeModal.addEventListener('click', closeBusinessTypeModalFn);
    cancelBusinessTypeModal.addEventListener('click', closeBusinessTypeModalFn);
    saveBusinessTypeModal.addEventListener('click', saveCustomBusinessType);

    customBusinessTypeInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            saveCustomBusinessType();
        }
    });

    businessTypeModal.addEventListener('click', function (e) {
        if (e.target === businessTypeModal) {
            closeBusinessTypeModalFn();
        }
    });

    countryPickerTrigger.addEventListener('click', openCountryModal);
    closeCountryModal.addEventListener('click', closeCountryModalFn);

    countryModal.addEventListener('click', function (e) {
        if (e.target === countryModal) {
            closeCountryModalFn();
        }
    });

    countrySearchInput.addEventListener('input', function () {
        renderCountryList(this.value);
    });

    renderCountryList('');

    if (shouldShowGuideOnce('businessTypeGuideSeen')) {
        initBusinessTypeGuide({
            target: '#businessTypeField',
            dim: '.field-card:not(#businessTypeField), .continue-btn, .invite-banner',
            title: 'Select your business type',
            text: 'Choose the category that best matches your store so iSTOCK can set up your business profile correctly.'
        });
    }
    
});

function initBusinessTypeGuide(config) {
    const overlay = document.getElementById('businessTypeGuideOverlay');
    const spotlight = document.getElementById('businessTypeGuideSpotlight');
    const guideCard = document.getElementById('businessTypeGuideCard');
    const guideBtn = document.getElementById('businessTypeGuideBtn');
    const guideTitle = document.getElementById('businessTypeGuideTitle');
    const guideText = document.getElementById('businessTypeGuideText');
    const target = document.querySelector(config.target);

    if (!overlay || !spotlight || !guideCard || !guideBtn || !guideTitle || !guideText || !target) return;

    const dimTargets = document.querySelectorAll(config.dim || '');
    let rafId = null;

    guideTitle.textContent = config.title || '';
    guideText.textContent = config.text || '';

    function positionGuide() {
        const rect = target.getBoundingClientRect();
        const isMobile = window.innerWidth <= 640;
        const cardWidth = Math.min(300, window.innerWidth - 32);

        spotlight.style.top = rect.top + 'px';
        spotlight.style.left = rect.left + 'px';
        spotlight.style.width = rect.width + 'px';
        spotlight.style.height = rect.height + 'px';
        spotlight.style.borderRadius = getComputedStyle(target).borderRadius;

        guideCard.style.width = cardWidth + 'px';

        let left = Math.max(16, Math.min(rect.left, window.innerWidth - cardWidth - 16));
        let top;

        guideCard.style.left = left + 'px';

        if (isMobile) {
            top = rect.bottom + 16;
            guideCard.classList.remove('business-type-guide-card-above', 'business-type-guide-card-side');
            guideCard.classList.add('business-type-guide-card-below');
        } else {
            top = rect.top + 18;
            left = rect.right + 20;
            if (left + cardWidth > window.innerWidth - 16) {
                left = Math.max(16, rect.left - cardWidth - 20);
            }
            guideCard.style.left = left + 'px';
            guideCard.classList.remove('business-type-guide-card-above', 'business-type-guide-card-below');
            guideCard.classList.add('business-type-guide-card-side');
        }

        guideCard.style.top = top + 'px';
    }

    function schedulePosition() {
        if (rafId) cancelAnimationFrame(rafId);
        rafId = requestAnimationFrame(() => {
            positionGuide();
            rafId = null;
        });
    }

    function stabilizeGuide() {
        let count = 0;
        function loop() {
            positionGuide();
            count++;
            if (count < 24) requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);
        setTimeout(positionGuide, 100);
        setTimeout(positionGuide, 220);
        setTimeout(positionGuide, 400);
        setTimeout(positionGuide, 700);
    }

    function showGuide() {
        document.body.classList.add('business-type-guide-open');

        dimTargets.forEach(el => el.classList.add('business-type-guide-dim'));

        target.classList.add('business-type-guide-target');
        overlay.classList.add('show');

        guideCard.style.visibility = 'hidden';
        guideCard.style.top = '-9999px';
        guideCard.style.left = '-9999px';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                guideCard.style.visibility = 'visible';
                stabilizeGuide();
            });
        });
    }

    function hideGuide() {
        overlay.classList.remove('show');
        document.body.classList.remove('business-type-guide-open');

        dimTargets.forEach(el => el.classList.remove('business-type-guide-dim'));
        target.classList.remove('business-type-guide-target');
    }

    guideBtn.addEventListener('click', hideGuide);

    window.addEventListener('resize', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    });

    window.addEventListener('scroll', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    }, { passive: true });

    const startGuide = () => setTimeout(showGuide, 320);

    if (document.readyState === 'complete') {
        startGuide();
    } else {
        window.addEventListener('load', startGuide, { once: true });
    }
}
</script>

@endsection