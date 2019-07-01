@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col-lg-8 d-flex">
                <div class="col-lg-6 pl-0">
                    <div class="card card-small mb-4 pt-1">
                        <div class="card-header border-bottom text-left">
                            <h5 class="mb-0">Данные</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($result['status']))
                                <p style="color: red; font-size: 14px; text-align: center;">
                                    @if(@count($result['value']) > 0)
                                        @foreach($result['value'] as $key => $error_item)
                                            {{ $error_item }} <br>
                                        @endforeach
                                    @endif
                                </p>
                            @endif

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/auto-task-edit/{{$row->auto_task_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="auto_task_id" value="{{$row->auto_task_id}}">
                                <?
                                use App\Models\Status;
                                $status_list = Status::where("status_id","<",11)->get();
                                ?>
                                <div class="form-group">
                                    <label for="client-transporter-form-station">Этап</label>
                                    <select class="form-control" name="auto_task_status_id">
                                        <option value="0">Выберите этап</option>
                                        @if(@count($status_list) > 0)
                                            @foreach($status_list as $key => $status_item)
                                                <option value="{{$status_item['status_id']}}" @if($status_item['status_id'] == $row->auto_task_status_id) selected @endif >{{$status_item['status_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Срок задачи</label>
                                    <input type="text" name="auto_task_days" placeholder="" class="form-control" value="{{$row['auto_task_days']}}">
                                </div>

                                <div class="form-group">
                                    <label> Текст задачи</label>
                                    <textarea class="form-control" name="auto_task_text">{{$row['auto_task_text']}}</textarea>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->auto_task_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
