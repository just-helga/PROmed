@extends('layout.app')

@section('title')
    {{$service->title}}
@endsection

@section('content')
    <div id="ServicePage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-primary"> {{$service->title}} </h2>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-4" style="display: flex; flex-direction: column; align-items: start; justify-content: start">
                    <div style="width: 100%; height: auto; overflow: hidden">
                        <img src="{{$service->img}}" alt="{{$service->title}}" style="width: 100%; height: auto; object-fit: cover">
                    </div>
                    <button class="btn btn-primary col-12" type="button" data-bs-toggle="collapse" style="margin-top: 20px;" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Специалисты</button>
                    <div class="col-12" style="margin-top: 10px">
                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                            <div class="card card-body">
                                @foreach($employees as $employee)
                                    <a class="dropdown-item" href="{{route('EmployeeMorePage', ['employee'=>$employee])}}" style="width: 100%; color: #0d6efd; text-align: end; font-size: 14px">{{$employee->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button class="btn  btn-primary" data-bs-toggle="modal" data-bs-target="#Application" style="width: 100%; margin-top: 10px">Отправить заявку</button>
                    <p class="text-primary" style="font-weight: bold; width: 100%; text-align: end; font-size: 18px; margin-bottom: 0 !important; margin-top: 10px;">Цена: {{$service->price}} ₽ </p>
                </div>
                <div class="col-8" style="display: flex; flex-direction: column; align-items: start; justify-content: start; border-left: 1px solid #0d6efd; border-right: 1px solid #0d6efd; padding: 0 20px">
                    <p style="width: 100%; text-align: start; text-decoration: underline; font-size: 14px">Специализация: {{$service->category->title}} </p>
                    <pre style="text-align: justify; white-space: pre-line; font-size: 14px"> {{$service->description}} </pre>
                </div>
            </div>
        </div>
    </div>

    @include('layout.make_an_application')

{{--    <script>--}}
{{--        const ServiceFunctions = {--}}
{{--            data() {--}}
{{--                return {--}}

{{--                }--}}
{{--            },--}}
{{--            methods: {--}}

{{--            },--}}
{{--            mounted() {--}}

{{--            }--}}
{{--        }--}}
{{--        Vue.createApp(ServiceFunctions).mount('#ServicePage');--}}
{{--    </script>--}}
@endsection
