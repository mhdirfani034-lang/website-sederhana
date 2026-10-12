document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirmDelete)) {
                event.preventDefault();
            }
        });
    });

    const modal = document.querySelector('#mahasiswa-modal');
    const form = document.querySelector('#mahasiswa-form');

    if (!modal || !form) {
        return;
    }

    const title = modal.querySelector('#modal-title');
    const submit = modal.querySelector('#modal-submit');
    const method = form.querySelector('input[name="_method"]');
    const editId = form.querySelector('input[name="_edit_id"]');
    const fields = ['nim', 'nama', 'jurusan', 'angkatan', 'email'];
    let previousFocus = null;

    const openModal = (button = null) => {
        previousFocus = document.activeElement;
        if (button?.dataset.id) {
            form.action = button.dataset.updateUrl;
            method.disabled = false;
            editId.disabled = false;
            editId.value = button.dataset.id;
            fields.forEach((field) => {
                form.elements[field].value = button.dataset[field] ?? '';
            });
            title.textContent = 'Edit mahasiswa';
            submit.textContent = 'Simpan perubahan';
        } else {
            form.action = form.dataset.storeUrl;
            method.disabled = true;
            editId.disabled = true;
            editId.value = '';
            fields.forEach((field) => {
                form.elements[field].value = '';
            });
            title.textContent = 'Tambah mahasiswa';
            submit.textContent = 'Simpan data';
        }
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        modal.querySelector('#nim').focus();
    };

    const closeModal = () => {
        modal.hidden = true;
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        previousFocus?.focus();
    };

    document.querySelectorAll('[data-open-modal]').forEach((button) => {
        button.addEventListener('click', () => openModal(button.dataset.id ? button : null));
    });

    modal.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });

    if (editId.value) {
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        modal.querySelector('#nim').focus();
    } else if (modal.querySelector('.validation-summary')) {
        openModal();
    }
});
