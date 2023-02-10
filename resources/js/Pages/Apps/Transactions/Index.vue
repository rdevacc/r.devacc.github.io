<template>

    <Head>
        <title>Transactions - Aplikasi Kasir</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-0 rounded-3 shadow">
                            <div class="card-body">

                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                    <input type="text" v-model="barcode" @keyup="searchProduct" class="form-control"
                                        placeholder="Scan or Input Barcode">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" class="form-control" :value="product.title"
                                        placeholder="Product Name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Qty</label>
                                    <input type="number" class="form-control text-center" v-model="qty"
                                        placeholder="Qty" min="1">
                                </div>
                                <!-- Button -->
                                <!-- <div class="text-end">
                                    <button @click.prevent="clearSearch"
                                        class="btn btn-warning btn-md border-0 shadow text-uppercase mt-3 me-2">CLEAR</button>
                                    <button @click.prevent="addToCart"
                                        class="btn btn-success btn-md border-0 shadow text-uppercase mt-3"
                                        :disabled="!product.id">ADD ITEM</button>
                                </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <div v-if="session.error" class="alert alert-danger">
                            {{ session.error }}
                        </div>

                        <div v-if="session.success" class="alert alert-success">
                            {{ session.success }}
                        </div>

                        <div class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <h4 class="fw-bold">GRAND TOTAL</h4>
                                    </div>
                                    <div class="col-md-8 col-8 text-end">
                                        <h4 class="fw-bold">Rp. {{ formatPrice(grandTotal) }}</h4>
                                        <div v-if="change > 0">
                                            <hr>
                                            <h4 class="text-success">Change : <strong>Rp. {{
                                                formatPrice(change)
                                            }}</strong>
                                            </h4>
                                        </div>
                                        <div v-else-if="change <= 0">
                                            <hr>
                                            <h4 class="text-danger">Change : <strong>Rp. {{
                                                formatPrice(change)
                                            }}</strong>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-3 shadow">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Cashier</label>
                                        <input class="form-control" type="text" :value="auth.user.name" readonly>
                                    </div>
                                    <div class="col-md-6 float-end">
                                        <label class="fw-bold">Customer</label>
                                        <VueMultiselect v-model="customer_id" label="name" track-by="name"
                                            :options="customers"></VueMultiselect>
                                    </div>
                                </div>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="background-color: #e6e6e7;">
                                            <th scope="col">#</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="cart in carts" :key="cart.id">
                                            <td class="text-center">
                                                <button @click.prevent="destroyCart(cart.id)"
                                                    class="btn btn-danger btn-sm rounded-pill"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                            <td>{{ cart.product.title }}</td>
                                            <td>Rp. {{ formatPrice(cart.product.sell_price) }}</td>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <button @click.prevent="decrement(cart)"
                                                        class="btn btn-warning btn-sm">-</button>
                                                    <span class="mx-2">{{ cart.qty }}</span>
                                                    <button @click.prevent="increment(cart)"
                                                        class="btn btn-success btn-sm">+</button>
                                                </div>
                                            </td>
                                            <!-- <td class="text-center">{{ cart.qty }}</td> -->
                                            <td class="text-end">Rp. {{ formatPrice(cart.price) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold" style="background-color: #e6e6e7;">
                                                TOTAL</td>
                                            <td class="text-end fw-bold" style="background-color: #e6e6e7;">Rp. {{
                                                formatPrice(carts_total)
                                            }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                                    <div class="mt-auto bd-highlight">
                                        <label>Discount (Rp.)</label>
                                        <input type="number" v-model="discount" @keyup="setDiscount"
                                            class="form-control" placeholder="Discount (Rp.)">
                                    </div>
                                    <div class="bd-highlight mt-4">
                                        <label>Pay (Rp.)</label>
                                        <input type="number" v-model="cash" @keyup="setChange" class="form-control"
                                            placeholder="Pay (Rp.)">
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button
                                        class="btn btn-warning btn-md border-0 shadow text-uppercase me-2">Cancel</button>
                                    <button v-if="cash < grandTotal || cash == 0 || cash == null"
                                        @click.prevent="storeTransaction"
                                        class="btn btn-danger btn-md border-0 shadow text-uppercase">Debt &
                                        Print</button>
                                    <button v-else @click.prevent="storeTransaction"
                                        class="btn btn-purple btn-md border-0 shadow text-uppercase">Pay Order &
                                        Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import Heade from Inertia
import { Head, router } from '@inertiajs/vue3';

//import VueMultiselect
import VueMultiselect from 'vue-multiselect';

// Import Ref from Vue
import { ref } from 'vue';

// Import Axios
import axios from 'axios';

import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register components
    components: {
        Head,
        VueMultiselect,
    },

    //props
    props: {
        auth: Object,
        customers: Array,
        carts_total: Number,
        session: Object,
        carts: Array
    },
    // data() {
    //     return {
    //         customer_id: null,
    //     }
    // },
    // Composition API
    setup(props) {

        // Define State
        const barcode = ref('');
        const product = ref({});
        const qty = ref(1);
        const cash = ref(null);
        const change = ref(null);
        const discount = ref(null);
        const customer_id = ref(null);

        // Method "searchProduct"
        const searchProduct = () => {

            // Fetch with axios
            axios.post('/apps/transactions/searchProduct', {
                // Send Data Barcode
                barcode: barcode.value,
            }).then(response => {
                if (response.data.success) {
                    // Assign response to state "Product"
                    product.value = response.data.data;
                    addToCart();
                } else {
                    // Set State "Product" to Empy Object
                    product.value = {};
                }
            });
        }

        // Method "clearSearch"
        const clearSearch = () => {
            // Set state "Product" to Empty Object
            product.value = {};

            // Set state "Barcode" to Empty String
            barcode.value = '';
        }

        // Define State grandTotal
        const grandTotal = ref(props.carts_total);

        // Method "addToCart"
        const addToCart = () => {

            // Send Data to Server via Inertia
            router.post('/apps/transactions/addToCart', {
                // Data
                product_id: product.value.id,
                qty: qty.value,
                sell_price: product.value.sell_price,
            }, {
                onSuccess: () => {
                    // Call Method "clearSearch"
                    clearSearch();

                    // Set qty to  "1"
                    qty.value = 1;

                    // Update State "grandTotal"
                    grandTotal.value = props.carts_total;

                    // Set cash to "0"
                    cash.value = null;

                    // Set change to "0"
                    change.value = null;
                }
            });
        }

        // Method "destroyCart"
        const destroyCart = (cart_id) => {
            console.log(cart_id);
            router.post('/apps/transactions/destroyCart', {
                cart_id: cart_id,
            }, {
                onSuccess: () => {
                    // Update State "grandTotal"
                    grandTotal.value = props.carts_total;

                    // Set cash to "0"
                    cash.value = null;

                    // Set change to "0"
                    change.value = null;
                },
            });
        }

        // Method Increment
        const increment = (cart) => {
            router.post('/apps/transactions/increment', {
                product_id: cart.product_id,
                qty: cart.qty,
                sell_price: cart.sell_price,
            }, {
                onSuccess: () => {
                    // Call Method "clearSearch"
                    clearSearch();

                    // Set qty to  "1"
                    qty.value = 1;

                    // Update State "grandTotal"
                    grandTotal.value = props.carts_total;

                    // Set cash to "0"
                    cash.value = null;

                    // Set change to "0"
                    change.value = null;
                },
            });
        }

        // Method Decrement
        const decrement = (cart) => {
            router.post('/apps/transactions/decrement', {
                product_id: cart.product_id,
                qty: cart.qty,
                sell_price: cart.sell_price,
            }, {
                onSuccess: () => {
                    // Call Method "clearSearch"
                    clearSearch();

                    // Set qty to  "1"
                    qty.value = 1;

                    // Update State "grandTotal"
                    grandTotal.value = props.carts_total;

                    // Set cash to "0"
                    cash.value = null;

                    // Set change to "0"
                    change.value = null;
                }
            });
        }

        // Method "setDiscount"
        const setDiscount = () => {
            // Set grandTotal
            grandTotal.value = props.carts_total - discount.value;

            // Set cash to "0"
            // cash.value = null;

            // Set change value
            change.value = cash.value - grandTotal.value;
        }

        const setChange = () => {
            // Set Change
            change.value = cash.value - grandTotal.value;
        }

        // Method "storeTransaction"
        const storeTransaction = () => {

            if (discount.value == null) {
                discount.value = 0;
            }

            console.log(customer_id);

            //HTTP request
            axios.post('/apps/transactions/store', {

                //send data to server
                customer_id: customer_id.value ? customer_id.value.id : '',
                discount: discount.value,
                grand_total: grandTotal.value,
                cash: cash.value,
                change: change.value
            }).then(response => {
                //call method "clearSaerch"
                clearSearch();

                //set qty to "1"
                qty.value = 1;

                //set grandTotal
                grandTotal.value = props.carts_total;

                //set cash to "0"
                cash.value = 0;

                //set change to "0"
                change.value = 0;

                //set customer_id to ""
                customer_id.value = '';

                Swal.fire({
                    title: 'Success!',
                    text: 'Transaction Successfully.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {

                    setTimeout(() => {

                        //print
                        window.open(`/apps/transactions/print?invoice=${response.data.data.invoice}`, '_blank');

                        //reload page
                        location.reload();

                    }, 50);

                })
            })
        }

        return {
            addToCart,
            barcode,
            clearSearch,
            cash,
            change,
            discount,
            destroyCart,
            grandTotal,
            product,
            searchProduct,
            qty,
            setDiscount,
            setChange,
            increment,
            decrement,
            customer_id,
            storeTransaction,
        }
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css">

</style>