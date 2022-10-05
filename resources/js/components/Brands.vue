<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumb-component :current-page="currentPage">
                </breadcrumb-component>

                <!-- Start card BRAND_SEARCH -->
                <card-component title="Search Brand">

                    <template v-slot:content>
                        <div class="row">

                            <input-container-component classes="form-group col mb-3" title="ID" id="inputId" id-help="idHelp" text-help="Inform brand ID (optional)">
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placoholder="ID" v-model="search.id">
                            </input-container-component>

                            <input-container-component classes="form-group col mb-3" title="Name" id="inputName" id-help="nameHelp" text-help="Inform brand name (optional)">
                                <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placoholder="brand name" v-model="search.name">
                            </input-container-component>

                        </div>
                    </template>

                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right" @click="searchBrands()">
                            Search
                        </button>
                    </template>

                </card-component>
                <!-- End card BRAND_SEARCH -->

                <!-- Start card BRAND_LISTING -->
                <card-component title="Brands List">

                    <template v-slot:content>
                        
                        <table-component
                            :columns="columns"
                            :data="brands.data"
                            :buttons="buttons"
                        >
                        </table-component>

                        <paginate-component >
                            <li v-for="pg, key in brands.links" :key="key" class="page-item" :class="pageIsActive(pg)" @click="pagination(pg)" :style="setCursorStyle(pg)">
                                <a class="page-link" :class="pageIsDisabled(pg)" v-html="pg.label">
                                </a>
                            </li>
                        </paginate-component>
                    
                    </template>

                    <template v-slot:footer>
                        <!-- Button trigger modal ADD_BRAND_MODAL -->
                        <button type="button" class="btn btn-primary btn-sm" style="float:right " data-bs-toggle="modal" data-bs-target="#addBrandModal">
                            Add
                        </button>
                    </template>

                </card-component>
                <!-- End card BRAND_LISTING -->
            </div>
        </div>

        <!-- Start modal ADD_BRAND_MODAL -->
        <modal-component id="addBrandModal" title="Add New Brand">
            <template v-slot:alerts>
                <alert-component :details="details" :title="title" v-if="details.status != null ">
                </alert-component>
            </template>

            <template v-slot:content>

                <input-container-component classes="form-group" title="Brand Name" id="name" id-help="brandHelp" text-help="Inform brand name">
                    <input type="text" class="form-control" id="name" aria-describedby="brandHelp" v-model="name">
                </input-container-component>

                <input-container-component classes="form-group" title="Image" id="image" id-help="imageHelp" text-help="Upload image on formats PNG, JPEG or JPG">
                    <input type="file" class="form-control-file" id="image" aria-describedby="imageHelp" @change="uploadImage($event)">
                </input-container-component>

            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearAll()">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="addBrand()">
                        Add
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal ADD_BRAND_MODAL -->

        <!-- Start modal VIEW_BRAND_MODAL -->
        <modal-component :id="buttons.view.dataTarget" :title="buttons.view.title" v-if="buttons.view">

            <template v-slot:content>

                <input-container-component classes="form-group">
                    <img :src="'storage/'+$store.state.item.image" v-if="$store.state.item.image">
                </input-container-component>

                <input-container-component classes="form-group" title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                
                <input-container-component classes="form-group" title="Name">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>

                <input-container-component classes="form-group" title="Created at">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | globalFormatDateTime" disabled>
                </input-container-component>
                
            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-success">
                        Edit
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal VIEW_BRAND_MODAL -->

        <!-- Start modal EDIT_BRAND_MODAL -->
        <modal-component :id="buttons.edit.dataTarget" :title="buttons.edit.title" v-if="buttons.edit">

            <template v-slot:alerts>
                <alert-component :details="details" :title="title" v-if="details.status != null ">
                </alert-component>
            </template>

            <template v-slot:content>
                
                <input-container-component classes="form-group" title="Brand Name" id="updateName" id-help="nameHelp" text-help="Inform brand name">
                    <input type="text" class="form-control" id="updateName" aria-describedby="nameHelp" v-model="$store.state.item.name">
                </input-container-component>

                <input-container-component classes="form-group" title="Image" id="updateImage" id-help="imageHelp" text-help="Upload image on formats PNG, JPEG or JPG">
                    <input type="file" class="form-control-file" id="updateImage" aria-describedby="imageHelp" @change="uploadImage($event)">
                </input-container-component>

            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearAll()">
                        Close
                    </button>
                    <button type="button" class="btn btn-success" @click="updateBrand()">
                        Update
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal EDIT_BRAND_MODAL -->

        <!-- Start modal DELETE_BRAND_MODAL -->
        <modal-component :id="buttons.delete.dataTarget" :title="buttons.delete.title" v-if="buttons.delete">
            
            <template v-slot:alerts>
                <alert-component :details="$store.state.transaction" :title="$store.state.transaction.status">
                </alert-component>
            </template>

            <template v-slot:content v-if="!$store.state.transaction.status">

                <input-container-component classes="form-group">
                    <img :src="'storage/'+$store.state.item.image" v-if="$store.state.item.image">
                </input-container-component>

                <input-container-component classes="form-group" title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                
                <input-container-component classes="form-group" title="Name">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>

                <input-container-component classes="form-group" title="Created at">
                    <input type="text" class="form-control" :value="$store.state.item.created_at | globalFormatDateTime" disabled>
                </input-container-component>

            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <span style="font-size:1.1em" v-if="!$store.state.transaction.status">
                        Are you sure to delete? &#8195;
                    </span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" @click="deleteBrand()" v-if="!$store.state.transaction.status">
                        Delete
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal DELETE_BRAND_MODAL -->

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
                paginationUrl: '',
                filterUrl: '',
                name: '',
                image: [],
                search: {
                    id: '',
                    name: '',
                },
                columns: {
                    id: {
                        title: 'ID',
                        type: 'text',
                    },
                    name: {
                        title: 'Brand',
                        type: 'text',
                    },
                    image: {
                        title: 'Logo',
                        type: 'image',
                    },
                    created_at: {
                        title: 'Creation Date',
                        type: 'datetime',
                    },
                },
                brands: {
                    data: []
                },
                details: {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                },
                buttons: {
                    view: {
                        title: 'View Brand',
                        text: 'View',
                        class: 'primary',
                        dataToggle: 'modal',
                        dataTarget: 'viewBrandModal'
                    },
                    edit: {
                        title: 'Edit Brand',
                        text: 'Edit',
                        class: 'success',
                        dataToggle: 'modal',
                        dataTarget: 'editBrandModal'
                    },
                    delete: {
                        title: 'Delete Brand',
                        text: 'Delete',
                        class: 'danger',
                        dataToggle: 'modal',
                        dataTarget: 'deleteBrandModal'
                    },
                },
            };
        },
        methods: {
            loadBrandsList() {
                let url = this.mountUrl();
                let config = {
                    headers: {
                        'Authorization': this.token,
                        'Accept': 'application/json',
                    },
                };

                axios.get(url, config)
                    .then(response => {
                        this.brands = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            mountUrl() {
                let filterUrl = (this.paginationUrl && this.filterUrl)
                        ? '&' + this.filterUrl
                        : this.filterUrl;

                return this.baseUrl + '?' + this.paginationUrl + filterUrl;
            },
            pagination(pg) {
                if (pg.url) {
                    this.paginationUrl = pg.url.split('?')[1];
                    this.loadBrandsList();
                }
            },
            pageIsActive(pg) {
                if (pg.active)
                    return 'active';
            },
            pageIsDisabled(pg) {
                if  ((pg.label == 'Next &raquo;' && this.brands.current_page == this.brands.last_page)
                        || (pg.label == '&laquo; Previous' && this.brands.current_page == '1'))
                                return 'disabled';
            },
            setCursorStyle(pg) {
                return this.pageIsDisabled(pg)
                    ? 'cursor:text'
                    : 'cursor:pointer';
            },
            uploadImage(event) {
                this.image = event.target.files;
            },
            clearDetails() {
                this.details = {
                    status: null,
                    object: {},
                    message: '',
                    errors: [],
                };
            },
            clearAll() {
                this.name = '';
                this.image = [];
                this.clearDetails();
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

                this.clearDetails();

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
            updateBrand() {
                let url = this.baseUrl + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('name', this.$store.state.item.name);
                formData.append('_method', 'patch');
                if (this.image[0])
                    formData.append('image', this.image[0]);

                let configs = {
                    headers: {
                        'Authorization': this.token,
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                    },
                };

                this.clearDetails();

                axios.post(url, formData, configs)
                    .then(response => {
                        this.details.status = 'success';
                        this.details.object = response.data;
                        updateImage.value = '';
                        this.loadBrandsList();
                    })
                    .catch(errors => {
                        this.details.status = 'danger';
                        this.details.message = errors.response.data.message;
                        this.details.errors = errors.response.data.errors;
                    });
            },
            deleteBrand() {
                let url = this.baseUrl + '/' + this.$store.state.item.id;
                console.log(url);
                let configs = {
                    headers: {
                        'Authorization': this.token,
                        'Content-Type': 'application/json' ,
                        'Accept': 'application/json',
                    }
                };

                axios.delete(url, configs)
                    .then(response => {
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = 'Transaction done with success!';
                        this.loadBrandsList();
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            searchBrands() {
                let filter = '';

                for (let key in this.search) {
                    if (this.search[key]) {
                        filter += (filter == '')
                                ? 'filter='
                                : ';';
                        filter += (isNaN(this.search[key]))
                            ? key + ':LIKE:%' + this.search[key] + '%'
                            : key + ':=:' + this.search[key];
                    }
                }

                this.filterUrl = filter;
                this.paginationUrl = 'page=1';
                this.loadBrandsList();
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
            title() {
                return (this.details.status == 'success')
                        ? 'Success'
                        : 'Error';
            }
        },
        mounted() {
            this.loadBrandsList();
        }
    }
</script>
