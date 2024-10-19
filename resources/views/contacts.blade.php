@extends('layout.app')
@section('title', 'Контакты')
@section('content')
        <div id="EmployeesFunctions">
            <!-- Основное контент -->
            <div class="container">
                <div class="row  mt-5">
                    <div class="col-12">
                        <h2 class="text-primary  text-center"> Контакты </h2>
                    </div>
                </div>
                <div class="row  mt-5">
                    <div class="col-7">
                            <iframe style="width: 100%; object-fit: cover" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2210.557848114807!2d43.855967377454945!3d56.35471107331297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4151d7b42950e321%3A0x6753ef7aaf59a70d!2z0YPQuy4g0JjRgdC_0L7Qu9C60L7QvNCwLCA2LCDQndC40LbQvdC40Lkg0J3QvtCy0LPQvtGA0L7QtCwg0J3QuNC20LXQs9C-0YDQvtC00YHQutCw0Y8g0L7QsdC7LiwgNjAzMDAz!5e0!3m2!1sru!2sru!4v1679270486267!5m2!1sru!2sru" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col-5">
                            <div class="col-12" style="display: flex; flex-direction: column; align-items: start; justify-content: start; border-left: 1px solid #0d6efd; border-right: 1px solid #0d6efd; padding: 20px">
                                @foreach($branches as $branch)
                                <div style="margin-bottom: 20px;">
                                    <p style="width: 100%; text-align: start; text-decoration: underline; font-size: 14px">Адрес: {{$branch->address}} </p>
                                    <p style="width: 100%; text-align: start; font-size: 14px">Режим работы: {{$branch->days}} с {{$branch->time_start}} до {{$branch->time_end}} </p>
                                </div>
                                @endforeach
                                    <button class="btn  btn-primary  col-6" data-bs-toggle="modal" data-bs-target="#Application">Отправить заявку</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layout.make_an_application')
@endsection
