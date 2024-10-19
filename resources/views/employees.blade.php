@extends('layout.app')
@section('title', 'Наши специалисты')
@section('content')
    <div id="EmployeesFunctions">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-12">
                    <h2 class="text-primary  text-center"> Наши специалисты </h2>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="mb-5  col-12  col-md-4  col-xl-3">
                    <label for="">Выбрать фильтр</label>
                    <div class="col-12  mb-3">
                        <select class="form-select" v-model="category_id">
                            <option value="0">Выбрать специализацию</option>
                            <option v-for="category in categories" :value="category.id"> @{{ category.title }} </option>
                        </select>
                    </div>
                    <button class="btn  btn-primary  col-12  mb-2" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                </div>
                <div class="col-12  col-md-8  col-xl-9">
                    <div v-if="FilterEmployees.length > 0">
                        <div class="row">
                            <a :href="`{{route('EmployeeMorePage')}}/${employee.id}`" v-for="employee in FilterEmployees" class="col-12  col-sm-6  col-md-6  col-xl-4" style="text-decoration: none; color: #212529">
                                <div class="card  product-card" style="margin-bottom: 24px;">
                                    <div style="height: 290px; overflow: hidden">
                                        <img :src="employee.img" class="card-img-top  product-card__img" :alt="employee.name" style="height: 100%; object-fit: cover">
                                    </div>
                                    <div class="card-body" style="display: flex; align-items: flex-start; justify-content: space-between; flex-direction: column">
                                        <p class="card-text" style="width: 100%; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"><span style="text-decoration: underline">Специализация:</span> @{{employee.category.title}} </p>
                                        <h5 class="card-title" style="width: 100%; min-height: 48px; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"> @{{employee.name}} </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <p v-else style="font-size: 24px">К сожалению, подходящих услуг не найдено</p>
                </div>
            </div>
        </div>

    </div>

    <style>
        .product-card {
            cursor: pointer;
        }
        .product-card__img {
            transition: .3s;
        }
        .product-card:hover .product-card__img {
            transform: scale(1.03);
        }
    </style>

    @include('layout.make_an_application')

    <script>
        function equalHeight(group) {
            var tallest = 0;
            group.each(function() {
                thisHeight = $(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
        $(document).ready(function(){
            equalHeight($(".card"));
        });
    </script>

    <script>
        const EmployeesFunctions = {
            data() {
                return {
                    categories: [],
                    employees: [],

                    category_id: 0,

                    message: ''
                }
            },
            methods: {
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
            },
            computed: {
                FilterEmployees() {
                    return this.employees
                        .filter(employee => {
                            return this.category_id == 0 || employee.category_id == this.category_id;
                        })
                }
            },
            mounted() {
                this.GetCategories();
                this.GetEmployees();
            }
        }
        Vue.createApp(EmployeesFunctions).mount('#EmployeesFunctions');
    </script>
@endsection

