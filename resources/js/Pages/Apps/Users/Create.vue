<template>

    <Head>
        <title> Add New User | Koperasi BBP Mektan</title>
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
                                    ADD NEW USER
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
                                                <label class="fw-bold">Email Address</label>
                                                <input class="form-control" v-model="form.email"
                                                    :class="{ 'is-invalid': errors.email }" type="text"
                                                    placeholder="Email Address" />
                                                <div v-if="errors.email" class="alert alert-danger">
                                                    {{ errors.email }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Password</label>
                                                <input class="form-control" v-model="form.password"
                                                    :class="{ 'is-invalid': errors.password }" type="password"
                                                    placeholder="Password" />
                                                <div v-if="errors.password" class="alert alert-danger">
                                                    {{ errors.password }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Password Confirmation</label>
                                                <input class="form-control" v-model="form.password_confirmation"
                                                    :class="{ 'is-invalid': errors.password_confirmation }"
                                                    type="password" placeholder="Password Confirmation" />
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="fw-bold">Roles</label>
                                                <br />

                                                <div class="form-check form-check-inline" v-for="(role, index) in roles"
                                                    :key="index">
                                                    <input class="form-check-input" type="checkbox" v-model="form.roles"
                                                        :value="role.name" :id="`check-${role.id}`">
                                                    <label class="form-check-label" :for="`check-${role.id}`">{{
                                                        role.name
                                                    }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div v-if="errors.roles" class="alert alert-danger"> {{ errors.roles }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary shadow-sm rounded-sm"
                                                :disabled="form.processing">Save</button>
                                            <Link href="/apps/users" class="btn btn-warning shadow-sm rounded-sm ms-3">
                                            Cancel</Link>
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
        roles: Array,
    },

    setup() {

        // Define Form with raactive
        // const form = useForm({
        //     name: '',
        //     email: '',
        //     password: '',
        //     password_confirmation: '',
        //     roles: [],
        // });
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            roles: [],
        });

        // Define Method Submit
        const submit = () => {
            // Send Data to Server
            form.post('/apps/users', {

                // Send Data
                name: form.name,
                email: form.email,
                password: form.password,
                password_confirmation: form.password_confirmation,
                roles: form.roles,
            }, {
                onSuccess: () => {
                    //show success alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'User saved successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
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