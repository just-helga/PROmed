@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('content')
    <div class="container" id="Authorization">
        <div class="row  mt-5  col-12  text-center  text-primary"><h2>Авторизация</h2></div>
        <div class="row  justify-content-center">
            <div class="col-6" :class="message ? 'mt-5  alert  alert-danger  text-center' : ''" style="margin-bottom: 0 !important;">@{{ message }}</div>
        </div>
        <div class="row  mt-5  justify-content-center">
            <div class="col-6">
                <form id="formAuthorization" @submit.prevent="Authorization">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="login" name="login" :class="errors.login ? 'is-invalid' : ''">
                        <div :class="errors.login ? 'invalid-feedback' : ''" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" :class="errors.password ? 'is-invalid' : ''">
                        <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn  btn-primary  col-12">Войти</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const Authorization = {
            data() {
                return {
                    errors: [],
                    message: ''
                }
            },
            methods: {
                async Authorization() {
                    const form = document.querySelector('#formAuthorization');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('Authorization')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{this.errors = []}, 20000);
                    };
                    if (response.status === 403) {
                        this.message = await response.json();
                        // setTimeout(()=>{this.message = null}, 20000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            }
        }
        Vue.createApp(Authorization).mount('#Authorization');
    </script>
@endsection
