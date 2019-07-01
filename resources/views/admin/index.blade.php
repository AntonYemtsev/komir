@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Дешборд для руководителя</span>
                {{--<h3 class="page-title">Аналитика</h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Small Stats Blocks -->

        <div class="row">
            <!-- Users Stats -->
            <div class="col-lg-7 col-md-12 col-sm-12 mb-4">
                <div class="card card-small" style="height: 94.45%">
                    <div class="card-header border-bottom">
                        <h5 class="m-0">Продажи</h5>
                    </div>
                    <div class="card-body pt-0">
                        <canvas height="130" style="max-width: 100% !important;" class="blog-overview-users"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 mb-4">
                <div class="row">
                    <div class="col-md-6 col-sm-6 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">ПРОДАЖИ</span>
                                        <h6 class="stats-small__value count my-3">10 000 000</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ПРОГНОЗ В ТЕНГЕ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">ПРЕДЛОЖЕНИЯ (КП)</span>
                                        <h6 class="stats-small__value count my-3">21 / 15</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ВСЕГО / ОТПРАВЛЕНО</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">ПРОДАЖИ</span>
                                        <h6 class="stats-small__value count my-3">6 000 000</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ФАКТ В ТЕНГЕ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">СДЕЛКИ</span>
                                        <h6 class="stats-small__value count my-3">41 / 30</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ВСЕГО / ВЫПОЛНЕНО</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">ПРОДАЖИ УГЛЯ</span>
                                        <h6 class="stats-small__value count my-3">123</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ОБЪЕМ В ТОННАХ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-4">
                        <div class="stats-small py-3 stats-small--1 card card-small">
                            <div class="card-body p-0 d-flex">
                                <div class="d-flex flex-column m-auto">
                                    <div class="stats-small__data text-center">
                                        <span class="stats-small__label text-uppercase">ЗАДАЧИ</span>
                                        <h6 class="stats-small__value count my-3">112 / 20</h6>
                                    </div>
                                    <div class="stats-small__data">
                                        <span class="stats-small__percentage">ВСЕГО / ВЫПОЛНЕНО</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Users Stats -->
            <div class="col-lg-7 col-md-12 col-sm-12 mb-4">
                <div class="card card-small" style="height: 94.45%">
                    <div class="card-header border-bottom">
                        <h5 class="m-0">Продажи</h5>
                    </div>
                    <div class="card-body pt-0 px-0">
                        <table class="table mb-0 clients-table">
                            <thead class="">
                            <tr>
                                <th scope="col" class="border-0">Менеджер<br><span class="font-weight-normal">&nbsp;</span></th>
                                <th scope="col" class="border-0">Дата начала<br><span class="font-weight-normal">Время</span></th>
                                <th scope="col" class="border-0">Сделка<br><span class="font-weight-normal">Клиент</span></th>
                                <th scope="col" class="border-0">Статус<br><span class="font-weight-normal">&nbsp;</span></th>
                                <th scope="col" class="border-0 text-right">Сумма<br><span class="font-weight-normal">Оплачено</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><span class="font-weight-bold">Ильдос</span><br><span class="font-weight-normal">Какимжанов</span></td>
                                <td><span class="font-weight-bold">19.01.2019</span><br><span class="font-weight-normal">18:30</span></td>
                                <td><span class="font-weight-bold">Проект 12345</span><br><span class="font-weight-normal">Компания 123</span></td>
                                <td>
                                    <div class="pb-1 text-center text-white" style="background-color: #EA5876">
                                        Заявка
                                    </div>
                                </td>
                                <td class="text-right"><span class="font-weight-bold">10 000 000</span><br><span class="font-weight-normal">0</span></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 mb-4">
                <div class="card card-small h-100">
                    <div class="card-header border-bottom">
                        <h6 class="m-0">Продажи по типу угля</h6>
                    </div>
                    <div class="card-body d-flex py-0">
                        <canvas height="220" class="blog-users-by-device m-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection