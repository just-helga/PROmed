@extends('layout.app')

@section('title', 'Услуги')

@section('content')
    <div id="ServicePage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-primary">Услуги</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <button class="btn  btn-primary  col-12" data-bs-toggle="modal" data-bs-target="#AddModal">
                        Новая услуга
                    </button>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Специализация</th>
                            <th scope="col">Название</th>
                            <th scope="col">Цена</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(service, index) in services" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ service.category.title }} </td>
                            <td> @{{ service.title }} </td>
                            <td> @{{ service.price }} ₽ </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <a :href="`{{route('ServiceMorePage')}}/${service.id}`" type="button" class="btn  btn-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="zondicons:view-show" style="color: white;" width="20" height="20"></iconify-icon>
                                    </a>
                                    <button type="button" class="btn  btn-success" @click="RenderModalEdit(service.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="mdi:lead-pencil" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-danger" @click="RenderModalDelete(service.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
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
                        <h5 class="modal-title" id="AddModalLabel">Добавление услуги</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAdd" enctype="multipart/form-data" @submit.prevent="Add">
                            <div class="mb-3">
                                <label for="title" class="form-label">Название</label>
                                <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Цена</label>
                                <input type="text" class="form-control" id="price" name="price" :class="errors.price ? 'is-invalid' : ''">
                                <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control" id="description" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Специализация</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div>
                                <label for="img" class="form-label">Изображение</label>
                                <input type="file" class="form-control" id="img" name="img" :class="errors.img ? 'is-invalid' : ''">
                                <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                                    @{{ error }}
                                </div>
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
                        <h5 class="modal-title" id="DeleteModalLabel">Удаление услуги</h5>
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
                                <label for="EditModalInputTitle" class="form-label">Название</label>
                                <input type="text" class="form-control" id="EditModalInputTitle" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputPrice" class="form-label">Цена</label>
                                <input type="text" class="form-control" id="EditModalInputPrice" name="price" :class="errors.price ? 'is-invalid' : ''">
                                <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalTextareaDescription" class="form-label">Описание</label>
                                <textarea class="form-control" id="EditModalTextareaDescription" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalSelectCategory" class="form-label">Специализация</label>
                                <select class="form-select" name="category_id" id="EditModalSelectCategory">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div>
                                <label for="EditModalInputImg" class="form-label">Изображение</label>
                                <input type="file" class="form-control" id="EditModalInputImg" name="img" :class="errors.img ? 'is-invalid' : ''">
                                <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                                    @{{ error }}
                                </div>
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
        const ServiceFunctions = {
            data() {
                return {
                    categories: [],
                    services: [],

                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение категорий
                async GetCategories() {
                    const response = await fetch('{{route('CategoryGet')}}');
                    const data = await response.json();
                    this.categories = data.all;
                },
                //---Получение услуг
                async GetServices() {
                    const response = await fetch('{{route('ServiceGet')}}');
                    const data = await response.json();
                    this.services = data.all;
                },
                //---Добавление новой услуги
                async Add() {
                    const form = document.querySelector('#FormAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('ServiceAdd')}}', {
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
                    var title = this.services.find(service => service.id === id).title;
                    document.getElementById('DeleteModalBody').innerText = 'Вы уверены, что хотите удалить услугу "' + title + '"';
                    this.active = this.services.find(service => service.id === id).id;
                },
                //---Удаление товара
                async Delete() {
                    const response = await fetch('{{route('ServiceDelete')}}', {
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
                    var title = this.services.find(service => service.id === id).title;
                    document.getElementById('EditModalLabel').innerText = 'Редактирование услуги "' + title + '"';
                    document.getElementById('EditModalInputTitle').value = title;
                    document.getElementById('EditModalInputPrice').value = this.services.find(service => service.id === id).price;
                    document.getElementById('EditModalTextareaDescription').value = this.services.find(service => service.id === id).description;
                    document.getElementById('EditModalSelectCategory').value = this.services.find(service => service.id === id).category_id;
                    this.active = this.services.find(service => service.id === id).id;
                },
                //---Редактирование товара
                async Edit() {
                    const form = document.querySelector('#FormEdit');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('ServiceEdit')}}', {
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
                this.GetServices();
                this.GetCategories();
            }
        }
        Vue.createApp(ServiceFunctions).mount('#ServicePage');
    </script>
@endsection
