@extends('layout.app')

@section('title', 'Специалисты')

@section('content')
    <div id="EmployeePage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-primary">Специалисты</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <button class="btn  btn-primary  col-12" data-bs-toggle="modal" data-bs-target="#AddModal">
                        Новый специалист
                    </button>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Специализация</th>
                            <th scope="col">Место работы</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(employee, index) in employees" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ employee.name }} </td>
                            <td> @{{ employee.category.title }} </td>
                            <td> @{{ employee.branch.address }} </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <a :href="`{{route('EmployeeMorePage')}}/${employee.id}`" type="button" class="btn  btn-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="zondicons:view-show" style="color: white;" width="20" height="20"></iconify-icon>
                                    </a>
                                    <button type="button" class="btn  btn-success" @click="RenderModalEdit(employee.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="mdi:lead-pencil" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-danger" @click="RenderModalDelete(employee.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                        <iconify-icon icon="material-symbols:delete" style="color: white;" width="20"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Модальное окно добавления -->
        <div class="modal  fade" id="AddModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModalLabel">Добавление специалиста</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAdd" enctype="multipart/form-data" @submit.prevent="Add">
                            <div class="mb-3">
                                <label for="name" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="name" name="name" :class="errors.name ? 'is-invalid' : ''">
                                <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Специализация</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control" id="description" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                            <div>
                                <label for="img" class="form-label">Изображение</label>
                                <input type="file" class="form-control" id="img" name="img" :class="errors.img ? 'is-invalid' : ''">
                                <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Место работы</label>
                                <select class="form-select" name="branch_id" id="branch_id">
                                    <option v-for="branch in branches" :value="branch.id"> @{{branch.address}} </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormAdd" class="btn  btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно удаления -->
        <div class="modal  fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteModalLabel">Удаление специалиста</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body" id="DeleteModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button @click="Delete" class="btn  btn-primary">Удалить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно редактирования -->
        <div class="modal  fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormEdit" enctype="multipart/form-data" @submit.prevent="Edit">
                            <div class="mb-3">
                                <label for="EditModalInputTitle" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="EditModalInputTitle" name="name" :class="errors.name ? 'is-invalid' : ''">
                                <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalSelectCategory" class="form-label">Специализация</label>
                                <select class="form-select" name="category_id" id="EditModalSelectCategory">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalTextareaDescription" class="form-label">Описание</label>
                                <textarea class="form-control" id="EditModalTextareaDescription" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                            <div>
                                <label for="EditModalInputImg" class="form-label">Изображение</label>
                                <input type="file" class="form-control" id="EditModalInputImg" name="img" :class="errors.img ? 'is-invalid' : ''">
                                <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalSelectBranch" class="form-label">Место работы</label>
                                <select class="form-select" name="branch_id" id="EditModalSelectBranch">
                                    <option v-for="branch in branches" :value="branch.id"> @{{branch.address}} </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormEdit" class="btn  btn-primary">Сохранить</button>
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
                    branches: [],
                    categories: [],

                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение филиалов
                async GetBranches() {
                    const response = await fetch('{{route('BranchGet')}}');
                    const data = await response.json();
                    this.branches = data.all;
                },
                //---Получение категорий
                async GetCategories() {
                    const response = await fetch('{{route('CategoryGet')}}');
                    const data = await response.json();
                    this.categories = data.all;
                },
                //---Получение сотрудников
                async GetEmployees() {
                    const response = await fetch('{{route('EmployeeGet')}}');
                    const data = await response.json();
                    this.employees = data.all;
                },
                //---Добавление нового сотрудника
                async Add() {
                    const form = document.querySelector('#FormAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('EmployeeAdd')}}', {
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
                        window.location = response.url;
                    };
                },
                //---Отрисовка модального окна удаления
                RenderModalDelete(id) {
                    var name = this.employees.find(employee => employee.id === id).name;
                    document.getElementById('DeleteModalBody').innerText = 'Вы уверены, что хотите удалить специалиста "' + name + '"';
                    this.active = this.employees.find(employee => employee.id === id).id;
                },
                //---Удаление сотрудника
                async Delete() {
                    const response = await fetch('{{route('EmployeeDelete')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({id:this.active})
                    });
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
                //---Отрисовка модального окна редактирования
                RenderModalEdit(id) {
                    var name = this.employees.find(employee => employee.id === id).name;
                    document.getElementById('EditModalLabel').innerText = 'Редактирование специалиста "' + name + '"';
                    document.getElementById('EditModalInputTitle').value = name;
                    document.getElementById('EditModalTextareaDescription').value = this.employees.find(employee => employee.id === id).description;
                    document.getElementById('EditModalSelectCategory').value = this.employees.find(employee => employee.id === id).category_id;
                    document.getElementById('EditModalSelectBranch').value = this.employees.find(employee => employee.id === id).branch_id;
                    this.active = this.employees.find(employee => employee.id === id).id;
                },
                //---Редактирование сотрудника
                async Edit() {
                    const form = document.querySelector('#FormEdit');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('EmployeeEdit')}}', {
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
                }
            },
            mounted() {
                this.GetBranches();
                this.GetCategories();
                this.GetEmployees();
            }
        }
        Vue.createApp(EmployeeFunctions).mount('#EmployeePage');
    </script>
@endsection
