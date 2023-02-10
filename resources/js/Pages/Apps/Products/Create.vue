<template>

    <Head>
        <title>Add New Products - Koperasi BBP Mektan</title>
    </Head>
    <div class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border top purple">
                            <div class="card-header">
                                <span class="font-weight-bold">
                                    <i class="fa fa-folder"></i>
                                    ADD NEW PRODUCT
                                </span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <input type="file" class="form-control"
                                            @input="form.image = $event.target.files[0]"
                                            :class="{ 'is-invalid': errors.image }">
                                    </div>
                                    <div v-if="errors.image" class="alert alert-danger">
                                        {{ errors.image }}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Barcode</label>
                                                <input type="text" class="form-control" v-model="form.barcode"
                                                    :class="{ 'is-invalid': errors.barcode }" placeholder="Barcode">
                                            </div>
                                            <div v-if="errors.barcode" class="alert alert-danger">
                                                {{ errors.barcode }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Category</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors.category_id }"
                                                    v-model="form.category_id">
                                                    <option v-for="(category, index) in categories" :key="index"
                                                        :value="category.id">
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="errors.category_id" class="alert alert-danger">
                                                {{ errors.category_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Title Product</label>
                                                <input type="text" class="form-control" v-model="form.title"
                                                    :class="{ 'is-invalid': errors.title }" placeholder="Title Product">
                                            </div>
                                            <div v-if="errors.title" class="alert alert-danger">
                                                {{ errors.title }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Stock</label>
                                                <input type="text" class="form-control" v-model="form.stock"
                                                    :class="{ 'is-invalid': errors.stock }" placeholder="Stock Product">
                                            </div>
                                            <div v-if="errors.stock" class="alert alert-danger">
                                                {{ errors.stock }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Description</label>
                                        <textarea class="form-control" v-model="form.description"
                                            :class="{ 'is-invalid': errors.description }" type="text" rows="4"
                                            placeholder="Description"></textarea>
                                    </div>
                                    <div v-if="errors.description" class="alert alert-danger">
                                        {{ errors.description }}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Buy Price</label>
                                                <input class="form-control" v-model="form.buy_price"
                                                    :class="{ 'is-invalid': errors.buy_price }" type="number"
                                                    placeholder="Buy Price">
                                            </div>
                                            <div v-if="errors.buy_price" class="alert alert-danger">
                                                {{ errors.buy_price }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Sell Price</label>
                                                <input class="form-control" v-model="form.sell_price"
                                                    :class="{ 'is-invalid': errors.sell_price }" type="number"
                                                    placeholder="Sell Price">
                                            </div>
                                            <div v-if="errors.sell_price" class="alert alert-danger">
                                                {{ errors.sell_price }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary shadow-sm rounded-sm"
                                                :disabled="form.processing">Save
                                            </button>
                                            <Link href="/apps/products"
                                                class="btn btn-warning shadow-sm rounded-sm ms-3"> Cancel
                                            </Link>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Import Layout App
import LayoutApp from '../../../Layouts/App.vue';

// Import Head and Link from Inertia
import { Head, Link, useForm } from '@inertiajs/vue3';

// Import ref from Vue
import { reactive } from 'vue';

// Import Inertia Adapter
import { router } from '@inertiajs/vue3';

// import Sweet Alert 2
import Swal from 'sweetalert2';

export default {
    // Register Layout
    layout: LayoutApp,

    // Register Component
    components: {
        Head,
        Link,
    },

    // Props
    props: {
        errors: Object,
        categories: Array,
    },

    // Composition API
    setup() {
        // Define Form with Reactive
        // const form = reactive({
        //     image: '',
        //     barcode: '',
        //     category_id: '',
        //     title: '',
        //     description: '',
        //     buy_price: '',
        //     sell_price: '',
        //     stock: '',
        // });
        const form = useForm({
            image: null,
            barcode: null,
            category_id: null,
            title: null,
            description: null,
            buy_price: null,
            sell_price: null,
            stock: null,
        });

        // Method Submit
        const submit = () => {
            form.post('/apps/products', {
                // Send data to Server
                image: form.image,
                barcode: form.barcode,
                category_id: form.category_id,
                title: form.title,
                description: form.description,
                buy_price: form.buy_price,
                sell_price: form.sell_price,
                stock: form.stock
            }, {
                onSuccess: () => {
                    Swal.fire({
                        // Show Alert Success
                        title: 'Success!',
                        text: 'Category saved successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });

        };
        return {
            form,
            submit
        };
    },

}
</script>