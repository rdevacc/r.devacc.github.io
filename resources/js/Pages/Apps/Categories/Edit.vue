<template>

    <Head>
        <title>Edit Category - Koperasi BBP Mektan</title>
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
                                    EDIT CATEGORY
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
                                    <div class="mb-3">
                                        <label class="fw-bold">Category Name</label>
                                        <input type="text" class="form-control" v-model="form.name"
                                            :class="{ 'is-invalid': errors.name }" placeholder="Category Name">
                                    </div>
                                    <div v-if="errors.name" class="alert alert-danger">
                                        {{ errors.name }}
                                    </div>
                                    <div class="mb-3">
                                        <label class="fw-bold">Category Description</label>
                                        <textarea type="text" rows="4" class="form-control" v-model="form.description"
                                            :class="{ 'is-invalid': errors.description }"
                                            placeholder="Description"></textarea>
                                    </div>
                                    <div v-if="errors.description" class="alert alert-danger">
                                        {{ errors.description }}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                class="btn btn-primary shadow-sm rounded-sm">Update</button>
                                            <Link href="/apps/categories"
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
import { Head, Link } from '@inertiajs/vue3';

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
        category: Object,
    },

    // Composition API
    setup(props) {
        // Define Form with Reactive
        const form = reactive({
            name: props.category.name,
            description: props.category.description,
            image: '',
        });


        // Method Submit
        const submit = () => {
            router.post(`/apps/categories/${props.category.id}`, {
                // Send data to Server
                _method: 'PUT',
                name: form.name,
                description: form.description,
                image: form.image,
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