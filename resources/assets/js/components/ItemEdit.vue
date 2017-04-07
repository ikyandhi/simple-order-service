<template>

    <div class="panel-body" v-if="loaded">
        <form>
            <div class="form-group">
                <label for="inputSKU">SKU: </label>
                <input type="text" class="form-control" id="inputSKU" placeholder="">
            </div>
            <div class="form-group">
                <label for="inputOrderID">Assign To Order (ID): </label>
                <input type="text" class="form-control" id="inputOrderID" placeholder="">
            </div>
            <div class="form-group">
                <label for="inputOrderID">Physical Status: </label>
                <label class="radio-inline">
                  <input type="radio" name="physical_status" id="inlineRadio1" value="to_order"> To Order
                </label>
                <label class="radio-inline">
                  <input type="radio" name="physical_status" id="inlineRadio2" value="in_warehouse"> In Warehouse
                </label>
                <label class="radio-inline">
                  <input type="radio" name="physical_status" id="inlineRadio3" value="delivered"> Delivered
                </label>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['itemId'],
        data() {
            return {
                 item: {},
                 loaded: false
            }
        },
        methods: {
            fetchDetail () {
                return this.$http.get('/api/items' + this.itemId).then((response) => {
                    // getting all items
                    this.item = response.body.data;
                    this.loaded = true;
                });
            }
        },
        mounted() {
            this.fetchDetail();
        }
    }
</script>