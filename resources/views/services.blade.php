@extends('layout.app')
@section('title', 'Наши услуги')
@section('content')
    <div id="ServicesFunctions">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-12">
                    <h2 class="text-primary  text-center"> Наши услуги </h2>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="mb-5  col-12  col-md-4  col-xl-3">
                        <div class="col-12  mb-3">
                            <select class="form-select" name="" id="sorted" v-model="sorted">
                                <option value="created_at" selected>Сначала новые</option>
                                <option value="cheap">Сначала дешевые</option>
                                <option value="expensive">Сначала дорогие</option>
                            </select>
                        </div>
                        <div class="col-12  mb-3">
                            <select class="form-select" v-model="category_id">
                                <option value="0">Выбрать специализацию</option>
                                <option v-for="category in categories" :value="category.id"> @{{ category.title }} </option>
                            </select>
                        </div>
                    <button class="btn  btn-primary  col-12  mb-2" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                </div>
                <div class="col-12  col-md-8  col-xl-9">
                    <div v-if="FilterServices.length > 0">
                        <div class="row">
                            <a :href="`{{route('ServiceMorePage')}}/${service.id}`" v-for="service in FilterServices" class="col-12  col-sm-6  col-md-6  col-xl-4" style="text-decoration: none; color: #212529">
                                <div class="card  product-card" style="margin-bottom: 24px;">
                                    <div style="height: 290px; overflow: hidden">
                                        <img :src="service.img" class="card-img-top  product-card__img" :alt="service.title" style="height: 100%; object-fit: cover">
                                    </div>
                                    <div class="card-body" style="display: flex; align-items: flex-start; justify-content: space-between; flex-direction: column">
                                        <p class="card-text" style="width: 100%; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"><span style="text-decoration: underline">Специализация:</span> @{{service.category.title}} </p>
                                        <h5 class="card-title" style="width: 100%; min-height: 48px; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"> @{{service.title}} </h5>
                                        <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; flex-direction: row">
                                            <p class="card-text" style="font-weight: bold; margin: 0; margin-right: 20px;"> @{{service.price}} ₽ </p>
                                        </div>
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

    @include('layout.make_an_application')

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
        const ServicesFunctions = {
            data() {
                return {
                    categories: [],
                    services: [],

                    category_id: 0,
                    sorted: 'created_at',

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
                //---Получение услуг
                async GetServices() {
                    const response = await fetch('{{route('ServiceGet')}}');
                    const data = await response.json();
                    this.services = data.all;
                },
            },
            computed: {
                FilterServices() {
                    return this.services
                        .filter(service => {
                            return this.category_id == 0 || service.category_id == this.category_id;
                        })
                        .sort((a, b) => {
                            if (this.sorted === 'expensive') {
                                if (a['price'] > b['price']) return -1
                                if (a['price'] < b['price']) return 1
                                if (a['price'] = b['price']) return 0
                            }
                            if (this.sorted === 'cheap') {
                                if (a['price'] > b['price']) return 1
                                if (a['price'] < b['price']) return -1
                                if (a['price'] = b['price']) return 0
                            }
                        })
                }
            },
            mounted() {
                if (sessionStorage.getItem('category_id') !== null) {
                    this.category_id = sessionStorage.getItem('category_id');
                }
                this.GetCategories();
                this.GetServices();
                sessionStorage.removeItem('category_id');
            }
        }
        Vue.createApp(ServicesFunctions).mount('#ServicesFunctions');
    </script>
@endsection

