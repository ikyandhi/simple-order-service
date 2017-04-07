<template>

    <div class="panel-body" v-if="loaded">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Order Created At</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                 <tr v-for="(order, orderIndex) in orders">
                    <td>{{ order.customer_name }}</td>
                    <td>{{ order.status }}</td>
                    <td>{{ order.order_created_at }}</td>

                    <td class="text-center">
                        <a v-bind:href="'/orders/' + order.id + '/edit'" class="text-info">
                            Edit
                        </a>&nbsp;&nbsp;&nbsp;
                        <a href="#" @click.prevent="destroy(orderIndex, order.id)" class="text-danger">
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
                 orders: {
                    data: []
                 },
                 loaded: false
            }
        },
        methods: {
            fetchOrders () {
                return this.$http.get('/api/orders').then((response) => {
                    // getting all orders
                    this.orders = response.body.data;
                    this.loaded = true;
                });
            },
            destroy (orderIndex, id) {
                // send delete request to server
                //return this.$http.delete('/orders/' + id);
            }
        },
        mounted() {
            this.fetchOrders();
        }
    }
</script>