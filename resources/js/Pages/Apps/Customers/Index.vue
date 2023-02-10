<template>

    <Head>
        <title> Customers | Koperasi BBP Mektan</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold">
                                    <i class="fa fa-shield-alt"></i>
                                    CUSTOMERS
                                </span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <Link href="/apps/customers/create"
                                            v-if="hasAnyPermission(['customers.create'])"
                                            class="btn btn-primary input-group-text">
                                        <i class="fa fa-plus-circle me-2"></i>
                                        NEW
                                        </Link>
                                        <input type="text" class="form-control" v-model="search"
                                            placeholder="Search by customer Name...">

                                        <button type="submit" class="btn btn-primary input-group-text">
                                            <i class="fa fa-search me-2"></i>
                                            SEARCH
                                        </button>
                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">No. Telp</th>
                                            <th scope="col">Division</th>
                                            <th scope="col">Address</th>
                                            <th scope="col" style="width:20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(customer, index) in customers.data" :key="index">
                                            <td>{{ customer.name }}</td>
                                            <td>0{{ customer.phone }}</td>
                                            <td>{{ customer.division }}</td>
                                            <td>{{ customer.address }}</td>
                                            <td class="text-center">
                                                <Link :href="`/apps/customers/${customer.id}/edit`"
                                                    v-if="hasAnyPermission(['customers.edit'])"
                                                    class="btn btn-success btn-sm me-2"><i
                                                    class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                                                <button @click.prevent="destroy(customer.id)"
                                                    v-if="hasAnyPermission(['customers.delete'])"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                    DELETE
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="customers.links" align="end" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
// Import Layout
import LayoutApp from '../../../Layouts/App.vue';

// Import Component Pagination
import Pagination from '../../../Components/Pagination.vue';

// Import Head and Link from Inertia
import { Head, Link } from '@inertiajs/vue3';

// Import ref from Vue
import { ref } from 'vue';

// Import Inertia
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
    // Layout
    layout: LayoutApp,

    // Register Component
    components: {
        Head,
        Link,
        Pagination,
    },

    props: {
        customers: Object,
    },

    setup() {

        // Define State Search
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        // Define Method Search
        const handleSearch = () => {
            router.get('/apps/customers', {

                // Send Params "q" with value from state "search"
                q: search.value,
            });
        }

        // Define Method Destroy
        const destroy = (id) => {
            Swal.fire({
                title: 'Are You Sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        router.delete(`/apps/customers/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'customer Seleted Successfully',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
        }

        // return
        return {
            search,
            handleSearch,
            destroy
        }
    },
}
</script>

<style>

</style>