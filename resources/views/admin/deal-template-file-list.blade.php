@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Шаблоны файлов сделки</h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header d-flex border-bottom no-gutters">
                        <div class="col-12 col-sm-6">
                            <a href="/admin/deal-template-file-edit/0">
                                <button type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Добавить новый шаблон</button>
                            </a>
                            <br>
                            <form id="deal_dogovor_file_form" method="post" enctype="multipart/form-data" style="display: contents;">
                                <input type="file" style="display: none;" id="deal_dogovor_file" name="deal_dogovor_file">
                                <button type="button" onclick="showDealDogovorForm()" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Загрузить шаблон договора</button>
                                <a href="/file_template/dogovor_filetemplate.docx" target="_blank">
                                    dogovor_filetemplate.docx
                                </a>
                            </form>
                            <script>
                                function showDealDogovorForm(){
                                    $("#deal_dogovor_file").click();
                                }
                                $(document).ready(function(){
                                    $('#deal_dogovor_file').change(function(event){
                                        event.preventDefault();

                                        //grab all form data
                                        var formData = new FormData($("#deal_dogovor_file_form")[0]);

                                        $.ajax({
                                            url:'/admin/upload-deal-dogovor-file',
                                            type: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN':  CSRF_TOKEN
                                            },
                                            data: formData,
                                            async: false,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            success: function (data) {
                                                if(data.result == true){
                                                    Notify("Файл успешно обновлен", null, null, 'success');
                                                   document.getElementById("deal_dogovor_file_form").reset();
                                                }
                                                else if(data.result == false){
                                                    Notify("Ошибка при загрузке файла договора", null, null, 'danger');
                                                }
                                            }
                                        });
                                    });
                                })
                            </script>
                        </div>
                    </div>

                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0 clients-table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">Тип шаблона файла</th>
                                <th scope="col" class="border-0">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                                @if(@count($row) > 0)
                                    @foreach($row as $key => $deal_template_file_item)
                                        
                                        <tr>
                                            <td>{{$loop->index}}</td>
                                            <td>
                                                @if($deal_template_file_item['deal_template_type_id'] == 1)
                                                    Коммерческое предложение
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 2)
                                                    Счет на оплату
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 3)
                                                    Приложение №3
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 4)
                                                    Email "КП"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 5)
                                                    Email "Счет на оплату"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 6)
                                                    Email "Заявка разрезу"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 7)
                                                    Email "Комментарии по отгрузке"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 8)
                                                    Email "Комментарии по доставке"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 9)
                                                    Счет на закрытие
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 10)
                                                    Email "Счет на закрытие"
                                                @elseif($deal_template_file_item['deal_template_type_id'] == 11)
                                                    Email "Договор"
                                                @endif
                                            </td>
                                            <td>
                                                <div class="clients-table__actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="/admin/deal-template-file-edit/{{$deal_template_file_item->deal_template_file_id}}">
                                                            <button type="button" class="btn btn-white">
                                                              <span class="text-light">
                                                                <i class="material-icons">more_vert</i>
                                                              </span> Изменить
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-white" onclick="deleteDealTemplateFile({{$deal_template_file_item->deal_template_file_id}},this)">
                                                          <span class="text-danger">
                                                            <i class="material-icons">clear</i>
                                                          </span> Удалить
                                                        </button>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        function deleteDealTemplateFile(deal_template_file_id,ob){
            if (!confirm('Вы действительно хотите удалить шаблон файла №' + deal_template_file_id +'?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-template-file",
                data: {_token: CSRF_TOKEN, deal_template_file_id: deal_template_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении шаблона файла", null, null, 'danger');
                    }
                    else{
                        Notify("Шаблон файла #" + deal_template_file_id + " удален", null, null, 'success');
                        $(ob).closest("tr").remove();
                    }
                }
            });
        }
    </script>

@endsection

