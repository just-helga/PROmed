@extends('layout.app')

@section('title', 'Заявки')

@section('content')
    <div id="EmployeePage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-primary">Заявки</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <div class="col-12  mb-2">
                        <select class="form-select" v-model="status">
                            <option value="0" selected="selected">Все заявки</option>
                            <option value="Новая">Новые</option>
                            <option value="Подтвержденная">Подтвержденные</option>
                            <option value="Отмененная">Отмененные</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Дата и время создания</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Услуга</th>
                            <th scope="col">Статус</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(application, index) in FilterApplications" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ application.created_at }} </td>
                            <td> @{{ application.name }} </td>
                            <td> @{{ application.phone }} </td>
                            <td> @{{ application.service.title }} </td>
                            <td> @{{ application.status }} </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <button type="button" class="btn  btn-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;" @click="RenderModalShow(application.id)" data-bs-toggle="modal" data-bs-target="#ShowModal">
                                        <iconify-icon icon="zondicons:view-show" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button v-if="application.status == 'Новая'" type="button" class="btn  btn-success" @click="ReceiveActiveElem(application.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="material-symbols:done-sharp" style="color: white;" width="25"></iconify-icon>
                                    </button>
                                    <button v-if="application.status == 'Новая'" type="button" class="btn  btn-danger" @click="ReceiveActiveElem(application.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                        <iconify-icon icon="radix-icons:cross-2" style="color: white;" width="25"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Модальное окно отмены заявки -->
        <div class="modal  fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteModalLabel">Отмена заявки</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <p id="DeleteModalBody"></p>
                        <form id="FormRefuse" enctype="multipart/form-data" @submit.prevent="Refuse">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Причина отмены</label>
                                <textarea class="form-control" id="comment" name="comment" :class="errors.comment ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.comment ? 'invalid-feedback' : ''" v-for="error in errors.comment">
                                    @{{ error }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button class="btn  btn-primary" form="FormRefuse" >Готово</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно подтверждения заявки -->
        <div class="modal  fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel">Подтверждение заявки</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div :class="message ? 'mb-3  alert  alert-danger  text-center' : ''" style="margin-left: 12px; margin-right: 12px; flex-shrink: inherit">@{{ message }}</div>
                        <form id="FormСonfirm" enctype="multipart/form-data" @submit.prevent="Сonfirm">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Специалист</label>
                                <select class="form-select" name="employee_id" id="employee_id">
                                    <option v-for="employee in employees_help" :value="employee.id"> @{{employee.name}} </option>
                                </select>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between">
                                <div class="mb-3  col-5">
                                    <label for="date" class="form-label">Дата</label>
                                    <input type="date" class="form-control" id="date" name="date" :class="errors.date ? 'is-invalid' : ''">
                                    <div :class="errors.date ? 'invalid-feedback' : ''" v-for="error in errors.date">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="mb-3  col-5">
                                    <label for="time" class="form-label">Время</label>
                                    <input type="time" class="form-control" id="time" name="time" :class="errors.time ? 'is-invalid' : ''">
                                    <div :class="errors.time ? 'invalid-feedback' : ''" v-for="error in errors.time">
                                        @{{ error }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormСonfirm" class="btn  btn-primary">Готово</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно просмотра -->
        <div class="modal  fade" id="ShowModal" tabindex="-1" aria-labelledby="ShowModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ShowModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body" id="ShowModalBody" style="display: flex; flex-direction: column; justify-content: start; align-items: center">
                        <div class="row">
                            <p style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-bottom: 10px;">ФИО: <span class="text-primary" id="ShowModalName"></span></p>
                            <p style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-bottom: 10px;">Телефон: <span class="text-primary" id="ShowModalPhone"></span></p>
                            <p style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-bottom: 10px;">Описание заявки: <span class="text-primary" id="ShowModalDescription"></span></p>
                            <p style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-bottom: 10px;">Услуга: <span class="text-primary" id="ShowModalService"></span></p>
                            <p style="border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-bottom: 10px;">Статус: <span class="text-primary" id="ShowModalStatus"></span></p>
                            <div id="Detail" style="display: flex; flex-direction: column; align-items: start; justify-content: start; width: 100%;">
                                <div id="СonfirmApplication" style="display: flex; flex-direction: column; align-items: start; justify-content: start; width: 100%;">
                                    <p style="border-bottom: 1px solid #dee2e6; width: 100%; padding-bottom: 5px; margin-bottom: 10px;">Дата: <span class="text-primary" id="ShowModalDate"></span></p>
                                    <p style="border-bottom: 1px solid #dee2e6; width: 100%; padding-bottom: 5px; margin-bottom: 10px;">Время: <span class="text-primary" id="ShowModalTime"></span></p>
                                    <p style="border-bottom: 1px solid #dee2e6; width: 100%; padding-bottom: 5px; margin-bottom: 10px;">Врач: <span class="text-primary" id="ShowModalEmployee"></span></p>
                                </div>
                                <div id="RefuseApplication" style="display: flex; flex-direction: column; align-items: start; justify-content: start; width: 100%;">
                                    <p style="border-bottom: 1px solid #dee2e6; width: 100%; padding-bottom: 5px; margin-bottom: 10px;">Причина отмены: <span class="text-primary" id="ShowModalComment"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const EmployeeFunctions = {
            data() {
                return {
                    employees: [],
                    employees_help: [],
                    applications: [],
                    services: [],

                    status: 0,

                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение заявок
                async GetApplication() {
                    const response = await fetch('{{route('ApplicationGet')}}');
                    const data = await response.json();
                    this.applications = data.all;
                },
                //---Получение сотрудников
                async GetEmployees() {
                    const response = await fetch('{{route('EmployeeGet')}}');
                    const data = await response.json();
                    this.employees = data.all;
                    this.employees_help = this.employees;
                },
                //---Получение услуг
                async GetServices() {
                    const response = await fetch('{{route('ServiceGet')}}');
                    const data = await response.json();
                    this.services = data.all;
                },
                //---Получение id
                ReceiveActiveElem(id) {
                    this.employees_help = this.employees;

                    var service_id = this.applications.find(application => application.id === id).service_id;
                    var category_id = this.services.find(service => service.id === service_id).category_id;
                    this.employees_help = this.employees.filter(employee => {
                        return employee.category_id == category_id;
                    })

                    this.active = this.employees.find(employee => employee.id === id).id;
                },
                //---Отмена заявки
                async Refuse() {
                    const form = document.querySelector('#FormRefuse');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('ApplicationRefuse')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        }, 5000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                },
                //---Подтверждение заявки
                async Сonfirm() {
                    const form = document.querySelector('#FormСonfirm');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('ApplicationСonfirm')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        }, 5000);
                    }
                    if (response.status === 403) {
                        this.message = await response.json();
                        setTimeout(()=>{this.message = null}, 20000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                },
                //---Отрисовка модального окна просмотра
                RenderModalShow(id) {
                    var status = this.applications.find(application => application.id === id).status;

                    document.getElementById('ShowModalName').innerText = this.applications.find(application => application.id === id).name;
                    document.getElementById('ShowModalPhone').innerText = this.applications.find(application => application.id === id).phone;
                    document.getElementById('ShowModalDescription').innerText = this.applications.find(application => application.id === id).description;
                    document.getElementById('ShowModalStatus').innerText = this.applications.find(application => application.id === id).status;
                    document.getElementById('ShowModalService').innerText = this.services.find(service => service.id === (this.applications.find(application => application.id === id).service_id)).title;
                    if(status == 'Новая') {
                        document.getElementById('Detail').style.display = 'none';
                    } else {
                        document.getElementById('Detail').style.display = 'flex';
                        if(status == 'Подтвержденная') {
                            document.getElementById('СonfirmApplication').style.display = 'flex';
                            document.getElementById('RefuseApplication').style.display = 'none';
                            document.getElementById('ShowModalDate').innerText = this.applications.find(application => application.id === id).date;
                            document.getElementById('ShowModalTime').innerText = this.applications.find(application => application.id === id).time;
                            document.getElementById('ShowModalEmployee').innerText = this.employees.find(employee => employee.id === (this.applications.find(application => application.id === id).employee_id)).name;
                        } else {
                            document.getElementById('СonfirmApplication').style.display = 'none';
                            document.getElementById('RefuseApplication').style.display = 'flex';
                            document.getElementById('ShowModalComment').innerText = this.applications.find(application => application.id === id).comment;
                        }
                    }
                },
            },
            computed: {
                FilterApplications() {
                    return this.applications
                        .filter(application => {
                            return this.status == 0 || application.status == this.status;
                        })
                }
            },
            mounted() {
                this.GetEmployees();
                this.GetApplication();
                this.GetServices();
            }
        }
        Vue.createApp(EmployeeFunctions).mount('#EmployeePage');
    </script>
@endsection
