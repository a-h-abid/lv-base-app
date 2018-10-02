
document.addEventListener('DOMContentLoaded', function(){
    // @todo transform this for Raw JS
    $.fn.select2.defaults.set("width", "100%");
    $.fn.select2.defaults.set("theme", "bootstrap4");

    $('.js-select2').select2();
});