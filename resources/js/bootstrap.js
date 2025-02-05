import axios from 'axios';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', function() {
    window.Alpine = Alpine;

    Alpine.store('sidebar', {
        collapsed: true,
    });

    Alpine.directive('remove', el => {
        el.remove();
    });

    Alpine.directive('ajax', el => {
        el.addEventListener('submit', function (e) {
            e.preventDefault();

            axios({
                method: this.method,
                url: this.action,
                data: new FormData(this)
            }).then((response) => {
              Alpine.store('toast').addToast(response.data?.message ?? 'Success.');
            }).catch((error) => {
              Alpine.store('toast').addToast(error.response?.data?.message ?? error.message, "error");
            });
        });
    });

    Alpine.plugin(collapse);
    Alpine.start();
});
