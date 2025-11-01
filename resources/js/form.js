document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('data-container');
    const items = JSON.parse(container.dataset.items); // ambil data dari atribut data-items

    items.forEach(key => {
        const radios = document.getElementsByName(key);
        const textarea = document.querySelector(`textarea[name="tindakan_${key}"]`);

        function toggle() {
            const checked = Array.from(radios).find(r => r.checked);
            if (checked && checked.value === 'Tidak') {
                textarea.removeAttribute('disabled');
            } else {
                textarea.value = textarea.value || '';
                textarea.setAttribute('disabled', 'disabled');
            }
        }

        radios.forEach(r => r.addEventListener('change', toggle));
        toggle();
    });
});
<script src="{{ asset('js/form.js') }}"></script>

