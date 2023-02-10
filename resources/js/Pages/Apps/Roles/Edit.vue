<template>

    <Head>
        <title> Edit Roles | Koperasi BBP Mektan</title>
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
                                    EDIT ROLE
                                </span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <label class="fw-bold">Role Name</label>
                                        <input class="form-control" v-model="form.name"
                                            :class="{ 'is-invalid': errors.name }" type="text"
                                            placeholder="Role Name" />

                                        <div v-if="errors.name" class="alert alert-danger">
                                            {{ errors.name }}
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="mb-3">
                                        <label class="fw-bold">Permissions</label>
                                        <br />

                                        <div class="form-check form-check-inline"
                                            v-for="(permission, index) in permissions" :key="index">
                                            <input class="form-check-input" type="checkbox" v-model="form.permissions"
                                                :value="permission.name" :id="`check-${permission.id}`">
                                            <label class="form-check-label" :for="`check-${permission.id}`">{{
                                                permission.name
                                            }}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary shadow-sm rounded-sm"
                                                :disabled="form.processing">Update</button>
                                            <Link href="/apps/roles" class="btn btn-primary shadow-sm rounded-sm ms-3">
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
        permissions: Array,
        role: Object,
    },

    setup(props) {

        // Define Form with raactive
        // const form = reactive({
        //     name: props.role.name,
        //     permissions: props.role.permissions.map(obj => obj.name),
        // });

        const form = useForm({
            name: props.role.name,
            permissions: props.role.permissions.map(obj => obj.name),
        });

        // Define Method Submit
        const submit = () => {
            // Send Data to Server
            form.put(`/apps/roles/${props.role.id}`, {

                // Send Data
                name: form.name,
                permissions: form.permissions,
            }, {
                onSuccess: () => {
                    // Show Success Alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'Role Updated Successfully',
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