document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showToast(message, isSuccess = true) {
        const toastEl = document.getElementById('cartToast');
        const toastMessage = document.getElementById('cartToastMessage');
        if (!toastEl || !toastMessage) return;

        toastMessage.textContent = message;
        toastEl.classList.remove('bg-success', 'bg-danger');
        toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger');

        const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
        toast.show();
    }

    function updateCartBadge(count) {
        const badge = document.getElementById('cartCountBadge');
        if (!badge) return;

        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('d-none');
        } else {
            badge.classList.add('d-none');
        }
    }

    document.querySelectorAll('.btn-add-to-cart').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const productId = this.dataset.productId;
            const qtyInput = document.querySelector('#qty-' + productId);
            const qty = qtyInput ? qtyInput.value : 1;

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ qty: qty }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, true);
                        updateCartBadge(data.cartCount);
                    } else {
                        showToast(data.message, false);
                    }
                })
                .catch(() => {
                    showToast('Có lỗi xảy ra, vui lòng thử lại.', false);
                });
        });
    });
});