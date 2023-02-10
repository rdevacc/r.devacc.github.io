<template>

    <Head>
        <title>Permissions - Koperasi BBP Mektan</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-key"></i>PERMISSIONS</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" v-model="search"
                                            placeholder="Serch by Permission Name...">
                                        <button type="submit" class="btn btn-primary input-group-text">
                                            <i class="fa fa-search me-2"></i>
                                            SEARCH
                                        </button>
                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Permission Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(permission, index) in permissions.data" :key="index">
                                            <td>{{ permission.name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="permissions.links" align="end" />
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

// Import Inertia Adapter
import { router } from '@inertiajs/vue3';

export default {
    // Layout
    layout: LayoutApp,

    // Register Components
    components: {
        Head,
        Link,
        Pagination,
    },

    // Props
    props: {
        permissions: Object,
    },

    setup() {

        // Define State Search
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        // Define Method Search
        const handleSearch = () => {
            router.get('/apps/permissions', {
                // Send Params "q" with value from state "Search"
                q: search.value,
            });
        }

        // Return
        return {
            search,
            handleSearch,
        };
    },
}

</script>

<style>

</style>