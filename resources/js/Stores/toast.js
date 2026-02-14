import { reactive } from 'vue';

export const toast = reactive({
    message: '',
    type: 'success', // 'success', 'error', 'info', 'warning'
    visible: false,
    timeout: null,

    show(message, type = 'success', duration = 3000) {
        if (this.timeout) {
            clearTimeout(this.timeout);
        }

        this.message = message;
        this.type = type;
        this.visible = true;

        this.timeout = setTimeout(() => {
            this.hide();
        }, duration);
    },

    hide() {
        this.visible = false;
        this.message = '';
    }
});
