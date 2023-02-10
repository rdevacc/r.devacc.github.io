<template>

    <Head>
        <title>Products - Koperasi BBP Mektan</title>
    </Head>
    <div class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold">
                                    <i class="fa fa-folder me-2"></i>
                                    PRODUCTS
                                </span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <Link href="products/create" v-if="hasAnyPermission(['products.create'])"
                                            class="btn btn-primary input-group-text">
                                        <i class="fa fa-plus-circle me-2"></i>
                                        NEW
                                        </Link>
                                        <input type="text" class="form-control" v-model="search"
                                            placeholder="Search by product Name...">

                                        <button type="submit" class="btn btn-primary input-group-text">
                                            <i class="fa fa-search me-2"></i>
                                            SEARCH
                                        </button>
                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Barcode</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Buy Price</th>
                                            <th scope="col">Sell Price</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col" style="width:20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(product, index) in products.data" :key="index">
                                            <td class="text-center">
                                                <Barcode :value="product.barcode" :options="{
                                                    format: 'CODE39',
                                                    lineColor: '#000',
                                                    width: 4,
                                                    height: 20
                                                }"> </Barcode>
                                            </td>
                                            <td>{{ product.title }}</td>
                                            <td>RP. {{ formatPrice(product.buy_price) }}</td>
                                            <td>RP {{ formatPrice(product.sell_price) }}</td>
                                            <td>{{ product.stock }}</td>
                                            <td class="text-center">
                                                <Link :href="`/apps/products/${product.id}/edit`"
                                                    v-if="hasAnyPermission(['products.edit'])"
                                                    class="btn btn-success btn-sm me-2">
                                                <i class="fa fa-pencil-alt"></i>
                                                Edit</Link>
                                                <button @click.prevent="destroy(product.id)"
                                                    v-if="hasAnyPermission(['products.delete'])"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                    Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="products.links" align="end" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Layout
import LayoutApp from '../../../Layouts/App.vue';

// Import Component Pagination
import Pagination from '../../../Components/Pagination.vue';

// Import Head and Link from Inertia
import { Head, Link } from '@inertiajs/vue3';

// Import Ref from Vue
import { ref } from 'vue';

// Import Inertia Adapter
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

import Barcode from '../../../Components/Barcode.vue';
// import VueBarcode from '@chenfengyuan/vue-barcode';

export default {
    // Register Layout
    layout: LayoutApp,

    components: {
        Barcode,
        Head,
        Link,
        Pagination,
    },
    props: {
        products: Object,
    },

    // Composition API
    setup() {
        // Define State Search
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        // Define Method Search
        const handleSearch = () => {
            router.get('/apps/products', {
                // Send params "q" with value from state "search"
                q: search.value,
            });
        };

        // Method Destroy
        const destroy = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        router.delete(`/apps/products/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'product deleted successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                });
        };

        // Return
        return {
            destroy,
            search,
            handleSearch,
        };
    },


}
</script>