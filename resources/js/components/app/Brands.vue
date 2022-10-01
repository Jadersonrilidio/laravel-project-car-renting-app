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
                        <table-component>
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

        <!-- Start modal addBrand -->
        <modal-component id="addBrandModal" title="Add New Brand">

            <template v-slot:content>

                    <input-container-component div-classes="form-group" title="Brand Name" id="brandName" id-help="brandHelp" text-help="Inform brand name">
                        <input type="text" class="form-control" id="brandName" aria-describedby="brandHelp" v-model="brandName">
                    </input-container-component>

                    <input-container-component div-classes="form-group" title="Image" id="brandImage" id-help="imageHelp" text-help="Upload image  on formats PNG, JPEG or JPG">
                        <input type="file" class="form-control-file" id="brandImage" aria-describedby="imageHelp" @change="uploadImage($event)">
                    </input-container-component>

            </template>

            <template v-slot:footer>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" @click="addBrand($event)">
                        Add
                    </button>
                </div>
            </template>

        </modal-component>
        <!-- End modal addBrand -->

    </div>
</template>

<script>
    export default {
        props: ['currentPage'],
        data() {
            return {
                brandName: '',
                brandImage: [],
            };
        },
        methods: {
            uploadImage(event) {
                this.brandImage = event.target.files;
            },
            addBrand(event) {
                let url = 'http://localhost:8000/api/v1/brand';
                
                let configs = {
                    method: 'POST',
                    body: new URLSearchParams(
                        {
                            'name': this.brandName,
                            'image': this.brandImage,
                        }
                    ),
                };

                fetch(url, configs).then(response => response.json())
            },
        }
    }
</script>