import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        ids: JSON.parse(localStorage.getItem('testCartProducts') || '[]'),
    }),
    getters: {
        count: (state) => state.ids.length || 0,
    },
    actions: {
        changeLocalStorage() {
            localStorage.setItem('testCartProducts', JSON.stringify(this.ids));
        },
        add(id) {
            if (!this.ids.includes(id)) {
                this.ids.push(id);
                this.changeLocalStorage();
            }
        },
        remove(id) {
            this.ids = this.ids.filter((item) => item !== id);
            this.changeLocalStorage();
        },
        clear() {
            this.ids = [];
            this.changeLocalStorage();
        },
    },
});
