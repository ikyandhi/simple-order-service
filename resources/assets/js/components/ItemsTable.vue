<template>

    <div class="panel-body" v-if="loaded">
        <a href="/items/create" class="btn btn-default btn-top btn-sm">Add a Item</a>
        <table class="table table-striped table-bordered" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Item SKU</th>
                    <th>Status</th>
                    <th>Physical Status</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="(item, itemIndex) in items">
                    <td>{{ item.sku }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ item.physical_status }}</td>
                    <td><a v-bind:href="'/items/' + item.id + '/edit'" class="text-info">
                            Edit
                        </a>&nbsp;&nbsp;&nbsp;  
                        <a href="#" @click.prevent="destroy(itemIndex, item.id)" class="text-danger">
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
                 items: {
                    data: []
                 },
                 loaded: false
            }
        },
        methods: {
            fetchOrders () {
                return this.$http.get('/api/items').then((response) => {
                    // getting all items
                    this.items = response.body.data;
                    this.loaded = true;
                });
            },
            destroy (itemIndex, id) {
                // send delete request to server
                //return this.$http.delete('/items/' + id);
            }
        },
        mounted() {
            this.fetchOrders();
        }
    }
</script>