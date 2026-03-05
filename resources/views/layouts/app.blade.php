<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
@stack('styles')
</head>

<body>

@yield('content')


<!-- GOOGLE TRANSLATE GLOBAL -->
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

function changeLanguage(lang) {
    const select = document.querySelector(".goog-te-combo");

    if(select){
        select.value = lang;
        select.dispatchEvent(new Event("change"));
    }

    localStorage.setItem("selectedLang", lang);
}

window.addEventListener("load", function(){
    const savedLang = localStorage.getItem("selectedLang");

    if(savedLang){
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

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

@stack('scripts')

</body>
</html>