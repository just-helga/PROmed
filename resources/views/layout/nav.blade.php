<div id="Nav">
    {{--Шапка--}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-primary">
    <div class="container  container-fluid">
        <a class="navbar-brand" href="{{route('MainPage')}}">PROmed</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: auto !important; margin-right: auto !important;">
                <li class="nav-item" style="margin: 0 20px">
                    <a class="nav-link text-white" aria-current="page" href="{{route('MainPage')}}">Главная</a>
                </li>
                <li class="nav-item dropdown" style="margin: 0 20px">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Услуги
                    </a>
                    <ul class="dropdown-menu" style="left: -6.875rem; margin-top: 1.05rem; text-align: right">
                        <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #0d6efd;" @click="RedirectServices(0)">Все услуги</a></li>
                        <li v-for="category in categories"><a class="dropdown-item" href="#" style="border-bottom: 1px solid #0d6efd;" @click="RedirectServices(category.id)">@{{ category.title }}</a></li>
                    </ul>
                </li>
                <li class="nav-item" style="margin: 0 20px">
                    <a class="nav-link text-white" aria-current="page" href="{{route('EmployeeList')}}">Специалисты</a>
                </li>
                <li class="nav-item" style="margin: 0 20px">
                    <a class="nav-link text-white" aria-current="page" href="{{route('ContactsPage')}}">Контакты</a>
                </li>
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-right: 0 !important;">
                @auth()
                    @if(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 20 20"><path fill="white" d="M16.68 9.77a4.543 4.543 0 0 1-4.95.99l-5.41 6.52c-.99.99-2.59.99-3.58 0s-.99-2.59 0-3.57l6.52-5.42c-.68-1.65-.35-3.61.99-4.95c1.28-1.28 3.12-1.62 4.72-1.06l-2.89 2.89l2.82 2.82l2.86-2.87c.53 1.58.18 3.39-1.08 4.65zM3.81 16.21c.4.39 1.04.39 1.43 0c.4-.4.4-1.04 0-1.43c-.39-.4-1.03-.4-1.43 0a1.02 1.02 0 0 0 0 1.43z"/></svg>
                            </a>
                            <ul class="dropdown-menu" style="left: -6.875rem; margin-top: 0.55rem; text-align: right">
                                <li><a class="dropdown-item" href="{{route('CategoryPage')}}" style="border-bottom: 1px solid #0d6efd;">Специализация</a></li>
                                <li><a class="dropdown-item" href="{{route('ServicePage')}}" style="border-bottom: 1px solid #0d6efd;">Услуги</a></li>
                                <li><a class="dropdown-item" href="{{route('BranchPage')}}" style="border-bottom: 1px solid #0d6efd;">Филиалы</a></li>
                                <li><a class="dropdown-item" href="{{route('EmployeePage')}}" style="border-bottom: 1px solid #0d6efd;">Специалисты</a></li>
                                <li><a class="dropdown-item" href="{{route('ApplicationPage')}}" style="border-bottom: 1px solid #0d6efd;">Заявки</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
                    @guest()
                        <li class="nav-item" style="margin: 0 20px">
                            <a class="nav-link text-white" aria-current="page" href="{{route('login')}}">Вход</a>
                        </li>
                    @endguest
                    @auth()
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{route('Exit')}}">Выход</a>
                        </li>
                    @endauth
            </ul>
        </div>
    </div>
</nav>
</div>


<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>

<script>
    const Nav = {
        data() {
            return {
                categories: [],
            }
        },
        methods: {
            //---Получение категорий
            async GetCategories() {
                const response = await fetch('{{route('CategoryGet')}}');
                const data = await response.json();
                this.categories = data.all;
            },
            //---Редирект к каталогу услуг
            async RedirectServices(id) {
                if (id !== 0) {
                    sessionStorage.setItem('category_id', id);
                }
                const response = await fetch('{{route('ServicesList')}}');
                window.location = response.url;
            }
        },
        mounted() {
            this.GetCategories();
        }
    }
    Vue.createApp(Nav).mount('#Nav');
</script>

