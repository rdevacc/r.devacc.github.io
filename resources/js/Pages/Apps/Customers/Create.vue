<template>

    <Head>
        <title> Add New Customer | Koperasi BBP Mektan</title>
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
                                    ADD NEW CUSTOMER
                                </span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Full Name</label>
                                                <input class="form-control" v-model="form.name"
                                                    :class="{ 'is-invalid': errors.name }" type="text"
                                                    placeholder="Full Name" />
                                                <div v-if="errors.name" class="alert alert-danger">
                                                    {{ errors.name }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">No. Telp</label>
                                                <input class="form-control" v-model="form.phone"
                                                    :class="{ 'is-invalid': errors.phone }" type="text"
                                                    placeholder="Phone Number" />
                                                <div v-if="errors.phone" class="alert alert-danger">
                                                    {{ errors.phone }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Division</label>
                                                <input class="form-control" v-model="form.division"
                                                    :class="{ 'is-invalid': errors.division }" type="text"
                                                    placeholder="Division" />
                                                <div v-if="errors.division" class="alert alert-danger">
                                                    {{ errors.division }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Address</label>
                                                <textarea class="form-control" rows="4" v-model="form.address"
                                                    :class="{ 'is-invalid': errors.address }" type="text"
                                                    placeholder="Address" />
                                                <div v-if="errors.address" class="alert alert-danger">
                                                    {{ errors.address }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary shadow-sm rounded-sm"
                                                :disabled="form.processing">Save</button>
                                            <Link href="/apps/customers"
                                                class="btn btn-warning shadow-sm rounded-sm ms-3">Cancel</Link>
                                        </div>
                                    </div>

                                </form>
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

// Import Head and Link from Inertia
import { Head, Link, useForm } from '@inertiajs/vue3';

// Import ref from Vue
import { reactive } from 'vue';

// Import Inertia
import { router } from '@inertiajs/vue3';

// Import Sweet Alert2
import Swal from 'sweetalert2';

export default {
    // Layout
    layout: LayoutApp,

    // Register Component
    components: {
        Head,
        Link,
    },

    props: {
        errors: Object,
    },

    setup() {

        // Define Form with raactive
        const form = useForm({
            name: '',
            phone: '',
            division: '',
            address: '',
        });

        // Define Method Submit
        const submit = () => {
            // Send Data to Server
            form.post('/apps/customers', {

                // Send Data
                name: form.name,
                phone: form.phone,
                division: form.division,
                address: form.address,
            }, {
                onSuccess: () => {
                    Swal.fire({
                        // Show Alert Success
                        title: 'Success!',
                        text: 'Customer saved successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 5000
                    });
                },
            });
        }

        // return
        return {
            form,
            submit,
        }
    },
}
</script>

<style>

</style>