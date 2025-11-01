// public/js/form-inspeksi-stavolt.js
document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('data-container');
    if(!container) return;
    var items = JSON.parse(container.dataset.items || '[]');

    items.forEach(function(key){
        var radios = document.getElementsByName(key);
        var textarea = document.querySelector('textarea[name="tindakan_' + key + '"]');
        if(!radios.length || !textarea) return;

        function toggle() {
            var checked = Array.prototype.slice.call(radios).find(function(r){ return r.checked; });
            if(checked && checked.value === 'Tidak') {
                textarea.removeAttribute('disabled');
            } else {
                textarea.value = textarea.value || '';
                textarea.setAttribute('disabled', 'disabled');
            }
        }

        radios.forEach(function(r){
            r.addEventListener('change', toggle);
        });

        toggle(); // initial
    });
});
