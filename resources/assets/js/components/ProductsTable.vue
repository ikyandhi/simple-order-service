<template>

    <div class="panel-body" v-if="loaded">
        <a href="/products/create" class="btn btn-default btn-top btn-sm">Add a Product</a>
        <table class="table table-striped table-bordered" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="(product, productIndex) in products">
                    <td>{{ product.sku }}</td>
                    <td class="text-center">
                        <a v-bind:href="'/products/' + product.id + '/edit'" class="text-info">
                            Edit
                        </a>&nbsp;&nbsp;&nbsp;
                        <a href="#" @click.prevent="destroy(productIndex, product.id)" class="text-danger">
                            X
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                 products: {
                    data: []
                 },
                 loaded: false
            }
        },
        methods: {
            fetchProducts () {
                return this.$http.get('/api/products').then((response) => {
                    // getting all products
                    this.products = response.body.data;
                    this.loaded = true;
                });
            },
            destroy (productIndex, id) {
                // send delete request to server
                //return this.$http.delete('/products/' + id);
            }
        },
        mounted() {
            this.fetchProducts();
        }
    }
</script>