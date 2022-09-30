<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login (Vue component)</div>

                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">
                            
                            <input type="hidden" name="_token" :value="csrf_token">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="#">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["csrf_token"],
        data() {
            return {
                email: '', 
                password: '',
            };
        },
        methods: {
            login(event) {
                let url = 'http://localhost:8000/api/v1/auth/login';
                
                let configs = {
                    method: 'POST',
                    body: new URLSearchParams(
                        {
                            'email': this.email,
                            'password': this.password,
                        }
                    ),
                };

                fetch(url, configs)
                    .then(response => response.json())
                    .then(data => {
                        if (data.access_token) {
                            document.cookie = 'access_token=' + data.access_token + ';SameSite=Lax';
                        };
                        event.target.submit();
                    });
            },
        },
    }
</script>
