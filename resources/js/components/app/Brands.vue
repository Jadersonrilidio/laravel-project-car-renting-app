<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Start brand SEARCH card -->
                <div class="card">
                    <div class="card-header">Brands Search</div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="ID" id="inputId" id-help="idHelp" text-help="Inform brand ID (optional)">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placoholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component title="Name" id="inputName" id-help="nameHelp" text-help="Inform brand name (optional)">
                                    <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" placoholder="brand name">
                                </input-container-component>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm" style="float:right">Search</button>
                    </div>
                </div>
                <!-- End brand SEARCH card -->

                <!-- Start brand LISTING card -->
                <div class="card">
                    <div class="card-header">Brands Relation</div>
                    
                    <div class="card-body">
                        <table-component></table-component>
                    </div>
                    
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-sm" style="float:right">Add</button>
                    </div>
                </div>
                <!-- End brand LISTING card -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return null;
        },
        methods: {

        }
    }
</script>