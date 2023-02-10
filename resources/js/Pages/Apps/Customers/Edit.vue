<template>

    <Head>
        <title> Edit Customer | Koperasi BBP Mektan</title>
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
                                    EDIT CUSTOMER
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
                                                    placeholder="No. Telp" />
                                                <div v-if="errors.phone" class="alert alert-danger">
                                                    {{ errors.phone }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Divisi</label>
                                                <input class="form-control" v-model="form.division"
                                                    :class="{ 'is-invalid': errors.division }" type="text"
                                                    placeholder="Divisi" />
                                                <div v-if="errors.division" class="alert alert-danger">
                                                    {{ errors.division }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Alamat</label>
                                                <textarea class="form-control" rows="4" v-model="form.address"
                                                    :class="{ 'is-invalid': errors.address }" type="password"
                                                    placeholder="Password Confirmation" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary shadow-sm rounded-sm"
                                                :disabled="form.processing">Update</button>
                                            <Link href="/apps/customers"
                                                class="btn btn-warning shadow-sm rounded-sm ms-3">
                                            Cancel
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
        customer: Object,
    },

    setup(props) {

        // Define Form with raactive
        // const form = reactive({
        //     name: props.user.name,
        //     email: props.user.email,
        //     password: '',
        //     address: '',
        //     roles: props.user.roles.map(obj => obj.name),
        // });

        const form = useForm({
            name: props.customer.name,
            phone: props.customer.phone,
            division: props.customer.division,
            address: props.customer.address,
        });

        // Define Method Submit
        const submit = () => {
            // Send Data to Server
            form.put(`/apps/customers/${props.customer.id}`, {

                // Send Data
                name: form.name,
                phone: form.phone,
                division: form.division,
                address: form.address,
            }, {
                onSuccess: () => {
                    // Show Success Alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'User Edited Successfully',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000,
                    });
                },
            }
            );
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