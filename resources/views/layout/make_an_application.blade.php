<!-- Модальное окно оформления заявки -->
<div class="modal  fade" id="Application" tabindex="-1" aria-labelledby="ApplicationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ApplicationLabel">Оформление заявки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div :class="message ? 'mb-3  alert  alert-success  text-center' : ''" style="margin-left: 12px; margin-right: 12px; flex-shrink: inherit">@{{ message }}</div>
                <form id="FormApplication" enctype="multipart/form-data" @submit.prevent="Arrange">
                    <div class="mb-3">
                        <label for="name" class="form-label">ФИО</label>
                        <input type="text" class="form-control" id="name" name="name" :class="errors.name ? 'is-invalid' : ''">
                        <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="text" class="form-control" id="phone" name="phone" :class="errors.phone ? 'is-invalid' : ''">
                        <div :class="errors.phone ? 'invalid-feedback' : ''" v-for="error in errors.phone">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="service" class="form-label">Услуга</label>
                        <select class="form-select" name="service" id="service">
                            <option v-for="service in services" :value="service.id"> @{{service.title}} </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Примечание</label>
                        <textarea class="form-control" id="description" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                        <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                            @{{ error }}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" form="FormApplication" class="btn  btn-primary">Отправить</button>
            </div>
        </div>
    </div>
</div>

<script>
    const Application = {
        data() {
            return {
                errors: [],
                message: '',
                services: [],
            }
        },
        methods: {
            //---Получение услуг
            async GetServices() {
                const response = await fetch('{{route('ServiceGet')}}');
                const data = await response.json();
                this.services = data.all;
            },
            //---Оформление заявки
            async Arrange() {
                const form = document.querySelector('#FormApplication');
                const formData = new FormData(form);
                const response = await fetch('{{route('MakeAnApplication')}}', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    body: formData
                });
                if (response.status === 400) {
                    this.errors = await response.json();
                    setTimeout(()=>{
                        this.errors = []
                    }, 5000);
                };
                if (response.status === 200) {
                    this.message = await response.json();
                    setTimeout(()=>{this.message = null}, 20000);
                };
                console.log('оформить');
            }

        },
        mounted() {
            this.GetServices();
        }
    }
    Vue.createApp(Application).mount('#Application');
</script>
