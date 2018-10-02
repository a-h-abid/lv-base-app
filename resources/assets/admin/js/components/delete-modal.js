document.addEventListener('DOMContentLoaded', function(){
    // @todo transform this for Raw JS
    $('#deleteModal').on('show.bs.modal', function (e) {
        e.target.querySelector('form').action = e.relatedTarget.dataset.href;
    });
});