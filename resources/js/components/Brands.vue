<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumb-component :current-page="currentPage">
                </breadcrumb-component>

                <!-- Start brand SEARCH card -->
                <card-component title="Search Brand">

                    <template v-slot:content>
                        <div class="row">

                            <input-container-component div-classes="form-group col mb-3" title="ID" id="inputId" id-help="idHelp" text-help="Inform brand ID (optional)">
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placoholder="ID">
                            </input-container-component>

                            <input-container-component div-classes="form-group col mb-3" title="Name" id="inputName" id-help="nameHelp" text-help="Inform brand name (optional)">
                                <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placoholder="brand name">
                            </input-container-component>

                        </div>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right">
                            Search
                        </button>
                    </template>

                </card-component>
                <!-- End brand SEARCH card -->

                <!-- Start brand LISTING card -->
                <card-component title="Brands List">

                    <template v-slot:content>
                        <table-component :cols="columns" :data="brands">
                        </table-component>
                    </template>

                    <template v-slot:footer>
                        <!-- Button trigger modal addBrand -->
                        <button type="button" class="btn btn-primary btn-sm" style="float:right " data-bs-toggle="modal" data-bs-target="#addBrandModal">
                            Add
                        </button>
                    </template>

                </card-component>
                <!-- End brand LISTING card -->
            </div>
        </div>

        <!-- Start modal addBrandModal -->
        <modal-component id="addBrandModal" title="Add New Brand">
            
            <template v-slot:alerts>
                <alert-component :details="details" :title="(details.status == 'success') ? 'Success' : 'Error' " v-if="details.status != null ">
                </alert-component>
            </template>

            <template v-slot:content>

                <input-container-component div-classes="form-group" title="Brand Name" id="name" id-help="brandHelp" text-help="Inform brand name">
                    <input type="text" class="form-control" id="name" aria-describedby="brandHelp" v-model="name">
                </input-container-component>

                <input-container-component div-classes="form-group" title="Image" id="image" id-help="imageHelp" text-help="Upload image on formats PNG, JPEG or JPG">
                    <input type="file" class="form-control-file" id="image" aria-describedby="imageHelp" @change="uploadImage($event)">
                </input-container-component>

            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="cancelAddBrand()">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="addBrand()">
                        Add
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal addBrandModal -->

    </div>
</template>

<script>
    export default {
        props: [
            'currentPage',
        ],
        data() {
            return {
                baseUrl: 'http://localhost:8000/api/v1/brand',
                name: '',
                image: [],
                columns: ['id', 'name', 'image'],
                brands: [],
                details: {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                }
            };
        },
        methods: {
            loadBrandsList() {
                let config = {
                    headers: {
                        'Authorization': this.token,
                        'Accept': 'application/json',
                    },
                };

                axios.get(this.baseUrl, config)
                    .then(response => {
                        this.brands = response.data;
                        console.log(this.brands);
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            uploadImage(event) {
                this.image = event.target.files;
            },
            addBrand() {
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('image', this.image[0]);

                let config = {
                    headers: {
                        'Authorization': this.token,
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                    },
                };

                this.details = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                };

                axios.post(this.baseUrl, formData, config)
                    .then(response => {
                        this.details.status = 'success';
                        this.details.object = response.data;
                        this.loadBrandsList();
                    })
                    .catch(errors => {
                        this.details.status = 'danger';
                        this.details.message = errors.response.data.message;
                        this.details.errors = errors.response.data.errors;
                    });
            },
            cancelAddBrand() {
                this.name = '';
                this.image = [];
                this.details = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                };
            },
        },
        computed: {
            token() {
                let token = document.cookie
                        .split(';')
                        .find(index => index.includes('token='))
                        .split('=');
                return 'bearer ' + token[1];
            },
        },
        mounted() {
            this.loadBrandsList();
        }
    }
</script>
