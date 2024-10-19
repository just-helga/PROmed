@extends('layout.app')
@section('title', 'Главная')
@section('content')
    <div id="carouselExampleCaptions" class="carousel  slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item  active" style="background-size: cover; height: 90vh">
                <img src="{{asset('public/image/1.jpg')}}" class="d-block  w-100  h-100  img-fluid" style="object-fit: cover; filter: brightness(40%)" alt="">
                <div class="carousel-caption  d-none  d-md-block" style="font-size: 18px; margin-bottom: 50px;">
                    <h5 style="font-size: 28px;">О нас:</h5>
                    <p>Мы развиваемся, совершенствуем сервис, приобретаем новейшее оборудование</p>
                    <p>и стараемся следовать современным тенденциям. </p>
                    <p>Этот процесс изменений затронул и наш бренд.</p>
                    <p>Теперь сеть медицинских центров «СОЛО» преобразилась в сеть медицинских центров «PROmed».</p>
                    <button class="btn  btn-primary  col-4" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                </div>
            </div>
            <div class="carousel-item" style="background-size: cover; height: 90vh">
                <img src="{{asset('public/image/2.jpg')}}" class="d-block  w-100  h-100  img-fluid" style="object-fit: cover; filter: brightness(40%)" alt="">
                <div class="carousel-caption  d-none  d-md-block" style="font-size: 18px; margin-bottom: 50px;">
                    <h5 style="font-size: 28px;">Немного нашей истории в цифрах и фактах:</h5>
                    <p>10 лет успешной медицинской практики</p>
                    <p>более 200 высококвалифицированных врачей в штате</p>
                    <p>6 медицинских центров в Нижегородской области</p>
                    <p>2 730 квадратных метров - общая площадь всех клиник</p>
                    <button class="btn  btn-primary  col-4" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                </div>
            </div>
            <div class="carousel-item" style="background-size: cover; height: 90vh">
                <img src="{{asset('public/image/3.jpg')}}" class="d-block  w-100  h-100  img-fluid" style="object-fit: cover; filter: brightness(40%)" alt="">
                <div class="carousel-caption  d-none  d-md-block" style="font-size: 18px; margin-bottom: 50px;">
                    <h5 style="font-size: 28px;">Немного нашей истории в цифрах и фактах:</h5>
                    <p>более 500 000 довольных пациентов за все время</p>
                    <p>больше 1 500 000 оказанных услуг</p>
                    <p>более 200 единиц современного медицинского оборудования</p>
                    <p>более 2000 услуг - от забора крови до оперативных вмешательств</p>
                    <button class="btn  btn-primary  col-4" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container">
        <div class="block">
            <div class="row  mt-5  mb-5">
                <h2 class="text-primary  col-12">Наши преимущества</h2>
            </div>
            <div class="row">
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">Мы назначаем только то, что необходимо пациенту, у наших врачей нет и никогда не будет планов продаж.</p>
                </div>
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">В наших клиниках демократичные цены.</p>
                </div>
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">Наши клиники представлены в маленьких городах Нижегородской области.</p>
                </div>
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">Мы предлагаем выгодные условия работы для врачей.</p>
                </div>
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">Качество сервиса на высшем уровне.</p>
                </div>
                <div class="col-4  mb-5" style="display: flex; flex-direction: row; align-items: center; justify-content: start">
                    <iconify-icon icon="material-symbols:check-box-rounded" style="color: #0d6efd;" width="50"></iconify-icon>
                    <p style="font-size: 14px; margin: 0; margin-left: 20px;">Мы очень тщательно отбираем квалифицированных врачей.</p>
                </div>
            </div>
        </div>
        <div class="block  mb-5">
            <div class="row  mt-5  mb-5">
                <h2 class="text-primary  col-12">Наши сотрудники</h2>
            </div>
            <div class="row">
                @foreach($employees as $employee)
                            <a href="{{route('EmployeeMorePage', ['employee'=>$employee])}}" class="col-12  col-sm-6  col-md-4  col-xl-3" style="text-decoration: none; color: #212529">
                                <div class="card  product-card" style="margin-bottom: 24px;">
                                    <div style="height: 290px; overflow: hidden">
                                        <img src="{{$employee->img}}" class="card-img-top  product-card__img" alt="{{$employee->name}}" style="height: 100%; object-fit: cover">
                                    </div>
                                    <div class="card-body" style="display: flex; align-items: flex-start; justify-content: space-between; flex-direction: column">
                                        <p class="card-text" style="width: 100%; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"><span style="text-decoration: underline">Специализация:</span> {{$employee->category->title}} </p>
                                        <h5 class="card-title" style="width: 100%; min-height: 48px; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"> {{$employee->name}} </h5>
                                    </div>
                                </div>
                            </a>
                @endforeach
            </div>
            <div class="row  justify-content-center">
                <a href="{{route('EmployeeList')}}" class="btn  btn-primary  col-3">Показать всех</a>
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
@endsection
