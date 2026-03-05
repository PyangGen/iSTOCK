<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('landing.welcome') }} | iSTOCK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/landing/landing.css') }}">
</head>
<body>

<div class="language-icon" id="openLanguageModal">
    🌐 <span id="currentLang">{{ strtoupper(app()->getLocale()) }}</span>
</div>
<div class="container-box">

    <!-- Image Grid -->
    <div class="image-marquee">

        <div class="marquee-row">
            <div class="marquee-track auto-scroll-left">
                @for($i = 3; $i <= 14; $i++)
                    <img src="https://picsum.photos/400?random={{ $i }}" alt="business">
                @endfor
                @for($i = 3; $i <= 14; $i++)
                    <img src="https://picsum.photos/400?random={{ $i }}" alt="business">
                @endfor
            </div>
        </div>

        <div class="marquee-row">
            <div class="marquee-track auto-scroll-right">
                @for($i = 15; $i <= 26; $i++)
                    <img src="https://picsum.photos/400?random={{ $i }}" alt="business">
                @endfor
                @for($i = 15; $i <= 26; $i++)
                    <img src="https://picsum.photos/400?random={{ $i }}" alt="business">
                @endfor
            </div>
        </div>

    </div>

    <!-- Headline -->
    <div class="headline">
       {!! nl2br(__('landing.headline')) !!}
    </div>

    <!-- Buttons -->
    <div class="btn-wrapper">
        <a href="{{ route('admin.create.signUp') }}" class="btn-custom btn-green">
          {{ __('landing.new_user') }}
        </a>

        <a href="{{ route('admin.login.signIn') }}" class="btn-custom btn-blue">
            {{ __('landing.existing_user') }}
        </a>
    </div>

    <!-- Security -->
    <div class="security">
        <span class="material-icons" style="vertical-align: middle; font-size: 18px; margin-right: 6px;">
            verified_user
        </span>
        {{ __('landing.security') }}
    </div>
</div>

<!-- Language Modal -->
<div id="languageModal" class="language-modal">
    <div class="language-modal-content">
        <span class="close-language">&times;</span>

       <h2>{{ __('landing.select_language') }}</h2>

        <div class="languages-wrapper">

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

@foreach($languages as $lang)
<a href="#"
   class="language-card"
   data-lang="{{ $lang['code'] }}"
   onclick="changeLanguage('{{ $lang['code'] }}'); return false;">
    {{ $lang['name'] }} ({{ strtoupper($lang['code']) }})
</a>
@endforeach

        </div>
    </div>
</div>

<script>
const modal = document.getElementById('languageModal');
const openBtn = document.getElementById('openLanguageModal');
const closeBtn = document.querySelector('.close-language');

openBtn.onclick = () => modal.style.display = 'block';
closeBtn.onclick = () => modal.style.display = 'none';

window.onclick = function(e) {
    if(e.target == modal){
        modal.style.display = 'none';
    }
}

// Google Translate initialization
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element');
}

// Remove the banner continuously in case Google reinserts it
setInterval(function() {
    const frame = document.querySelector('.goog-te-banner-frame');
    if(frame) frame.remove();
    document.body.style.top = "0px";
}, 300);

// Change language and close modal
function changeLanguage(lang) {

    modal.style.display = 'none';

    const select = document.querySelector(".goog-te-combo");

    if(select){
        select.value = lang;
        select.dispatchEvent(new Event("change"));
    }

    // Update icon text
    document.getElementById("currentLang").innerText = lang.toUpperCase();

    // Highlight selected language
    document.querySelectorAll(".language-card").forEach(card => {
        card.classList.remove("active");
        if(card.dataset.lang === lang){
            card.classList.add("active");
        }
    });

    // Save selection
    localStorage.setItem("selectedLang", lang);
}
// Apply saved language on page load
window.addEventListener("load", function(){

    const savedLang = localStorage.getItem("selectedLang");

    if(savedLang){

        document.getElementById("currentLang").innerText = savedLang.toUpperCase();

        document.querySelectorAll(".language-card").forEach(card => {
            if(card.dataset.lang === savedLang){
                card.classList.add("active");
            }
        });

        const interval = setInterval(function(){

            const select = document.querySelector(".goog-te-combo");

            if(select){
                select.value = savedLang;
                select.dispatchEvent(new Event("change"));
                clearInterval(interval);
            }

        },300);

    }

});
</script>

<div id="google_translate_element" style="display:none;"></div>

<script>
function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {
            pageLanguage: 'en',
            autoDisplay: false
        },
        'google_translate_element'
    );
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>