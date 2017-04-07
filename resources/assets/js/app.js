
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

Vue.component('products_table', require('./components/ProductsTable.vue'));

Vue.component('orders_table', require('./components/OrdersTable.vue'));

Vue.component('items_table', require('./components/ItemsTable.vue'));

Vue.component('item_create', require('./components/ItemCreate.vue'));

Vue.component('item_edit', require('./components/ItemEdit.vue'));

const app = new Vue({
    el: '#app',
    data: {
        item_id: false
    }
});
