<?php

namespace App\Http\Controllers\Admin;

use App\Models\AutoTask;
use App\Models\Bank;
use App\Models\Brand;
use App\Models\Client;
use App\Models\ClientAnswer;
use App\Models\Company;
use App\Models\Deal;
use App\Models\DealFile;
use App\Models\DealHistory;
use App\Models\DealTemplateFile;
use App\Models\Delivery;
use App\Models\DeliveryClientComment;
use App\Models\DeliveryComment;
use App\Models\Fraction;
use App\Models\Mark;
use App\Models\Payment;
use App\Models\Percent;
use App\Models\Region;
use App\Models\Role;
use App\Models\ShippingClientComment;
use App\Models\ShippingComment;
use App\Models\Station;
use App\Models\StationExport;
use App\Models\StationImport;
use App\Models\Status;
use App\Models\SystemInfo;
use App\Models\Task;
use App\Models\Timezone;
use App\Models\UserTask;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers;
use Auth;
use Hash;
use Maatwebsite\Excel\Excel;
use Mail;
use DB;
use Symfony\Component\Yaml\Tests\B;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::check()){
            return redirect('/admin/index');
        }

        if(isset($request->email)){
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user_item = Users::where("email","=",$request->email)->first();
                if(@count($user_item) > 0){
                    $offset= strtotime("+6 hours 0 minutes");
                    $user_item->date_last_login = date("Y-m-d H:i:s", $offset);
                    $user_item->save();
                }

                return redirect('/admin/index');
            }
            else{
                return view('admin.login', [
                    'email' => $request->email,
                    'error' => 'Неправильный логин или пароль'
                ]);
            }
        }
        else{
            return view('admin.login', [
                'email' => '',
                'error' => 'Неправильный логин или пароль'
            ]);
        }
    }

    public function index(){
        if(!Auth::check()){
            return redirect('/login');
        }

        return view('admin.index');
    }

    public function cyr2lat ($text) {

        $cyr2lat_replacements = array (
            "А" => "a","Б" => "b","В" => "v","Г" => "g","Д" => "d",
            "Е" => "e","Ё" => "yo","Ж" => "dg","З" => "z","И" => "i",
            "Й" => "y","К" => "k","Л" => "l","М" => "m","Н" => "n",
            "О" => "o","П" => "p","Р" => "r","С" => "s","Т" => "t",
            "У" => "u","Ф" => "f","Х" => "kh","Ц" => "ts","Ч" => "ch",
            "Ш" => "sh","Щ" => "csh","Ъ" => "","Ы" => "i","Ь" => "",
            "Э" => "e","Ю" => "yu","Я" => "ya",

            "а" => "a","б" => "b","в" => "v","г" => "g","д" => "d",
            "е" => "e","ё" => "yo","ж" => "dg","з" => "z","и" => "i",
            "й" => "y","к" => "k","л" => "l","м" => "m","н" => "n",
            "о" => "o","п" => "p","р" => "r","с" => "s","т" => "t",
            "у" => "u","ф" => "f","х" => "kh","ц" => "ts","ч" => "ch",
            "ш" => "sh","щ" => "sch","ъ" => "","ы" => "y","ь" => "",
            "э" => "e","ю" => "yu","я" => "ya",
            "(" => "", ")" => "", "," => "", "." => "",

            "-" => "-"," " => "-", "+" => "", "®" => "", "«" => "", "»" => "", '"' => "", "`" => "", "&" => "", "#" => "", ":" => "", ";" => "", "/" => "", "?" => ""
        );
        $a = str_replace("---","-",strtolower (strtr (trim($text),$cyr2lat_replacements)));
        $b = str_replace("--","-",$a);
        return $b;
    }

    public function userList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Users::LeftJoin('roles','users.user_role_id','=','roles.role_id')
            ->select('users.*','roles.role_name');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where(function($query) use ($request)
            {
                $query->where("user_name","like","%" . $request->search_word . "%")->orWhere("user_surname","like","%" . $request->search_word . "%");
            });
        }
        $row = $row->paginate($row_count);
        return view('admin.user-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function userEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $user_id = $request->user_id;

        $row = Users::find($user_id);
        $role_list = Role::all();
        if(@count($row) < 1){
            $row = new Users();
            $row->user_id = 0;
        }
        return view('admin.user-edit', ['row' => $row, 'role_list' => $role_list]);
    }

    public function deleteUser(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $user_id = $request->user_id;
        $user_row = Users::find($user_id);
        if(@count($user_row) > 0){
            $this->deleteFile("user_photo",$user_row->image);
        }

        $result = Users::where('user_id', '=', $user_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveUser(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'user_surname.required' => 'Укажите Фамилию',
            'user_name.required' => 'Укажите Имя',
            'email.required' => 'Укажите Email',
            'email.email' => 'Неправильный формат Email'
        );
        $validator = Validator::make($request->all(), [
            'user_surname' => 'required',
            'user_name' => 'required',
            'email' => 'required|email'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.user-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        $is_new_user = 0;
        $rand_str = "";
        $old_file_name = "";
        if($request->user_id > 0) {
            $user_item = Users::find($request->user_id);
            $old_file_name = $user_item->image;
        }
        else {
            $user_item = new Users();
            $is_new_user = 1;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < 14; $i++) {
                $rand_str .= $characters[rand(0, strlen($characters) - 1)];
            }
            $user_item->password = Hash::make($rand_str);
        }

        if($request->hasFile('image')){
            $this->deleteFile("user_photo",$old_file_name);
            $file = $request->image;
            $file_name = time() . "_user.";
            $file_extension = $file->extension($file_name);
            $file_name = $file_name . $file_extension;
            Storage::disk('user_photo')->put($file_name,  File::get($file));
            $user_item->image = $file_name;
        }

        $user_item->user_surname = $request->user_surname;
        $user_item->user_name = $request->user_name;
        $user_item->user_phone = $request->user_phone;
        $user_item->email = $request->email;
        $user_item->user_role_id = $request->user_role_id;

        if($user_item->save()){
            if($is_new_user == 100){
                $email_to = $request->email;
                $message_str = 'Уважаемый (-ая), ' . $request->fio .'!<br>Ваш пароль для входа в личный кабинет: ' . $rand_str;
                Mail::send(['html' => 'admin.email'], ['text' => $message_str], function($message) use ($email_to)
                {
                    $message->to($email_to)->subject("Регистрация на сайте");
                });
            }
            return redirect('/admin/user-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.user-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function deleteFile($path,$old_file_name){
        if(strlen($old_file_name) > 0){
            if(Storage::disk($path)->has($old_file_name)){
                Storage::disk($path)->delete($old_file_name);
            }
        }
    }

    public function changePasswordEdit(){
        if(!Auth::check()){
            return redirect('/login');
        }

        return view('admin.change-password-edit');
    }

    public function changePassword(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'old_password.required' => 'Укажите старый пароль!',
            'new_password.required' => 'Укажите новый пароль!',
            'new_password.different' => 'Новый пароль совпадает со старым паролем!',
            'repeat_new_password.required' => 'Укажите повтор нового пароля!',
            'repeat_new_password.same' => 'Повтор пароля не совпадает!'
        );
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|different:old_password',
            'repeat_new_password' => 'required|same:new_password'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.change-password-edit', ['result' => $result ]);
        }

        $user = Users::where('user_id','=',Auth::user()->user_id)->first();
        $count = Hash::check($request->old_password, $user->password);
        if($count == false){
            $error[0] = "Неправильно указан старый пароль!";
            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.change-password-edit', ['result' => $result ]);
        }

        $user = Users::where('user_id','=',Auth::user()->user_id)->first();
        $user->password = Hash::make($request->new_password);
        $offset= strtotime("+6 hours 0 minutes");
        $user->password_changed_time = date("Y-m-d H:i:s", $offset);
        if($user->save()){
            $error[0] = "Пароль успешно изменен!";
            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.change-password-edit', ['result' => $result ]);
        }
        else{
            $error[0] = "Ошибка при изменени пароля!";
            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.change-password-edit', ['result' => $result ]);
        }
    }

    public function resetPassword(){
        if(!Auth::check()){
            return redirect('/login');
        }

        $email = "";
        $error = "";
        return view('admin.reset-password',['email' => $email, 'error' => $error]);
    }

    public function resetPasswordEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'reset_email.required' => 'Укажите Email!'
        );
        $validator = Validator::make($request->all(), [
            'reset_email' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return view('admin.reset-password',['email' => $request->reset_email, 'error' => $error[0]]);
        }

        $user = Users::where('email','=',$request->reset_email)->first();

        if(@count($user) > 0){
            $rand_str = "";
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < 14; $i++) {
                $rand_str .= $characters[rand(0, strlen($characters) - 1)];
            }
            $user->password = Hash::make($rand_str);
            $offset= strtotime("+6 hours 0 minutes");
            $user->password_changed_time = date("Y-m-d H:i:s",$offset);
            $user->save();

            $email_to = $request->reset_email;
            $message_str = 'Ваш новый пароль для входа в личный кабинет : ' . $rand_str;
            Mail::send(['html' => 'admin.email'], ['text' => $message_str], function($message) use ($email_to)
            {
                $message->to($email_to)->subject("Сброс пароля на сайте");
            });
            return view('admin.reset-password',['email' => $request->reset_email, 'error' => "Пароль успешно сброшен и отправлен на почту!"]);
        }
        else{
            return view('admin.reset-password',['email' => $request->reset_email, 'error' => "Пользователя с таким Email не существует!"]);
        }
    }


    public function regionList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Region::LeftJoin("brands","regions.region_brand_id","=","brands.brand_id")->select('regions.*','brands.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("region_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.region-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function regionEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $region_id = $request->region_id;

        $row = Region::find($region_id);
        if(@count($row) < 1){
            $row = new Region();
            $row->region_id = 0;
        }
        return view('admin.region-edit', ['row' => $row]);
    }

    public function deleteRegion(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $region_id = $request->region_id;
        $result = Region::where('region_id', '=', $region_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveRegion(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'region_name.required' => 'Укажите Область'
        );
        $validator = Validator::make($request->all(), [
            'region_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.region-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->region_id > 0) {
            $region_item = Region::find($request->region_id);
        }
        else {
            $region_item = new Region();
        }

        $region_item->region_name = $request->region_name;
        $region_item->region_price = $request->region_price;
        $region_item->region_price_nds = $request->region_price_nds;
        $region_item->region_brand_id = $request->region_brand_id;

        if($region_item->save()){
            return redirect('/admin/region-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.region-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function bankList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Bank::select('banks.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("bank_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.bank-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function bankEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $bank_id = $request->bank_id;

        $row = Bank::find($bank_id);
        if(@count($row) < 1){
            $row = new Bank();
            $row->bank_id = 0;
        }
        return view('admin.bank-edit', ['row' => $row]);
    }

    public function deleteBank(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $bank_id = $request->bank_id;
        $result = Bank::where('bank_id', '=', $bank_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveBank(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'bank_name.required' => 'Укажите Наименование на русском языке'
        );
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.bank-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->bank_id > 0) {
            $bank_item = Bank::find($request->bank_id);
        }
        else {
            $bank_item = new Bank();
        }

        $bank_item->bank_name = $request->bank_name;
        $bank_item->bank_bik = $request->bank_bik;

        if($bank_item->save()){
            return redirect('/admin/bank-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.bank-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function paymentList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Payment::select('payments.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("payment_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.payment-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function paymentEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $payment_id = $request->payment_id;

        $row = Payment::find($payment_id);
        if(@count($row) < 1){
            $row = new Payment();
            $row->payment_id = 0;
        }
        return view('admin.payment-edit', ['row' => $row]);
    }

    public function deletePayment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $payment_id = $request->payment_id;
        $result = Payment::where('payment_id', '=', $payment_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function savePayment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'payment_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'payment_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.payment-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->payment_id > 0) {
            $payment_item = Payment::find($request->payment_id);
        }
        else {
            $payment_item = new Payment();
        }

        $payment_item->payment_name = $request->payment_name;
        $payment_item->is_postpay = 0;
        if($request->is_postpay == "on"){
            $payment_item->is_postpay = 1;
        }

        if($payment_item->save()){
            return redirect('/admin/payment-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.payment-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function deliveryList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Delivery::select('deliveries.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("delivery_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.delivery-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function deliveryEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $delivery_id = $request->delivery_id;

        $row = Delivery::find($delivery_id);
        if(@count($row) < 1){
            $row = new Delivery();
            $row->delivery_id = 0;
        }
        return view('admin.delivery-edit', ['row' => $row]);
    }

    public function deleteDelivery(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $delivery_id = $request->delivery_id;
        $result = Delivery::where('delivery_id', '=', $delivery_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveDelivery(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'delivery_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'delivery_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.delivery-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->delivery_id > 0) {
            $delivery_item = Delivery::find($request->delivery_id);
        }
        else {
            $delivery_item = new Delivery();
        }

        $delivery_item->delivery_name = $request->delivery_name;

        if($delivery_item->save()){
            return redirect('/admin/delivery-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.delivery-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function brandList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Brand::select('brands.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("brand_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.brand-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function brandEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $brand_id = $request->brand_id;

        $row = Brand::select("brands.*",DB::raw('DATE_FORMAT(brands.brand_dogovor_date,"%m/%d/%Y") as brand_dogovor_date'))->where("brand_id","=",$brand_id)->first();
        if(@count($row) < 1){
            $row = new Brand();
            $row->brand_id = 0;
        }
        return view('admin.brand-edit', ['row' => $row]);
    }

    public function deleteBrand(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $brand_id = $request->brand_id;
        $result = Brand::where('brand_id', '=', $brand_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveBrand(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'brand_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.brand-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->brand_id > 0) {
            $brand_item = Brand::find($request->brand_id);
        }
        else {
            $brand_item = new Brand();
        }

        $brand_item->brand_name = $request->brand_name;
        $brand_item->brand_email = $request->brand_email;
        $brand_item->brand_company_name = $request->brand_company_name;
        $brand_item->brand_company_ceo_name = $request->brand_company_ceo_name;
        $brand_item->brand_dogovor_num = $request->brand_dogovor_num;
        $brand_item->brand_dogovor_date = date('Y-m-d', strtotime($request->brand_dogovor_date));
        $brand_item->brand_props = $request->brand_props;

        if($brand_item->save()){
            return redirect('/admin/brand-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.brand-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function autoTaskList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = AutoTask::LeftJoin("statuses","auto_tasks.auto_task_status_id","=","statuses.status_id")
                            ->select("auto_tasks.*","statuses.*");

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("auto_task_text","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.auto-task-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function autoTaskEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $auto_task_id = $request->auto_task_id;

        $row = AutoTask::select("auto_tasks.*")->where("auto_task_id","=",$auto_task_id)->first();
        if(@count($row) < 1){
            $row = new AutoTask();
            $row->auto_task_id = 0;
        }
        return view('admin.auto-task-edit', ['row' => $row]);
    }

    public function deleteAutoTask(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $auto_task_id = $request->auto_task_id;
        $result = AutoTask::where('auto_task_id', '=', $auto_task_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveAutoTask(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'auto_task_text.required' => 'Укажите Текст задачи',
            'auto_task_days.required' => 'Укажите Срок задачи',
            'auto_task_status_id.not_in' => 'Укажите Этап',
        );
        $validator = Validator::make($request->all(), [
            'auto_task_text' => 'required',
            'auto_task_days' => 'required',
            'auto_task_status_id' => 'required|not_in:0',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.auto-task-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->auto_task_id > 0) {
            $auto_task_item = AutoTask::find($request->auto_task_id);
        }
        else {
            $auto_task_item = new AutoTask();
        }

        $auto_task_item->auto_task_text = $request->auto_task_text;
        $auto_task_item->auto_task_days = $request->auto_task_days;
        $auto_task_item->auto_task_status_id = $request->auto_task_status_id;

        if($auto_task_item->save()){
            return redirect('/admin/auto-task-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.auto-task-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function markList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Mark::LeftJoin("brands","marks.mark_brand_id","=","brands.brand_id")->select('marks.*','brands.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("mark_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.mark-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function markEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $mark_id = $request->mark_id;

        $row = Mark::find($mark_id);
        if(@count($row) < 1){
            $row = new Mark();
            $row->mark_id = 0;
        }
        return view('admin.mark-edit', ['row' => $row]);
    }

    public function deleteMark(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $mark_id = $request->mark_id;
        $result = Mark::where('mark_id', '=', $mark_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveMark(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'mark_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'mark_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.mark-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->mark_id > 0) {
            $mark_item = Mark::find($request->mark_id);
        }
        else {
            $mark_item = new Mark();
        }

        $mark_item->mark_name = $request->mark_name;
        $mark_item->mark_code = $request->mark_code;
        $mark_item->mark_brand_id = $request->mark_brand_id;

        if($mark_item->save()){
            return redirect('/admin/mark-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.mark-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function fractionList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Fraction::LeftJoin("brands","fractions.fraction_brand_id","=","brands.brand_id")->select('fractions.*','brands.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("fraction_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.fraction-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function fractionEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $fraction_id = $request->fraction_id;

        $row = Fraction::find($fraction_id);
        if(@count($row) < 1){
            $row = new Fraction();
            $row->fraction_id = 0;
        }
        return view('admin.fraction-edit', ['row' => $row]);
    }

    public function deleteFraction(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $fraction_id = $request->fraction_id;
        $result = Fraction::where('fraction_id', '=', $fraction_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveFraction(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'fraction_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'fraction_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.fraction-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->fraction_id > 0) {
            $fraction_item = Fraction::find($request->fraction_id);
        }
        else {
            $fraction_item = new Fraction();
        }

        $fraction_item->fraction_name = $request->fraction_name;
        $fraction_item->fraction_brand_id = $request->fraction_brand_id;

        if($fraction_item->save()){
            return redirect('/admin/fraction-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.fraction-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function percentList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Percent::LeftJoin("brands","percents.percent_brand_id","=","brands.brand_id")->select('percents.*',"brands.brand_name");

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("percent_rate","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.percent-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function percentEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $percent_id = $request->percent_id;

        $row = Percent::find($percent_id);
        if(@count($row) < 1){
            $row = new Percent();
            $row->percent_id = 0;
        }
        return view('admin.percent-edit', ['row' => $row]);
    }

    public function deletePercent(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $percent_id = $request->percent_id;
        $result = Percent::where('percent_id', '=', $percent_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function savePercent(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'percent_brand_id.not_in' => 'Укажите Разрез'
        );
        $validator = Validator::make($request->all(), [
            'percent_brand_id' => 'required|not_in:0',
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.percent-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->percent_id > 0) {
            $percent_item = Percent::find($request->percent_id);
        }
        else {
            $percent_item = new Percent();
        }

        $percent_item->percent_rate = $request->percent_rate;
        $percent_item->percent_sum_rate = $request->percent_sum_rate;
        $percent_item->percent_brand_id = $request->percent_brand_id;

        if($percent_item->save()){
            return redirect('/admin/percent-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.percent-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function statusList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Status::select('statuses.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("status_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.status-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function statusEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $status_id = $request->status_id;

        $row = Status::find($status_id);
        if(@count($row) < 1){
            $row = new Status();
            $row->status_id = 0;
        }
        return view('admin.status-edit', ['row' => $row]);
    }

    public function deleteStatus(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $status_id = $request->status_id;
        $result = Status::where('status_id', '=', $status_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveStatus(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'status_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'status_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.status-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->status_id > 0) {
            $status_item = Status::find($request->status_id);
        }
        else {
            $status_item = new Status();
        }

        $status_item->status_name = $request->status_name;
        $status_item->status_color = $request->status_color;

        if($status_item->save()){
            return redirect('/admin/status-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.status-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function timezoneList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Timezone::select('timezones.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("timezone_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);
        return view('admin.timezone-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function timezoneEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $timezone_id = $request->timezone_id;

        $row = Timezone::find($timezone_id);
        if(@count($row) < 1){
            $row = new Timezone();
            $row->timezone_id = 0;
        }
        return view('admin.timezone-edit', ['row' => $row]);
    }

    public function deleteTimezone(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $timezone_id = $request->timezone_id;
        $result = Timezone::where('timezone_id', '=', $timezone_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveTimezone(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'timezone_name.required' => 'Укажите Наименование'
        );
        $validator = Validator::make($request->all(), [
            'timezone_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['timezone'] = false;
            $role_list = Role::all();
            return view('admin.timezone-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->timezone_id > 0) {
            $timezone_item = Timezone::find($request->timezone_id);
        }
        else {
            $timezone_item = new Timezone();
        }

        $timezone_item->timezone_name = $request->timezone_name;
        $timezone_item->timezone_value = $request->timezone_value;

        if($timezone_item->save()){
            return redirect('/admin/timezone-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['timezone'] = false;
            $role_list = Role::all();
            return view('admin.timezone-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }
    }

    public function stationList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Station::LeftJoin("regions","stations.station_region_id","=","regions.region_id")->select('stations.*',"regions.*");

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where("station_name","like","%" . $request->search_word . "%");
        }
        $row = $row->paginate($row_count);

        return view('admin.station-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function stationEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $station_id = $request->station_id;

        $row = Station::find($station_id);
        if(@count($row) < 1){
            $row = new Station();
            $row->station_id = 0;
        }
        return view('admin.station-edit', ['row' => $row]);
    }

    public function deleteStation(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $station_id = $request->station_id;
        $result = Station::where('station_id', '=', $station_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveStation(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'station_name.required' => 'Укажите Станцию назначения'
        );
        $validator = Validator::make($request->all(), [
            'station_name' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['station'] = false;
            $role_list = Role::all();
            return view('admin.station-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->station_id > 0) {
            $station_item = Station::find($request->station_id);
        }
        else {
            $station_item = new Station();
        }

        $station_item->station_name = $request->station_name;
        $station_item->station_code = $request->station_code;
        $station_item->station_km = $request->station_km;
        $station_item->station_region_id = $request->station_region_id;
        $station_item->station_rate = $request->station_rate;
        $station_item->station_rate_nds = $request->station_rate_nds;
        $station_item->station_brand_id = $request->station_brand_id;

        if($station_item->save()){
            return redirect('/admin/station-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['station'] = false;
            return view('admin.station-edit', [ 'row' => $request, 'result' => $result ]);
        }
    }

    public function profile(){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row = Users::where('user_id','=',Auth::user()->user_id)->first();
        $role_list = Role::all();

        $deal_list = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
                            ->LeftJoin("statuses","deals.deal_status_id","=","statuses.status_id")
                            ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                            ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                            ->select('deals.*',"clients.client_name","clients.client_surname", "statuses.status_name", "statuses.status_color", "stations.*", "marks.*", DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1_format'));

        $deal_list = $deal_list->where(function($query)
        {
            $query->orWhere("deals.deal_user_id1","=",Auth::user()->user_id)->orWhere("deals.deal_user_id2","=",Auth::user()->user_id)
                ->orWhere("deals.deal_user_id3","=",Auth::user()->user_id)->orWhere("deals.deal_user_id4","=",Auth::user()->user_id)
                ->orWhere("deals.deal_user_id5","=",Auth::user()->user_id)->orWhere("deals.deal_user_id6","=",Auth::user()->user_id)
                ->orWhere("deals.deal_user_id7","=",Auth::user()->user_id)->orWhere("deals.deal_user_id8","=",Auth::user()->user_id)
                ->orWhere("deals.deal_user_id9","=",Auth::user()->user_id);
        });
        $deal_list = $deal_list->get();

        $all_deals_sum = DB::select( DB::raw("select
                                     COALESCE( sum(CASE
                                     WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                     ELSE t.deal_kp_sum - t.deal_discount
                                     END),0) as deal_kp_sum_res
                                from deals t
                                where t.deal_user_id1 = " . Auth::user()->user_id . "
                                or  t.deal_user_id2 = " . Auth::user()->user_id . "
                                or  t.deal_user_id3 = " . Auth::user()->user_id . "
                                or  t.deal_user_id4 = " . Auth::user()->user_id . "
                                or  t.deal_user_id5 = " . Auth::user()->user_id . "
                                or  t.deal_user_id6 = " . Auth::user()->user_id . "
                                or  t.deal_user_id7 = " . Auth::user()->user_id . "
                                or  t.deal_user_id8 = " . Auth::user()->user_id . "
                                or  t.deal_user_id9 = " . Auth::user()->user_id . "
                                or  t.deal_user_id10 = " . Auth::user()->user_id));

        $user_task_list = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
            ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
            ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
            ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
            ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
            ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'),DB::raw('DATE_FORMAT(user_tasks.user_task_start_date,"%d.%m.%Y") as user_task_start_date_format'), "deals.*", "stations.*","marks.*")
            ->where("user_tasks.user_task_user_id","=",Auth::user()->user_id)
            ->orderByRaw(DB::raw("FIELD(user_tasks.user_task_task_id, '2', '1', '3','4')"))
            ->orderBy("user_tasks.user_task_end_date","desc")->get();

        return view('admin.profile', [ 'row' => $row, 'role_list' => $role_list, 'deal_list' => $deal_list, 'all_deals_sum' => $all_deals_sum, 'user_task_list' => $user_task_list]);
    }

    public function updateProfileInfo(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row = Users::where('user_id','=',Auth::user()->user_id)->first();

        if(@count($row) > 0){
            if(strlen($row->password) > 0 && strlen($request->new_password) > 0 && strlen($request->repeat_password) > 0){
                $check_old_pass = Hash::check($request->password, $row->password);
                if($check_old_pass == false){
                    return response()->json(['result'=>'incorrect_password']);
                }

                if($request->new_password != $request->repeat_password){
                    return response()->json(['result'=>'incorrect_repeat']);
                }

                $row->password = Hash::make($request->new_password);
            }

            $row->user_surname = $request->user_surname;
            $row->user_name = $request->user_name;
            $row->user_phone = $request->user_phone;
            $row->email = $request->email;
            $row->user_role_id = $request->user_role_id;
            if($row->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>"incorrect_user"]);
        }
    }


    public function clientList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Client::LeftJoin("companies","clients.client_company_id","=","companies.company_id")
                        ->select('clients.*',"companies.*");

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where(function($query) use ($request)
            {
                $query->where("companies.company_name","like","%" . $request->search_word . "%")->orWhere("client_name","like","%" . $request->search_word . "%")->orWhere("client_surname","like","%" . $request->search_word . "%");
            });
        }
        $row = $row->paginate($row_count);
        return view('admin.client-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function clientEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $client_id = $request->client_id;

        $row = Client::LeftJoin("stations","clients.client_station_id","=","stations.station_id")
                    ->LeftJoin("regions","clients.client_region_id","=","regions.region_id")
                    ->select("clients.*","stations.station_name","regions.region_name")
                    ->where("client_id","=",$client_id)->first();
        $company_row = null;
        if(@count($row) < 1){
            $row = new Client();
            $row->client_id = 0;
        }
        else{
            $company_row = Company::where("company_id","=",$row['client_company_id'])->first();
        }

        return view('admin.client-edit', ['row' => $row, 'company_row' => $company_row]);
    }

    public function deleteClient(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $client_id = $request->client_id;
        $result = Client::where('client_id', '=', $client_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveClient(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        if($request->client_id > 0) {
            $client_item = Client::find($request->client_id);
        }
        else {
            $client_item = new Client();
        }

        $client_item->client_name = $request->client_name;
        $client_item->client_surname = $request->client_surname;
        $client_item->client_phone = $request->client_phone;
        $client_item->client_email = $request->client_email;
        $client_item->client_region_id = $request->client_region_id;
        $client_item->client_station_id = $request->client_station_id;
        $client_item->client_receiver_code = $request->client_receiver_code;
        $client_item->client_company_id = $request->client_company_id;

        if($client_item->save()){
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function getRegionList(Request $request){
        $region_list = Region::where("region_name","like","%" . $request->region_search_str . "%")->get();
        return response()->json(['region_list'=>$region_list]);
    }

    public function getStationList(Request $request){
        $station_list = Station::where("station_name","like","%" . $request->station_search_str . "%")->get();
        return response()->json(['station_list'=>$station_list]);
    }

    public function getCompanyList(Request $request){
        $company_list = Company::where("company_name","like","%" . $request->company_search_str . "%")->get();
        return response()->json(['company_list'=>$company_list]);
    }

    public function getClientList(Request $request){
        $client_list = Client::where("client_surname","like","%" . $request->client_search_str . "%")->orWhere("client_name","like","%" . $request->client_search_str . "%")->get();
        return response()->json(['client_list'=>$client_list]);
    }

    public function getStation(Request $request){
        $station_row = Station::find($request->station_id);
        return response()->json(['station_row'=>$station_row]);
    }

    public function dealList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
                    ->LeftJoin("statuses","deals.deal_status_id","=","statuses.status_id")
                    ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                    ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                    ->select('deals.*',"clients.client_name","clients.client_surname", "statuses.status_name", "statuses.status_color", "stations.*", "marks.*", DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1_format'));

        if(isset($request->client_id) && $request->client_id > 0){
            $row = $row->where("deals.deal_client_id","=",$request->client_id);
        }

        if(isset($request->status_id) && $request->status_id > 0 && $request->type != "cards"){
            $row = $row->where("deals.deal_status_id","=",$request->status_id);
        }

        if(isset($request->user_id) && $request->user_id > 0){
            $row = $row->where(function($query) use ($request)
            {
                $query->orWhere("deals.deal_user_id1","=",$request->user_id)->orWhere("deals.deal_user_id2","=",$request->user_id)
                      ->orWhere("deals.deal_user_id3","=",$request->user_id)->orWhere("deals.deal_user_id4","=",$request->user_id)
                      ->orWhere("deals.deal_user_id5","=",$request->user_id)->orWhere("deals.deal_user_id6","=",$request->user_id)
                      ->orWhere("deals.deal_user_id7","=",$request->user_id)->orWhere("deals.deal_user_id8","=",$request->user_id)
                      ->orWhere("deals.deal_user_id9","=",$request->user_id);
            });
        }

        if(isset($request->date_from) && strlen($request->date_from) > 0 && isset($request->date_to) && strlen($request->date_to) > 0){
            $from = date('Y-m-d 00:00:00',strtotime($request->date_from));
            $to = date('Y-m-d 23:59:59',strtotime($request->date_to));
            $row = $row->whereBetween('deals.deal_datetime1', array($from, $to));
        }

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where(function($query) use ($request)
            {
                $query->where("stations.station_name","like","%" . $request->search_word . "%")->orWhere("marks.mark_name","like","%" . $request->search_word . "%");
            });
        }

        $row_item = $row->orderBy("deals.deal_datetime1","desc")->get();
        if($request->type == "cards"){
            $row_list[1] = $row_item->where("deal_status_id","=",1);
            $row_list[2] = $row_item->where("deal_status_id","=",2);
            $row_list[3] = $row_item->where("deal_status_id","=",3);
            $row_list[4] = $row_item->where("deal_status_id","=",4);
            $row_list[5] = $row_item->where("deal_status_id","=",5);
            $row_list[6] = $row_item->where("deal_status_id","=",6);
            $row_list[7] = $row_item->where("deal_status_id","=",7);
            $row_list[8] = $row_item->where("deal_status_id","=",8);
            $row_list[9] = $row_item->where("deal_status_id","=",9);
            $row_list[10] = $row_item->where("deal_status_id","=",10);
            $row_list[11] = $row_item->where("deal_status_id","=",11);
            $row_list[12] = $row_item->where("deal_status_id","=",12);
        }

        $row = $row->paginate($row_count);

        $status_list = Status::orderBy("status_id","asc")->get();
        $client_list = Client::orderBy("client_name","asc")->get();
        $user_list = Users::orderBy("user_surname","asc")->get();

        if($request->type == "cards"){
            return view('admin.deal-cards', [ 'row_list' => $row_list, 'row_count' => $row_count,'search_word' => $request->search_word, 'client_id' => $request->client_id, 'status_id' => $request->status_id, 'user_id' => $request->user_id, 'date_from' => $request->date_from, 'date_to' => $request->date_to, 'status_list' => $status_list, 'client_list' => $client_list, 'user_list' => $user_list]);
        }
        else{
            return view('admin.deal-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word, 'client_id' => $request->client_id, 'status_id' => $request->status_id, 'user_id' => $request->user_id, 'date_from' => $request->date_from, 'date_to' => $request->date_to, 'status_list' => $status_list, 'client_list' => $client_list, 'user_list' => $user_list]);
        }
    }

    public function dealEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_id = $request->deal_id;

        $row = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
                    ->LeftJoin("brands","deals.deal_brand_id","=","brands.brand_id")
                    ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                    ->LeftJoin("fractions","deals.deal_fraction_id","=","fractions.fraction_id")
                    ->LeftJoin("regions","deals.deal_region_id","=","regions.region_id")
                    ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                    ->LeftJoin("companies","clients.client_company_id","=","companies.company_id")
//                    ->LeftJoin("users as users1","deals.deal_user_id1","=","users1.user_id")
//                    ->LeftJoin("users as users2","deals.deal_user_id2","=","users2.user_id")
//                    ->LeftJoin("users as users3","deals.deal_user_id3","=","users3.user_id")
//                    ->LeftJoin("users as users4","deals.deal_user_id4","=","users4.user_id")
//                    ->LeftJoin("users as users5","deals.deal_user_id5","=","users5.user_id")
//                    ->LeftJoin("users as users6","deals.deal_user_id6","=","users6.user_id")
//                    ->LeftJoin("users as users7","deals.deal_user_id7","=","users7.user_id")
//                    ->LeftJoin("users as users8","deals.deal_user_id8","=","users8.user_id")
//                    ->LeftJoin("users as users9","deals.deal_user_id9","=","users9.user_id")
                    ->select("deals.*","clients.*","brands.*","marks.*","fractions.*","regions.*","stations.*",
                            "companies.*",
                            DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime2,"%d.%m.%Y %T") as deal_datetime2_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime3,"%d.%m.%Y %T") as deal_datetime3_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime4,"%d.%m.%Y %T") as deal_datetime4_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime5,"%d.%m.%Y %T") as deal_datetime5_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime6,"%d.%m.%Y %T") as deal_datetime6_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime7,"%d.%m.%Y %T") as deal_datetime7_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime8,"%d.%m.%Y %T") as deal_datetime8_format'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime9,"%d.%m.%Y %T") as deal_datetime9_format'),
                            DB::raw('DATE_FORMAT(deals.deal_shipping_date,"%d/%m/%Y") as deal_shipping_date'),
                            DB::raw('DATE_FORMAT(deals.deal_delivery_date,"%d/%m/%Y") as deal_delivery_date')
                            )
                    ->where("deal_id","=",$deal_id)->first();
        if(@count($row) < 1){
            $row = new Deal();
            $row->deal_id = 0;
        }

        $deal_bill_tonn_sum = 0;
        if($row['deal_station_id'] > 0 && $row['deal_region_id'] > 0){
            $station_row = Station::where("station_id","=", $row['deal_station_id'])->first();
            $region_row = Region::where("region_id","=",$row['deal_region_id'])->first();
            $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                ->select("percents.*")
                ->where("stations.station_id","=",$row['deal_station_id'])
                ->first();
            if(@count($percents_row) > 0){
                if($percents_row->percent_rate > 0){
                    $deal_bill_tonn_sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100);
                }
                else{
                    $deal_bill_tonn_sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate']);
                }
            }
        }

        $user_list = Users::orderBy("user_surname")->get();
        $brand_list = Brand::orderBy("brand_name")->get();
        $mark_list = Mark::where("mark_brand_id","=",$row['deal_brand_id'])->orderBy("mark_name")->get();
        $fraction_list = Fraction::where("fraction_brand_id","=",$row['deal_brand_id'])->orderBy("fraction_name")->get();
        $region_list = Region::where("region_brand_id","=",$row['deal_brand_id'])->orderBy("region_name")->get();
        $station_list = Station::where("station_region_id","=",$row['deal_region_id'])->orderBy("station_name")->get();
        $payment_list = Payment::orderBy("payment_name")->get();
        $bank_list = Bank::orderBy("bank_name")->get();
        $delivery_list = Delivery::orderBy("delivery_name")->get();
        $client_list = Client::orderBy("client_surname")->get();
        $deal_brand_files = DealFile::select("deal_files.*",DB::raw('DATE_FORMAT(deal_files.deal_file_date,"%d.%m.%Y %T") as deal_file_date_format'))->where("deal_file_deal_id","=",$row['deal_id'])->where("deal_file_type","=",4)->get();
        $deal_other_files = DealFile::select("deal_files.*",DB::raw('DATE_FORMAT(deal_files.deal_file_date,"%d.%m.%Y %T") as deal_file_date_format'))->where("deal_file_deal_id","=",$row['deal_id'])->where("deal_file_type","=",5)->get();

        return view('admin.deal-edit', ['row' => $row, 'user_list' => $user_list, 'brand_list' => $brand_list,
                'mark_list' => $mark_list, 'fraction_list' => $fraction_list, 'region_list' => $region_list,
                'station_list' => $station_list, 'payment_list' => $payment_list, 'bank_list' => $bank_list,
                'deal_brand_files' => $deal_brand_files, 'delivery_list' => $delivery_list, 'client_list' => $client_list,
                'deal_other_files' => $deal_other_files, 'deal_bill_tonn_sum' => floor($deal_bill_tonn_sum)]);
    }

    public function deleteDeal(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_id = $request->deal_id;
        $result = Deal::where('deal_id', '=', $deal_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveDealInfo(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        if($request->deal_id > 0){
            $deal_row = Deal::find($request->deal_id);
        }
        else{
            $deal_row = new Deal();
        }

        if(!($request->deal_status_id == 1 && $deal_row->deal_status_id == null) &&  $request->deal_status_id > $deal_row->deal_status_id){
            return response()->json(['result'=>'incorrect_status']);
        }

        $deal_history_str = "";
        $user_id_process = null;
        $is_postpay = 0;

        $status_row = Status::where("status_id","=",$request->deal_status_id)->first();
        if($request->deal_status_id == 1){
            if($request->deal_client_id != $deal_row->deal_client_id){
                $deal_history_str .= "<b>Клиент:</b> " . $request->client_surname . " " . $request->client_name . "<br>";
            }

            if($request->deal_user_id1 != $deal_row->deal_user_id1){
                $user_row = Users::where("user_id","=",$request->deal_user_id1)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }
            $user_id_process = $request->deal_user_id1;

            if($request->deal_client_id > 0){
                $deal_row->deal_client_id = $request->deal_client_id;
                $client_row = Client::where("client_id","=",$request->deal_client_id)->first();
                if(@count($client_row) > 0){
                    $client_fio_parts = explode(" ",$request->client_fio);
                    if(@count($client_fio_parts) > 0){
                        if(isset($client_fio_parts[0])){
                            $client_row->client_surname = $client_fio_parts[0];
                        }
                        if(isset($client_fio_parts[1])){
                            $client_row->client_name = $client_fio_parts[1];
                        }
                    }

                    $client_row->client_phone = $request->client_phone;
                    $client_row->client_email = $request->client_email;
                    $client_row->save();
                }
            }
            else{
                $new_client = new Client();
                $client_fio_parts = explode(" ",$request->client_fio);
                if(@count($client_fio_parts) > 0){
                   if(isset($client_fio_parts[0])){
                       $new_client->client_surname = $client_fio_parts[0];
                   }
                   if(isset($client_fio_parts[1])){
                       $new_client->client_name = $client_fio_parts[1];
                   }
                }
                $new_client->client_phone = $request->client_phone;
                $new_client->client_email = $request->client_email;
                $new_client->save();
                $deal_row->deal_client_id = $new_client->client_id;
            }
            if($request->deal_id < 1){
                $deal_row->deal_user_id2 = $request->deal_user_id1;
                $deal_row->deal_user_id3 = $request->deal_user_id1;
                $deal_row->deal_user_id4 = $request->deal_user_id1;
            }

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime1) < 1) {
                $deal_row->deal_datetime1 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id1 = $request->deal_user_id1;
        }
        else if($request->deal_status_id == 2){
            $station_row = Station::where("station_id","=", $request->deal_station_id)->first();
            $region_row = Region::where("region_id","=",$request->deal_region_id)->first();

            $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                ->select("percents.*")
                ->where("stations.station_id","=",$request->deal_station_id)
                ->first();
            $sum = 0;
            if(@count($percents_row) > 0){
                if($percents_row->percent_rate > 0){
                    $sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100)*$request->deal_volume;
                }
                else{
                    $sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate'])*$request->deal_volume;
                }
            }

            if($request->deal_brand_id != $deal_row->deal_brand_id){
                $brand_row = Brand::where("brand_id","=",$request->deal_brand_id)->first();
                $deal_history_str .= "<b>Разрез:</b> " . $brand_row->brand_name . "<br>";
            }
            if($request->deal_mark_id != $deal_row->deal_mark_id){
                $mark_row = Mark::where("mark_id","=",$request->deal_mark_id)->first();
                $deal_history_str .= "<b>Марка:</b> " . $mark_row->mark_name . "<br>";
            }
            if($request->deal_fraction_id != $deal_row->deal_fraction_id){
                $fraction_row = Fraction::where("fraction_id","=",$request->deal_fraction_id)->first();
                $deal_history_str .= "<b>Фракция:</b> " . $fraction_row->fraction_name . "<br>";
            }
            if($request->deal_volume != $deal_row->deal_volume){
                $deal_history_str .= "<b>Объем в тоннах:</b> " . $request->deal_volume . "<br>";
            }
            if($request->deal_region_id != $deal_row->deal_region_id){
                $deal_history_str .= "<b>Область:</b> " . $region_row->region_name . "<br>";
            }
            if($request->deal_station_id != $deal_row->deal_station_id){
                $deal_history_str .= "<b>Станция:</b> " . $station_row->station_name . "<br>";
            }
            if($sum != $deal_row->deal_kp_sum){
                $deal_history_str .= "<b>Цена за 1 тонну + доставка + НДС:</b> " . floor($sum) . "<br>";
            }

            if($request->deal_user_id2 != $deal_row->deal_user_id2){
                $user_row = Users::where("user_id","=",$request->deal_user_id2)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }
            $user_id_process = $request->deal_user_id2;

            $deal_row->deal_brand_id = $request->deal_brand_id;
            $deal_row->deal_mark_id = $request->deal_mark_id;
            $deal_row->deal_fraction_id = $request->deal_fraction_id;
            $deal_row->deal_volume = $request->deal_volume;
            $deal_row->deal_region_id = $request->deal_region_id;
            $deal_row->deal_station_id = $request->deal_station_id;

            $deal_row->deal_kp_sum = $sum;

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime2) < 1) {
                $deal_row->deal_datetime2 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id2 = $request->deal_user_id2;
        }
        else if($request->deal_status_id == 3){
            if($request->deal_discount_type != $deal_row->deal_discount_type || $request->deal_discount != $deal_row->deal_discount){
                $discount_str = " тг.";
                if($request->deal_discount_type == 1){
                    $discount_str = " %";
                }
                $deal_history_str .= "<b>Скидка:</b> " . $request->deal_discount . $discount_str . "<br>";
            }
            if($request->deal_user_id3 != $deal_row->deal_user_id3){
                $user_row = Users::where("user_id","=",$request->deal_user_id3)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }
            $user_id_process = $request->deal_user_id3;

            $deal_row->deal_discount_type = 0;
            if($request->deal_discount_type == "on"){
                $deal_row->deal_discount_type = 1;
            }
            $deal_row->deal_discount = $request->deal_discount;

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime3) < 1) {
                $deal_row->deal_datetime3 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id3 = $request->deal_user_id3;
        }
        else if($request->deal_status_id == 4){
            $payment_row = Payment::where("payment_id","=",$request->deal_payment_id)->first();
            $is_postpay = $payment_row->is_postpay;
            if($request->deal_payment_id != $deal_row->deal_payment_id){
                $deal_history_str .= "<b>Тип оплаты:</b> " . $payment_row->payment_name . "<br>";
            }
            if($request->deal_delivery_id != $deal_row->deal_delivery_id){
                $delivery_row = Delivery::where("delivery_id","=",$request->deal_delivery_id)->first();
                $deal_history_str .= "<b>Срок доставки:</b> " . $delivery_row->delivery_name . "<br>";
            }
            if($request->deal_receiver_code != $deal_row->deal_receiver_code){
                $deal_history_str .= "<b>Код получателя:</b> " . $request->deal_receiver_code . "<br>";
            }
            if($request->deal_user_id4 != $deal_row->deal_user_id4){
                $user_row = Users::where("user_id","=",$request->deal_user_id4)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $deal_row->deal_payment_id = $request->deal_payment_id;
            $deal_row->deal_delivery_id = $request->deal_delivery_id;

            if($request->company_id > 0){
                $deal_client_row = Client::where("client_id","=",$deal_row->deal_client_id)->first();
                $deal_client_row->client_company_id = $request->company_id;
                $deal_client_row->save();

                $company_row = Company::where("company_id","=",$request->company_id)->first();
                $company_row->company_name = $request->company_name;
                $company_row->company_ceo_position = $request->company_ceo_position;
                $company_row->company_ceo_name = $request->company_ceo_name;
                $company_row->company_address = $request->company_address;
                $company_row->company_bank_id = $request->company_bank_id;
                $company_row->company_bank_iik = $request->company_bank_iik;
                $company_row->company_bank_bin = $request->company_bank_bin;
                $company_row->company_delivery_address = $request->company_delivery_address;
                $company_row->company_okpo = $request->company_okpo;
                $company_row->save();
            }
            else{
                $new_company_row = new Company();
                $new_company_row->company_name = $request->company_name;
                $new_company_row->company_ceo_position = $request->company_ceo_position;
                $new_company_row->company_ceo_name = $request->company_ceo_name;
                $new_company_row->company_address = $request->company_address;
                $new_company_row->company_bank_id = $request->company_bank_id;
                $new_company_row->company_bank_iik = $request->company_bank_iik;
                $new_company_row->company_bank_bin = $request->company_bank_bin;
                $new_company_row->company_delivery_address = $request->company_delivery_address;
                $new_company_row->company_okpo = $request->company_okpo;
                $new_company_row->save();

                $deal_client_row = Client::where("client_id","=",$deal_row->deal_client_id)->first();
                $deal_client_row->client_company_id = $new_company_row->company_id;
                $deal_client_row->save();
            }

            $deal_row->deal_receiver_code = $request->deal_receiver_code;

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime4) < 1) {
                $deal_row->deal_datetime4 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id4 = $request->deal_user_id4;
        }
        else if($request->deal_status_id == 5){
            if($request->deal_user_id5 != $deal_row->deal_user_id5){
                $user_row = Users::where("user_id","=",$request->deal_user_id5)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime5) < 1) {
                $deal_row->deal_datetime5 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id5 = $request->deal_user_id5;
        }
        else if($request->deal_status_id == 6){
            if($request->deal_user_id6 != $deal_row->deal_user_id6){
                $user_row = Users::where("user_id","=",$request->deal_user_id6)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime6) < 1) {
                $deal_row->deal_datetime6 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id6 = $request->deal_user_id6;
        }
        else if($request->deal_status_id == 7){
            if($request->deal_brand_sum != $deal_row->deal_brand_sum){
                $deal_history_str .= "<b>Сумма оплаты:</b> " . $request->deal_brand_sum . "<br>";
            }
            if($request->deal_user_id7 != $deal_row->deal_user_id7){
                $user_row = Users::where("user_id","=",$request->deal_user_id7)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $deal_row->deal_brand_sum = $request->deal_brand_sum;

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime7) < 1) {
                $deal_row->deal_datetime7 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id7 = $request->deal_user_id7;
        }
        else if($request->deal_status_id == 8){
            if($request->deal_shipping_date != $deal_row->deal_shipping_date){
                $deal_history_str .= "<b>Дата отгрузки:</b> " . date('d.m.Y', strtotime($request->deal_shipping_date)) . "<br>";
            }
            if($request->deal_shipping_time != $deal_row->deal_shipping_time){
                $deal_history_str .= "<b>Время отгрузки:</b> " . date('H:i:s', strtotime($request->deal_shipping_date)) . "<br>";
            }
            if($request->deal_user_id8 != $deal_row->deal_user_id8){
                $user_row = Users::where("user_id","=",$request->deal_user_id8)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $deal_row->deal_shipping_date = date('Y-m-d', strtotime($request->deal_shipping_date));
            $deal_row->deal_shipping_time = date('H:i:s', strtotime($request->deal_shipping_date));
            $deal_row->deal_fact_volume = $request->deal_fact_volume;

            $station_row = Station::where("station_id","=", $deal_row->deal_station_id)->first();
            $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

            $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                ->select("percents.*")
                ->where("stations.station_id","=",$deal_row->deal_station_id)
                ->first();
            $deal_rest_volume_in_sum = 0;
            $deal_rest_volume = $deal_row->deal_volume - $request->deal_fact_volume;

            if(@count($percents_row) > 0){
                if($percents_row->percent_rate > 0){
                    $deal_rest_volume_in_sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100)*$deal_rest_volume;
                }
                else{
                    $deal_rest_volume_in_sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate'])*$request->deal_rest_volume;
                }
            }

            $deal_row->deal_rest_volume = $deal_rest_volume;
            $deal_row->deal_rest_volume_in_sum = $deal_rest_volume_in_sum;

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime8) < 1) {
                $deal_row->deal_datetime8 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id8 = $request->deal_user_id8;
        }
        else if($request->deal_status_id == 9){
            if($request->deal_delivery_date != $deal_row->deal_delivery_date){
                $deal_history_str .= "<b>Дата доставки:</b> " . date('d.m.Y', strtotime($request->deal_delivery_date)) . "<br>";
            }
            if($request->deal_delivery_time != $deal_row->deal_delivery_time){
                $deal_history_str .= "<b>Время доставки:</b> " . date('H:i:s', strtotime($request->deal_delivery_date)) . "<br>";
            }
            if($request->deal_user_id9 != $deal_row->deal_user_id9){
                $user_row = Users::where("user_id","=",$request->deal_user_id9)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }

            $deal_row->deal_delivery_date = date('Y-m-d', strtotime($request->deal_delivery_date));
            $deal_row->deal_delivery_time = date('H:i:s', strtotime($request->deal_delivery_date));

            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime9) < 1) {
                $deal_row->deal_datetime9 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id9 = $request->deal_user_id9;
        }
        else if($request->deal_status_id == 10){
            if($request->deal_user_id10 != $deal_row->deal_user_id10){
                $user_row = Users::where("user_id","=",$request->deal_user_id10)->first();
                $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
            }
            $offset= strtotime("+6 hours 0 minutes");
            if(strlen($deal_row->deal_datetime10) < 1) {
                $deal_row->deal_datetime10 = date("Y-m-d H:i:s", $offset);
            }
            $deal_row->deal_user_id10 = $request->deal_user_id10;
        }

        $is_add_auto_task = false;
        if($deal_row->deal_status_id == null){
            $deal_row->deal_status_id = 2;
        }
        else if($deal_row->deal_status_id == 4 && $is_postpay == 1){
            $deal_row->deal_status_id = 6;
        }
        else if($request->deal_status_id == $deal_row->deal_status_id){
            if($deal_row->deal_status_id < 11){
                $deal_row->deal_status_id = $deal_row->deal_status_id + 1;
            }
            $is_add_auto_task = true;
        }
        if($deal_row->save()){
            if(strlen($deal_history_str) > 0){
                $deal_history_str = "<b>Этап: </b>" . $status_row->status_name . "<br>" . $deal_history_str;
                $new_deal_history = new DealHistory();
                $new_deal_history->deal_history_deal_id = $deal_row->deal_id;
                $new_deal_history->deal_history_user_id = $user_id_process;
                $offset= strtotime("+6 hours 0 minutes");
                $new_deal_history->deal_history_datetime = date("Y-m-d H:i:s", $offset);
                $new_deal_history->deal_history_text = $deal_history_str;
                $new_deal_history->save();
            }

            if($is_add_auto_task == true){
                $auto_task_list = AutoTask::where("auto_task_status_id","=",$request->deal_status_id)->get();
                if(@count($auto_task_list) > 0){
                    foreach ($auto_task_list as $key => $auto_task_item){
                        $new_task = new UserTask();
                        $new_task->user_task_deal_id = $deal_row->deal_id;
                        $new_task->user_task_user_id = $user_id_process;
                        $new_task->user_task_text = $auto_task_item['auto_task_text'];
                        $offset= strtotime("+6 hours 0 minutes");
                        $new_task->user_task_start_date = date('Y-m-d',$offset);
                        $new_task->user_task_start_time = date('H:i:s',$offset);

                        $offset2= strtotime("+" . $auto_task_item['auto_task_days'] .  "days 6 hours 0 minutes");
                        $new_task->user_task_end_date = date('Y-m-d', $offset2);
                        $new_task->user_task_end_time = date('H:i:s',$offset);
                        $new_task->user_task_task_id = 1;
                        $new_task->user_task_is_auto = 1;
                        $new_task->save();
                    }
                }
            }

            if($request['deal_status_id'] == 6){
                $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",3)->first();
                $deal_template_text = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);

//        return view('admin.test-pdf', [ 'deal_template_text' => $deal_template_text]);
                $pdf = PDF::loadView('admin.test-pdf',['deal_template_text' => $deal_template_text]);
                $deal_file_src = time() . $request->deal_id . '_kp.pdf';
                $pdf->save('deal_files/' . $deal_file_src);

                $new_deal_file = new DealFile();
                $new_deal_file->deal_file_deal_id = $request->deal_id;
                $new_deal_file->deal_file_name = $deal_file_src;
                $new_deal_file->deal_file_src = $deal_file_src;
                $new_deal_file->deal_file_type = 4;
                $offset= strtotime("+6 hours 0 minutes");
                $new_deal_file->deal_file_date = date("Y-m-d H:i:s",$offset);
                if($new_deal_file->save()){
                    $email_to = "adik.khalikhov@mail.ru";
                    $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",6)->first();
                    $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$deal_row->deal_id);
                    $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$deal_row->deal_id);

                    Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function($message) use ($email_to,$new_deal_file,$mail_title)
                    {
                        $message->to($email_to)->subject($mail_title);
                        $message->cc("askhat@kit.systems")->subject($mail_title);
                        $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
                        $message->attach("deal_files/" . $new_deal_file['deal_file_src'], ['as' => $new_deal_file['deal_file_name'], 'mime' => 'application/pdf']);
                    });
                    if(@count(Mail::failures()) > 0){
                        return response()->json(['result'=>'error_send_brand_mail']);
                    }
                }
                else{
                    return response()->json(['result'=>'error_save_brand_file']);
                }
            }

            $deal_row_new = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
                ->LeftJoin("brands","deals.deal_brand_id","=","brands.brand_id")
                ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                ->LeftJoin("fractions","deals.deal_fraction_id","=","fractions.fraction_id")
                ->LeftJoin("regions","deals.deal_region_id","=","regions.region_id")
                ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                ->LeftJoin("companies","clients.client_company_id","=","companies.company_id")
                ->select("deals.*","clients.*","brands.*","marks.*","fractions.*","regions.*","stations.*",
                    "companies.*",
                    DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime2,"%d.%m.%Y %T") as deal_datetime2_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime3,"%d.%m.%Y %T") as deal_datetime3_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime4,"%d.%m.%Y %T") as deal_datetime4_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime5,"%d.%m.%Y %T") as deal_datetime5_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime6,"%d.%m.%Y %T") as deal_datetime6_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime7,"%d.%m.%Y %T") as deal_datetime7_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime8,"%d.%m.%Y %T") as deal_datetime8_format'),
                    DB::raw('DATE_FORMAT(deals.deal_datetime9,"%d.%m.%Y %T") as deal_datetime9_format'),
                    DB::raw('DATE_FORMAT(deals.deal_shipping_date,"%d/%m/%Y") as deal_shipping_date'),
                    DB::raw('DATE_FORMAT(deals.deal_delivery_date,"%d/%m/%Y") as deal_delivery_date')
                )
                ->where("deal_id","=",$deal_row['deal_id'])->first();

            $deal_row_new['deal_bill_tonn_sum'] = 0;
            if($deal_row_new['deal_station_id'] > 0 && $deal_row_new['deal_region_id'] > 0){
                $station_row = Station::where("station_id","=", $deal_row_new['deal_station_id'])->first();
                $region_row = Region::where("region_id","=",$deal_row_new['deal_region_id'])->first();
                $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                    ->select("percents.*")
                    ->where("stations.station_id","=",$deal_row_new['deal_station_id'])
                    ->first();
                if(@count($percents_row) > 0){
                    if($percents_row->percent_rate > 0){
                        $deal_row_new['deal_bill_tonn_sum'] = floor((($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100));
                    }
                    else{
                        $deal_row_new['deal_bill_tonn_sum'] = floor(($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate']));
                    }
                }
            }
            return response()->json(['result'=>true, 'deal_row' => $deal_row_new]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function uploadDealFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        if(!(isset($request->brand_deal_file_src))){
            $result['success'] = "not_file";
            return $result;
        }
        $file = $request->brand_deal_file_src;
        $original_file_name = $file->getClientOriginalName();
        $file_name = time() . $request->deal_id . "_brands_file.";
        $file_extension = $file->extension($file_name);
        $file_name = $file_name . $file_extension;
        Storage::disk('deal_files')->put($file_name,  File::get($file));

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_name = $original_file_name;
        $new_deal_file->deal_file_src = $file_name;
        $new_deal_file->deal_file_type = $request->deal_file_type;
        $offset= strtotime("+6 hours 0 minutes");
        $new_deal_file->deal_file_date = date("Y-m-d H:i:s",$offset);
        $deal_file_date = date("d.m.Y H:i:s",$offset);
        if($new_deal_file->save()){
            $result['success'] = true;
            $result['deal_file_name'] = $original_file_name;
            $result['deal_file_src'] = $file_name;
            $result['deal_file_date'] = $deal_file_date;
            $result['deal_file_id'] = $new_deal_file->deal_file_id;
            $result['deal_file_deal_id'] = $new_deal_file->deal_file_deal_id;
        }
        else{
            $result['success'] = false;
            $result['file_name'] = "";
        }
        return $result;
    }

    public function uploadDealOtherFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }


        if(!(isset($request->deal_file_src))){
            $result['success'] = "not_file";
            return $result;
        }
        $file = $request->deal_file_src;
        $original_file_name = $file->getClientOriginalName();
        $file_name = time() . $request->deal_id . rand(1, 100) . "_other_file.";
        $file_extension = $file->extension($file_name);
        $file_name = $file_name . $file_extension;
        Storage::disk('deal_files')->put($file_name,  File::get($file));

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_name = $original_file_name;
        $new_deal_file->deal_file_src = $file_name;
        $new_deal_file->deal_file_type = $request->deal_file_type;
        $offset= strtotime("+6 hours 0 minutes");
        $new_deal_file->deal_file_date = date("Y-m-d H:i:s",$offset);
        $deal_file_date = date("d.m.Y H:i:s",$offset);
        if($new_deal_file->save()){
            $result['success'] = true;
            $result['deal_file_name'] = $original_file_name;
            $result['deal_file_src'] = $file_name;
            $result['deal_file_date'] = $deal_file_date;
            $result['deal_file_id'] = $new_deal_file['deal_file_id'];
            $result['deal_file_deal_id'] = $new_deal_file['deal_file_deal_id'];
        }
        else{
            $result['success'] = false;
            $result['file_name'] = "";
        }
        return $result;
    }

    function saveNewUserTask(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        if(strtotime($request->user_task_end_date) < strtotime($request->user_task_start_date)){
            return response()->json(['result'=>'incorrect_date']);
        }
        $new_task = new UserTask();
        $new_task->user_task_deal_id = $request->deal_id;
        $new_task->user_task_user_id = $request->user_task_user_id;
        $new_task->user_task_text = $request->user_task_text;
        $new_task->user_task_start_date = date('Y-m-d', strtotime($request->user_task_start_date));
        $new_task->user_task_start_time = $request->user_task_start_time;
        $new_task->user_task_end_date = date('Y-m-d', strtotime($request->user_task_end_date));
        $new_task->user_task_end_time = $request->user_task_end_time;
        $new_task->user_task_task_id = 1;

        if($new_task->save()){
            $user_row = Users::where("user_id","=",$request->user_task_user_id)->first();
            $deal_row = Deal::LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                        ->select("deals.*","stations.*","marks.*")
                        ->where("deals.deal_id","=",$request->deal_id)->first();
            if(@count($user_row) > 0 && strlen($user_row['email']) > 0){
                $email_to = "adik.khalikhov@mail.ru";

                $message_str = 'Уважаемый (-ая), ' . $user_row['user_surname'] . " " . $user_row['user_name'];
                $message_str .= '<br>У вас новая задача: ';
                $message_str .= '<br><b>Сделка:</b> ' . $deal_row['station_name'] . ' - ' .  $deal_row['mark_name'] . ' ' . $deal_row['deal_volume'] . ' тонн';
                $message_str .= '<br><b>Дата и время исполнения:</b> ' . date('d.m.Y', strtotime($request->user_task_start_date)) . ' ' .  $request['user_task_start_time'] . ' - ' . date('d.m.Y', strtotime($request->user_task_end_date)) . ' ' .  $request['user_task_end_time'];
                $message_str .= '<br><b>Текст:</b> ' . nl2br($new_task->user_task_text);
                $message_str .= '<br><b>Статус:</b> В процессе';
                $message_str .= '<br><br>Для входа в систему пройдите <a href="http://komir.megatestovik.kz/login">по ссылке</a>';
                Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function($message) use ($email_to)
                {
                    $message->to($email_to)->subject("Новая задача");
                    $message->cc("askhat@kit.systems")->subject("Новая задача");
                    $message->cc("a.yemtsev@kit.systems")->subject("Новая задача");
                });
                if(@count(Mail::failures()) > 0){
                    return response()->json(['result'=>'error_sending_mail']);
                }
            }
            else{
                return response()->json(['result'=>'error_user']);
            }
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function saveClientAnswer(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0) {
            if ($deal_row['deal_status_id'] < 3) {
                return response()->json(['result' => 'incorrect_status']);
            }
            $new_client_answer = new ClientAnswer();
            $new_client_answer->client_answer_deal_id = $request->deal_id;
            $new_client_answer->client_answer_user_id = $request->deal_user_id3;
            $offset = strtotime("+6 hours 0 minutes");
            $new_client_answer->client_answer_datetime = date("Y-m-d H:i:s", $offset);
            $new_client_answer->client_answer_text = $request->client_answer_text;
            if ($new_client_answer->save()) {
                return response()->json(['result' => true]);
            }
            else {
                return response()->json(['result' => false]);
            }
        }
        else {
            return response()->json(['result' => false]);
        }
    }

    public function deleteClientAnswer(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $client_answer_id = $request->client_answer_id;
        $result = ClientAnswer::where('client_answer_id', '=', $client_answer_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveShippingComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0){
            if($deal_row['deal_status_id'] < 8){
                return response()->json(['result'=>'incorrect_status']);
            }
            $new_shipping_comment = new ShippingComment();
            $new_shipping_comment->shipping_comment_deal_id = $request->deal_id;
            $new_shipping_comment->shipping_comment_user_id = $request->deal_user_id8;
            $offset= strtotime("+6 hours 0 minutes");
            $new_shipping_comment->shipping_comment_datetime = date("Y-m-d H:i:s",$offset);
            $new_shipping_comment->shipping_comment_text = $request->shipping_comment_text;
            if($new_shipping_comment->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function deleteShippingComment(Request $request){
        $shipping_comment_id = $request->shipping_comment_id;
        $result = ShippingComment::where('shipping_comment_id', '=', $shipping_comment_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveDeliveryComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0){
            if($deal_row['deal_status_id'] < 9){
//                return response()->json(['result'=>'incorrect_status']);
            }
            $new_delivery_comment = new DeliveryComment();
            $new_delivery_comment->delivery_comment_deal_id = $request->deal_id;
            $new_delivery_comment->delivery_comment_user_id = $request->deal_user_id9;
            $offset= strtotime("+6 hours 0 minutes");
            $new_delivery_comment->delivery_comment_datetime = date("Y-m-d H:i:s",$offset);
            $new_delivery_comment->delivery_comment_text = $request->delivery_comment_text;
            if($new_delivery_comment->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function deleteDeliveryComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $delivery_comment_id = $request->delivery_comment_id;
        $result = DeliveryComment::where('delivery_comment_id', '=', $delivery_comment_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveShippingClientComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0){
            if($deal_row['deal_status_id'] < 8){
                return response()->json(['result'=>'incorrect_status']);
            }
            $new_shipping_client_comment = new ShippingClientComment();
            $new_shipping_client_comment->shipping_comment_deal_id = $request->deal_id;
            $new_shipping_client_comment->shipping_comment_user_id = $request->deal_user_id8;
            $offset= strtotime("+6 hours 0 minutes");
            $new_shipping_client_comment->shipping_comment_datetime = date("Y-m-d H:i:s",$offset);
            $new_shipping_client_comment->shipping_client_comment_text = $request->shipping_client_comment_text;
            if($new_shipping_client_comment->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function deleteShippingClientComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $shipping_client_comment_id = $request->shipping_client_comment_id;
        $result = ShippingClientComment::where('shipping_client_comment_id', '=', $shipping_client_comment_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveDeliveryClientComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0){
            if($deal_row['deal_status_id'] < 9){
                return response()->json(['result'=>'incorrect_status']);
            }
            $new_delivery_client_comment = new DeliveryClientComment();
            $new_delivery_client_comment->delivery_comment_deal_id = $request->deal_id;
            $new_delivery_client_comment->delivery_comment_user_id = $request->deal_user_id9;
            $offset= strtotime("+6 hours 0 minutes");
            $new_delivery_client_comment->delivery_comment_datetime = date("Y-m-d H:i:s",$offset);
            $new_delivery_client_comment->delivery_client_comment_text = $request->delivery_client_comment_text;
            if($new_delivery_client_comment->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function deleteDeliveryClientComment(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $delivery_client_comment_id = $request->delivery_client_comment_id;
        $result = DeliveryClientComment::where('delivery_client_comment_id', '=', $delivery_client_comment_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function loadDealTask(Request $request){
        $deal_task_list = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
                                ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
                                ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'),DB::raw('DATE_FORMAT(user_tasks.user_task_start_date,"%d.%m.%Y") as user_task_start_date_format'))
                                ->where("user_tasks.user_task_deal_id","=",$request->deal_id)
                                ->orderByRaw(DB::raw("FIELD(user_tasks.user_task_task_id, '2', '1', '3','4')"))
                                ->orderBy("user_tasks.user_task_end_date","desc")->get();
        return view('admin.load-deal-task', ['deal_task_list' => $deal_task_list]);
    }

    public function loadClientAnswers(Request $request){
        $client_answer_list = ClientAnswer::LeftJoin("users","client_answers.client_answer_user_id","=","users.user_id")
                                    ->select("client_answers.*",DB::raw('DATE_FORMAT(client_answers.client_answer_datetime,"%d.%m.%Y %T") as client_answer_datetime_format'),"users.*")
                                    ->orderBy("client_answer_datetime","desc")->where("client_answer_deal_id","=",$request->deal_id)->get();
        return view('admin.load-client-answer', ['client_answer_list' => $client_answer_list]);
    }

    public function loadShippingComment(Request $request){
        $shipping_comment_list = ShippingComment::LeftJoin("users","shipping_comments.shipping_comment_user_id","=","users.user_id")
                                    ->select("shipping_comments.*",DB::raw('DATE_FORMAT(shipping_comments.shipping_comment_datetime,"%d.%m.%Y %T") as shipping_comment_datetime_format'),"users.*")
                                    ->orderBy("shipping_comment_datetime","desc")->where("shipping_comment_deal_id","=",$request->deal_id)->get();
        return view('admin.load-shipping-comment', ['shipping_comment_list' => $shipping_comment_list]);
    }

    public function loadDeliveryComment(Request $request){
        $delivery_comment_list = DeliveryComment::LeftJoin("users","delivery_comments.delivery_comment_user_id","=","users.user_id")
                                    ->select("delivery_comments.*",DB::raw('DATE_FORMAT(delivery_comments.delivery_comment_datetime,"%d.%m.%Y %T") as delivery_comment_datetime_format'),"users.*")
                                    ->orderBy("delivery_comment_datetime","desc")->where("delivery_comment_deal_id","=",$request->deal_id)->get();
        return view('admin.load-delivery-comment', ['delivery_comment_list' => $delivery_comment_list]);
    }

    public function loadShippingClientComment(Request $request){
        $shipping_client_comment_list = ShippingClientComment::LeftJoin("users","shipping_client_comments.shipping_comment_user_id","=","users.user_id")
                                    ->select("shipping_client_comments.*",DB::raw('DATE_FORMAT(shipping_client_comments.shipping_comment_datetime,"%d.%m.%Y %T") as shipping_comment_datetime_format'),"users.*")
                                    ->orderBy("shipping_comment_datetime","desc")->where("shipping_comment_deal_id","=",$request->deal_id)->get();
        return view('admin.load-shipping-client-comment', ['shipping_client_comment_list' => $shipping_client_comment_list]);
    }

    public function loadDeliveryClientComment(Request $request){
        $delivery_client_comment_list = DeliveryClientComment::LeftJoin("users","delivery_client_comments.delivery_comment_user_id","=","users.user_id")
                                    ->select("delivery_client_comments.*",DB::raw('DATE_FORMAT(delivery_client_comments.delivery_comment_datetime,"%d.%m.%Y %T") as delivery_comment_datetime_format'),"users.*")
                                    ->orderBy("delivery_comment_datetime","desc")->where("delivery_comment_deal_id","=",$request->deal_id)->get();
        return view('admin.load-delivery-client-comment', ['delivery_client_comment_list' => $delivery_client_comment_list]);
    }

    public function loadDealHistory(Request $request){
        $deal_history_list = DealHistory::LeftJoin("users","deal_histories.deal_history_user_id","=","users.user_id")
                                    ->select("deal_histories.*",DB::raw('DATE_FORMAT(deal_histories.deal_history_datetime,"%d.%m.%Y %T") as deal_history_datetime_format'),"users.*")
                                    ->orderBy("deal_history_datetime","desc")->where("deal_history_deal_id","=",$request->deal_id)->get();
        return view('admin.load-deal-history', ['deal_history_list' => $deal_history_list]);
    }

    public function loadDealBillFile(Request $request){
        $deal_bill_file_list = DealFile::select("deal_files.*",DB::raw('DATE_FORMAT(deal_files.deal_file_date,"%d.%m.%Y %T") as deal_file_date_format'))->
                                    where("deal_file_deal_id","=",$request->deal_id)->where("deal_file_type","=",2)->orderBy("deal_file_date","desc")->get();

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        $station_row = Station::where("station_id","=",$deal_row->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

        $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
            ->select("percents.*")
            ->where("stations.station_id","=",$station_row->station_id)
            ->first();

        $sum = 0;
        if(@count($percents_row) > 0){
            if($percents_row->percent_rate > 0){
                $sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100);
            }
            else{
                $sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate']);
            }
        }
        return view('admin.load-deal-bill-file', ['deal_bill_file_list' => $deal_bill_file_list, 'sum' => $sum]);
    }

    public function loadDealCloseFile(Request $request){
        $deal_close_file_list = DealFile::select("deal_files.*",DB::raw('DATE_FORMAT(deal_files.deal_file_date,"%d.%m.%Y %T") as deal_file_date_format'))->
                                    where("deal_file_deal_id","=",$request->deal_id)->where("deal_file_type","=",6)->orderBy("deal_file_date","desc")->get();

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        $station_row = Station::where("station_id","=",$deal_row->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

        $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
            ->select("percents.*")
            ->where("stations.station_id","=",$station_row->station_id)
            ->first();

        $sum = 0;
        if(@count($percents_row) > 0){
            if($percents_row->percent_rate > 0){
                $sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100);
            }
            else{
                $sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate']);
            }
        }

        return view('admin.load-deal-close-file', ['deal_close_file_list' => $deal_close_file_list, 'sum' => $sum]);
    }

    public function loadDealKpFile(Request $request){
        $deal_kp_file_list = DealFile::LeftJoin("marks","deal_files.deal_file_mark_id","=","marks.mark_id")
                                    ->LeftJoin("brands","deal_files.deal_file_brand_id","=","brands.brand_id")
                                    ->LeftJoin("fractions","deal_files.deal_file_fraction_id","=","fractions.fraction_id")
                                    ->LeftJoin("regions","deal_files.deal_file_region_id","=","regions.region_id")
                                    ->LeftJoin("stations","deal_files.deal_file_station_id","=","stations.station_id")
                                    ->select("deal_files.*",DB::raw('DATE_FORMAT(deal_files.deal_file_date,"%d.%m.%Y %T") as deal_file_date_format'),"marks.*","brands.*","fractions.*","regions.*","stations.*")
                                    ->where("deal_files.deal_file_deal_id","=",$request->deal_id)->where("deal_files.deal_file_type","=",1)->orderBy("deal_files.deal_file_date","desc")->get();
        return view('admin.load-deal-kp-file', ['deal_kp_file_list' => $deal_kp_file_list]);
    }

    public function loadNotifications(){
        $user_task_list = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
            ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
            ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
            ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
            ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
            ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'),DB::raw('DATE_FORMAT(user_tasks.user_task_start_date,"%d.%m.%Y") as user_task_start_date_format'), "deals.*", "stations.*","marks.*")
            ->where("user_tasks.user_task_user_id","=",Auth::user()->user_id)
            ->whereIn("user_tasks.user_task_task_id",[2,1])
            ->orderByRaw(DB::raw("FIELD(user_tasks.user_task_task_id, '2', '1')"))
            ->orderBy("user_tasks.user_task_end_date","desc")->get();

        return view('admin.load-notifications', ['user_task_list' => $user_task_list]);
    }

    public function completeUserTask(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $user_task_row = UserTask::where("user_task_id","=",$request->user_task_id)->first();
        if(@count($user_task_row) > 0){
            $offset= strtotime("+6 hours 0 minutes");
            if(strtotime($user_task_row['user_task_end_date']) < strtotime(date("Y-m-d", $offset))){
                $user_task_row->user_task_task_id = 4;
            }
            else{
                $user_task_row->user_task_task_id = 3;
            }
            $user_task_row->user_task_comment = $request->user_task_comment;
            if($user_task_row->save()){
                return response()->json(['result'=>true]);
            }
            else{
                return response()->json(['result'=>false]);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function userTaskList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $user_task_list[1] = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
                                        ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
                                        ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
                                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                                        ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                                        ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'), "deals.*", "marks.*","stations.*")
                                        ->where("user_tasks.user_task_task_id","=",1);

        if(isset($request->client_id) && $request->client_id > 0){
            $user_task_list[1] = $user_task_list[1]->where("deals.deal_client_id","=",$request->client_id);
        }
        if(isset($request->user_id) && $request->user_id > 0){
            $user_task_list[1] = $user_task_list[1]->where("user_tasks.user_task_user_id","=",$request->user_id);
        }
        if(isset($request->user_task_start_date) && strlen($request->user_task_start_date) > 0 && isset($request->user_task_end_date) && strlen($request->user_task_end_date) > 0){
            $from = date('Y-m-d 00:00:00',strtotime($request->user_task_start_date));
            $to = date('Y-m-d 23:59:59',strtotime($request->user_task_end_date));
            $user_task_list[1] = $user_task_list[1]->whereBetween('user_tasks.user_task_end_date', array($from, $to));
        }

        $user_task_list[1] = $user_task_list[1]->get();

        $user_task_list[2] = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
                                        ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
                                        ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
                                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                                        ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                                        ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'), "deals.*", "marks.*","stations.*")
                                        ->where("user_tasks.user_task_task_id","=",2);

        if(isset($request->client_id) && $request->client_id > 0){
            $user_task_list[2] = $user_task_list[2]->where("deals.deal_client_id","=",$request->client_id);
        }
        if(isset($request->user_id) && $request->user_id > 0){
            $user_task_list[2] = $user_task_list[2]->where("user_tasks.user_task_user_id","=",$request->user_id);
        }
        if(isset($request->user_task_start_date) && strlen($request->user_task_start_date) > 0 && isset($request->user_task_end_date) && strlen($request->user_task_end_date) > 0){
            $from = date('Y-m-d 00:00:00',strtotime($request->user_task_start_date));
            $to = date('Y-m-d 23:59:59',strtotime($request->user_task_end_date));
            $user_task_list[2] = $user_task_list[2]->whereBetween('user_tasks.user_task_end_date', array($from, $to));
        }

        $user_task_list[2] = $user_task_list[2]->get();

        $user_task_list[3] = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
                                        ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
                                        ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
                                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                                        ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                                        ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'), "deals.*", "marks.*","stations.*")
                                        ->where("user_tasks.user_task_task_id","=",3);

        if(isset($request->client_id) && $request->client_id > 0){
            $user_task_list[3] = $user_task_list[3]->where("deals.deal_client_id","=",$request->client_id);
        }
        if(isset($request->user_id) && $request->user_id > 0){
            $user_task_list[3] = $user_task_list[3]->where("user_tasks.user_task_user_id","=",$request->user_id);
        }
        if(isset($request->user_task_start_date) && strlen($request->user_task_start_date) > 0 && isset($request->user_task_end_date) && strlen($request->user_task_end_date) > 0){
            $from = date('Y-m-d 00:00:00',strtotime($request->user_task_start_date));
            $to = date('Y-m-d 23:59:59',strtotime($request->user_task_end_date));
            $user_task_list[3] = $user_task_list[3]->whereBetween('user_tasks.user_task_end_date', array($from, $to));
        }

        $user_task_list[3] = $user_task_list[3]->get();

        $user_task_list[4] = UserTask::LeftJoin("users","user_tasks.user_task_user_id","=","users.user_id")
                                        ->LeftJoin("tasks","user_tasks.user_task_task_id","=","tasks.task_id")
                                        ->LeftJoin("deals","user_tasks.user_task_deal_id","=","deals.deal_id")
                                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                                        ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                                        ->select("user_tasks.*","users.*","tasks.*",DB::raw('DATE_FORMAT(user_tasks.user_task_end_date,"%d.%m.%Y") as user_task_end_date_format'), "deals.*", "marks.*","stations.*")
                                        ->where("user_tasks.user_task_task_id","=",4);

        if(isset($request->client_id) && $request->client_id > 0){
            $user_task_list[4] = $user_task_list[4]->where("deals.deal_client_id","=",$request->client_id);
        }
        if(isset($request->user_id) && $request->user_id > 0){
            $user_task_list[4] = $user_task_list[4]->where("user_tasks.user_task_user_id","=",$request->user_id);
        }
        if(isset($request->user_task_start_date) && strlen($request->user_task_start_date) > 0 && isset($request->user_task_end_date) && strlen($request->user_task_end_date) > 0){
            $from = date('Y-m-d 00:00:00',strtotime($request->user_task_start_date));
            $to = date('Y-m-d 23:59:59',strtotime($request->user_task_end_date));
            $user_task_list[4] = $user_task_list[4]->whereBetween('user_tasks.user_task_end_date', array($from, $to));
        }

        $user_task_list[4] = $user_task_list[4]->get();

        $client_list = Client::orderBy("client_name","asc")->get();
        $user_list = Users::orderBy("user_surname","asc")->get();

        return view('admin.user-task-list',['user_task_list' => $user_task_list, 'client_list' => $client_list, 'user_list' => $user_list, 'user_task_start_date' => $request->user_task_start_date, 'user_task_end_date' => $request->user_task_end_date, 'client_id' => $request->client_id, 'user_id' => $request->user_id, 'task_id' => $request->task_id]);

    }

    public function companyList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row_count = 20;
        if(isset($request->row_count)){
            $row_count = $request->row_count;
        }
        $row = Company::select('companies.*');

        if(isset($request->search_word) && strlen($request->search_word) > 0){
            $row = $row->where(function($query) use ($request)
            {
                $query->where("companies.company_name","like","%" . $request->search_word . "%")->orWhere("company_ceo_position","like","%" . $request->search_word . "%")->orWhere("company_ceo_name","like","%" . $request->search_word . "%");
            });
        }
        $row = $row->paginate($row_count);
        return view('admin.company-list', [ 'row' => $row, 'row_count' => $row_count,'search_word' => $request->search_word]);
    }

    public function companyEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $company_id = $request->company_id;

        $row = Company::select("companies.*")
            ->where("company_id","=",$company_id)->first();
        if(@count($row) < 1){
            $row = new Company();
            $row->company_id = 0;
        }

        return view('admin.company-edit', ['row' => $row]);
    }

    public function deleteCompany(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $company_id = $request->company_id;
        $result = Company::where('company_id', '=', $company_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveCompany(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        if($request->company_id > 0) {
            $company_item = Company::find($request->company_id);
        }
        else {
            $company_item = new Company();
        }

        $company_item->company_name = $request->company_name;
        $company_item->company_ceo_position = $request->company_ceo_position;
        $company_item->company_ceo_name = $request->company_ceo_name;
        $company_item->company_address = $request->company_address;
        $company_item->company_bank_id = $request->company_bank_id;
        $company_item->company_bank_iik = $request->company_bank_iik;
        $company_item->company_bank_bin = $request->company_bank_bin;
        $company_item->company_delivery_address = $request->company_delivery_address;
        $company_item->company_okpo = $request->company_okpo;
        if($company_item['company_is_discount'] == "on"){
            $company_item['company_is_discount'] = 1;
        }

        if($company_item->save()){
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function systemInfoList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row = SystemInfo::all();
        return view('admin.system-info-list', [ 'row' => $row]);
    }

    public function systemInfoEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $system_info_id = $request->system_info_id;

        $row = SystemInfo::select("system_info.*")->where("system_info_id","=",$system_info_id)->first();
        if(@count($row) < 1){
            $row = new SystemInfo();
            $row->system_info_id = 0;
        }

        return view('admin.system-info-edit', ['row' => $row]);
    }

    public function saveSystemInfo(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $old_file_name = "";
        if($request->system_info_id > 0) {
            $system_info_item = SystemInfo::find($request->system_info_id);
            $old_file_name = $system_info_item->system_info_img;
        }
        else {
            $system_info_item = new SystemInfo();
        }

        if($request->hasFile('system_info_img')){
            $this->deleteFile("system_info_img",$old_file_name);
            $file = $request->system_info_img;
            $file_name = time() . "_sim.";
            $file_extension = $file->extension($file_name);
            $file_name = $file_name . $file_extension;
            Storage::disk('system_info_img')->put($file_name,  File::get($file));
            $system_info_item->system_info_img = $file_name;
        }

        $system_info_item->system_info_company_name = $request->system_info_company_name;
        $system_info_item->system_info_bank_id = $request->system_info_bank_id;
        $system_info_item->system_info_bank_iik = $request->system_info_bank_iik;
        $system_info_item->system_info_bank_bin = $request->system_info_bank_bin;
        $system_info_item->system_info_bank_kbe = $request->system_info_bank_kbe;
        $system_info_item->system_info_bank_code = $request->system_info_bank_code;
        $system_info_item->system_info_address = $request->system_info_address;
        $system_info_item->system_info_fio = $request->system_info_fio;

        if($system_info_item->save()){
            return redirect('/admin/system-info-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.system-info-edit', [ 'row' => $request, 'result' => $result ]);
        }
    }

    public function calculateDealKpSum(Request $request){
        $station_row = Station::where("station_id","=",$request->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$request->deal_region_id)->first();

        $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                            ->select("percents.*")
                            ->where("stations.station_id","=",$request->deal_station_id)
                            ->first();
        if(@count($percents_row) > 0){
            if($percents_row->percent_rate > 0){
                $sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100)*$request->deal_volume;
            }
            else{
                $sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate'])*$request->deal_volume;
            }

            return response()->json(['result'=>true, 'sum' => floor($sum)]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function formulateDealKpSum(Request $request){
        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        $next_file_order_num = $deal_row->file_order_num + 1;

        $deal_row->file_order_num = $next_file_order_num;
        $deal_row->deal_brand_id = $request->deal_brand_id;
        $deal_row->deal_mark_id = $request->deal_mark_id;
        $deal_row->deal_fraction_id = $request->deal_fraction_id;
        $deal_row->deal_region_id = $request->deal_region_id;
        $deal_row->deal_station_id = $request->deal_station_id;
        $deal_row->deal_kp_sum = $request->deal_kp_sum;
        $deal_row->deal_volume = $request->deal_volume;

        $deal_row->save();

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",1)->first();
        $deal_template_text = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);

        $pdf = PDF::loadView('admin.test-pdf',['deal_template_text' => $deal_template_text]);
        $offset = strtotime("+6 hours 0 minutes");
        $deal_file_src = "кп_komir_kz_" . date("dmY",$offset) . "_" . $deal_row->file_order_num . '.pdf';
        $pdf->save('deal_files/' . $deal_file_src);

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_brand_id = $request->deal_brand_id;
        $new_deal_file->deal_file_mark_id = $request->deal_mark_id;
        $new_deal_file->deal_file_fraction_id = $request->deal_fraction_id;
        $new_deal_file->deal_file_region_id = $request->deal_region_id;
        $new_deal_file->deal_file_station_id = $request->deal_station_id;
        $new_deal_file->deal_file_deal_kp_sum = $request->deal_kp_sum;
        $new_deal_file->deal_file_deal_volume = $request->deal_volume;
        $new_deal_file->deal_file_name = $deal_file_src;
        $new_deal_file->deal_file_src = $deal_file_src;
        $new_deal_file->deal_file_type = 1;
        $offset= strtotime("+6 hours 0 minutes");
        $new_deal_file->deal_file_date = date("Y-m-d H:i:s",$offset);
         if($new_deal_file->save()){
             return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function calculateDealRestVolumeSum(Request $request){
        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        $station_row = Station::where("station_id","=",$deal_row->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

        $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
                            ->select("percents.*")
                            ->where("stations.station_id","=",$station_row->station_id)
                            ->first();
        if(@count($percents_row) > 0){
            if($percents_row->percent_rate > 0){
                $sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100)*$request->deal_rest_volume;
            }
            else{
                $sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate'])*$request->deal_rest_volume;
            }

            return response()->json(['result'=>true, 'sum' => floor($sum)]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function dealTemplateFileList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $row = DealTemplateFile::orderBy("deal_template_type_id")->get();
        return view('admin.deal-template-file-list', [ 'row' => $row]);
    }

    public function dealTemplateFileEdit(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_template_file_id = $request->deal_template_file_id;

        $row = DealTemplateFile::find($deal_template_file_id);
        if(@count($row) < 1){
            $row = new DealTemplateFile();
            $row->deal_template_file_id = 0;
        }
        return view('admin.deal-template-file-edit', ['row' => $row]);
    }

    public function deleteDealTemplateFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_template_file_id = $request->deal_template_file_id;
        $result = DealTemplateFile::where('deal_template_file_id', '=', $deal_template_file_id)->delete();
        return response()->json(['result'=>$result]);
    }

    public function saveDealTemplateFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $messages = array(
            'deal_template_type_id.not_in' => 'Укажите Тип шаблона файла',
            'deal_template_text.required' => 'Укажите HTML шаблона файла'
        );
        $validator = Validator::make($request->all(), [
            'deal_template_type_id' => 'required|not_in:0',
            'deal_template_text' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $result['value'] = $error;
            $result['status'] = false;
            $role_list = Role::all();
            return view('admin.deal-template-file-edit', [ 'row' => $request, 'role_list' => $role_list, 'result' => $result ]);
        }

        if($request->deal_template_file_id > 0) {
            $deal_template_file_item = DealTemplateFile::find($request->deal_template_file_id);
        }
        else {
            $deal_template_file_item = new DealTemplateFile();
        }

        $deal_template_file_item->deal_template_type_id = $request->deal_template_type_id;
        $deal_template_file_item->deal_template_mail_title = $request->deal_template_mail_title;
        $deal_template_file_item->deal_template_text = $request->deal_template_text;

        if($deal_template_file_item->save()){
            return redirect('/admin/deal-template-file-list');
        }
        else{
            $error[0] = 'Ошибка при сохранении';
            $result['value'] = $error;
            $result['status'] = false;
            return view('admin.deal-template-file-edit', [ 'row' => $request, 'result' => $result ]);
        }
    }

    public function uploadDealDogovorFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $this->deleteFile("file_template","dogovor_filetemplate.docx");
        $file = $request->deal_dogovor_file;
        $file_name = "dogovor_filetemplate.";
        $file_extension = $file->extension($file_name);
        $file_name = $file_name . $file_extension;
        Storage::disk('file_template')->put($file_name, File::get($file));
        return response()->json(['result'=>true]);
    }

    public function downloadDealKp(Request $request, $is_static_call = 0){
        if(!Auth::check()){
            return redirect('/login');
        }

//        $deal_kp_file_row = DealFile::where("deal_file_deal_id","=",$request->deal_id)->where("deal_file_type","=",1)->first();
//        if(@count($deal_kp_file_row) > 0 && strlen($deal_kp_file_row['deal_file_src']) > 0){
//            $this->deleteFile("deal_files",$deal_kp_file_row['deal_file_src']);
//            $delete_result = DealFile::where('deal_file_id', '=', $deal_kp_file_row['deal_file_id'])->delete();
//        }

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",1)->first();
        $deal_template_text = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);

//        return view('admin.test-pdf', [ 'deal_template_text' => $deal_template_text]);
        $pdf = PDF::loadView('admin.test-pdf',['deal_template_text' => $deal_template_text]);
        $offset = strtotime("+6 hours 0 minutes");
        $deal_file_src = "кп_komir_kz_" . date("dmY_His",$offset) . "_" . $request->deal_id . '.pdf';
        $pdf->save('deal_files/' . $deal_file_src);

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_name = $deal_file_src;
        $new_deal_file->deal_file_src = $deal_file_src;
        $new_deal_file->deal_file_type = 1;
        $offset= strtotime("+6 hours 0 minutes");
        $new_deal_file->deal_file_date = date("Y-m-d H:i:s",$offset);
        if($new_deal_file->save()){
            $result['result'] = true;
            $result['filename'] = '/deal_files/' . $deal_file_src;
            $result['filename2'] = 'deal_files/' . $deal_file_src;
            $result['file_name'] = $deal_file_src;
        }
        else{
            $result['result'] = false;
        }
        if($is_static_call == 1){
            return $result;
        }
        else{
            return response()->json(['result'=>$result]);
        }
    }

    public function sendKpMail(Request $request){
        $deal_kp_file_row = DealFile::where("deal_file_deal_id","=",$request->deal_id)->where("deal_file_type","=",1)->orderBy("deal_file_date","desc")->first();
        $email_to = "adik.khalikhov@mail.ru";

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",4)->first();
        $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);
        $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$request->deal_id);

        Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function($message) use ($email_to,$deal_kp_file_row,$mail_title)
        {
            $message->to($email_to)->subject($mail_title);
            $message->cc("askhat@kit.systems")->subject($mail_title);
            $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
            $message->attach("deal_files/" . $deal_kp_file_row['deal_file_src'], ['as' => $deal_kp_file_row['deal_file_name'], 'mime' => 'application/pdf']);
        });
        if(@count(Mail::failures()) > 0){
            return response()->json(['result'=>false]);
        }
        else{
            return response()->json(['result'=>true]);
        }
    }

    public function sendDeliveryClientCommentEmail(Request $request){
        $delivery_client_comment_row = DeliveryClientComment::where("delivery_client_comment_id","=",$request->delivery_client_comment_id)->first();
        $email_to = "adik.khalikhov@mail.ru";

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",8)->first();
        $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$delivery_client_comment_row->delivery_comment_deal_id);
        $message_str = str_replace('${delivery_client_comment_text}',$delivery_client_comment_row->delivery_client_comment_text, $message_str);
        $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$delivery_client_comment_row->delivery_comment_deal_id);

        Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function($message) use ($email_to,$mail_title)
        {
            $message->to($email_to)->subject($mail_title);
            $message->cc("askhat@kit.systems")->subject($mail_title);
            $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
        });
        if(@count(Mail::failures()) > 0){
            return response()->json(['result'=>false]);
        }
        else{
            return response()->json(['result'=>true]);
        }
    }

    public function sendShippingClientCommentEmail(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        $shipping_client_comment_row = ShippingClientComment::where("shipping_client_comment_id","=",$request->shipping_client_comment_id)->first();
        $email_to = "adik.khalikhov@mail.ru";

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",7)->first();
        $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);
        $message_str = str_replace('${shipping_client_comment_text}',$shipping_client_comment_row->shipping_client_comment_text, $message_str);

        $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$request->deal_id);

        Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function($message) use ($email_to,$mail_title)
        {
            $message->to($email_to)->subject($mail_title);
            $message->cc("askhat@kit.systems")->subject($mail_title);
            $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
        });
        if(@count(Mail::failures()) > 0){
            return response()->json(['result'=>false]);
        }
        else{
            return response()->json(['result'=>true]);
        }
    }

    public function createDealBillFile(Request $request, $is_static_call = 0){
        if(!Auth::check()){
            return redirect('/login');
        }

        $system_info_row = SystemInfo::where("system_info_id","=",1)->first();
        $system_info_row->system_info_bill_num += 1;
        $system_info_row->save();

        $offset= strtotime("+6 hours 0 minutes");
        $deal_file_date = date("Y-m-d H:i:s",$offset);
        $deal_file_date2 = date("d.m.Y H:i:s",$offset);

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",2)->first();
        $deal_template_text = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id, $system_info_row->system_info_bill_num, $request->deal_bill_volume,$deal_file_date2);
        $pdf = PDF::loadView('admin.test-pdf',['deal_template_text' => $deal_template_text]);
        $deal_file_src = time() . $request->deal_id . '_bill.pdf';
        $pdf->save('deal_files/' . $deal_file_src);

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_bill_num = $system_info_row->system_info_bill_num;
        $new_deal_file->deal_bill_volume = $request->deal_bill_volume;
        $new_deal_file->deal_file_name = $deal_file_src;
        $new_deal_file->deal_file_src = $deal_file_src;
        $new_deal_file->deal_file_type = 2;

        $new_deal_file->deal_file_date = $deal_file_date;
        if($new_deal_file->save()){
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function createDealCloseFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $system_info_row = SystemInfo::where("system_info_id","=",1)->first();
        $system_info_row->system_info_bill_num += 1;
        $system_info_row->save();

        $offset= strtotime("+6 hours 0 minutes");
        $deal_file_date = date("Y-m-d H:i:s",$offset);
        $deal_file_date2 = date("d.m.Y H:i:s",$offset);

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",9)->first();
        $deal_template_text = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id, $system_info_row->system_info_bill_num, $request->deal_bill_volume,$deal_file_date2);
        $pdf = PDF::loadView('admin.test-pdf',['deal_template_text' => $deal_template_text]);
        $deal_file_src = time() . $request->deal_id . '_close.pdf';
        $pdf->save('deal_files/' . $deal_file_src);

        $new_deal_file = new DealFile();
        $new_deal_file->deal_file_deal_id = $request->deal_id;
        $new_deal_file->deal_file_bill_num = $system_info_row->system_info_bill_num;
        $new_deal_file->deal_bill_volume = $request->deal_bill_volume;
        $new_deal_file->deal_file_name = $deal_file_src;
        $new_deal_file->deal_file_src = $deal_file_src;
        $new_deal_file->deal_file_type = 6;

        $new_deal_file->deal_file_date = $deal_file_date;
        if($new_deal_file->save()){
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function sendBillMail(Request $request){
        $deal_bill_file_row = DealFile::where("deal_file_id","=",$request->deal_file_id)->where("deal_file_deal_id","=",$request->deal_file_deal_id)->first();
        if(@count($deal_bill_file_row) > 0) {
            $email_to = "adik.khalikhov@mail.ru";

            $deal_file_row = DealFile::where("deal_file_id","=",$request->deal_file_id)->first();

            $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",5)->first();
            $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_file_deal_id,$deal_file_row->deal_file_bill_num,$deal_file_row->deal_bill_volume);
            $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$request->deal_file_deal_id,$deal_file_row->deal_file_bill_num,$deal_file_row->deal_bill_volume);

            Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function ($message) use ($email_to, $deal_bill_file_row,$mail_title) {
                $message->to($email_to)->subject($mail_title);
                $message->cc("askhat@kit.systems")->subject($mail_title);
                $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
                $message->attach("deal_files/" . $deal_bill_file_row['deal_file_src'], ['as' => $deal_bill_file_row['deal_file_name'], 'mime' => 'application/pdf']);
            });
            if (@count(Mail::failures()) > 0) {
                return response()->json(['result' => false]);
            }
            else {
                return response()->json(['result' => true]);
            }
        }
        else {
            return response()->json(['result' => false]);
        }
    }

    public function sendBillMailClose(Request $request){
        $deal_bill_file_row = DealFile::where("deal_file_id","=",$request->deal_file_id)->where("deal_file_deal_id","=",$request->deal_file_deal_id)->first();
        if(@count($deal_bill_file_row) > 0) {
            $email_to = "adik.khalikhov@mail.ru";

            $deal_file_row = DealFile::where("deal_file_id","=",$request->deal_file_id)->first();

            $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",10)->first();
            $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_file_deal_id,$deal_file_row->deal_file_bill_num,$deal_file_row->deal_bill_volume);
            $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$request->deal_file_deal_id,$deal_file_row->deal_file_bill_num,$deal_file_row->deal_bill_volume);

            Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function ($message) use ($email_to, $deal_bill_file_row,$mail_title) {
                $message->to($email_to)->subject($mail_title);
                $message->cc("askhat@kit.systems")->subject($mail_title);
                $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
                $message->attach("deal_files/" . $deal_bill_file_row['deal_file_src'], ['as' => $deal_bill_file_row['deal_file_name'], 'mime' => 'application/pdf']);
            });
            if (@count(Mail::failures()) > 0) {
                return response()->json(['result' => false]);
            }
            else {
                return response()->json(['result' => true]);
            }
        }
        else {
            return response()->json(['result' => false]);
        }
    }

    public function deleteDealFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_file_row = DealFile::where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_id","=",$request->deal_file_id)->first();
        if(@count($deal_file_row) > 0){
            $this->deleteFile("deal_files",$deal_file_row['deal_file_src']);
        }
        $result = DealFile::where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_id","=",$request->deal_file_id)->delete();
        return response()->json(['result'=>true]);
    }

    public function deleteDealKpFile(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_file_deal_id)->first();
        $last_deal_file_row = DealFile::where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_type","=",1)->orderBy("deal_file_date","desc")->first();

        $deal_file_row = DealFile::where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_id","=",$request->deal_file_id)->first();
        if(@count($deal_file_row) > 0){
            $this->deleteFile("deal_files",$deal_file_row['deal_file_src']);
        }

        if($deal_file_row['deal_file_id'] == $last_deal_file_row['deal_file_id']){
            $prelast_deal_file_row = DealFile::where("deal_file_id","!=",$last_deal_file_row['deal_file_id'])->where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_type","=",1)->orderBy("deal_file_date","desc")->first();
            if(@count($prelast_deal_file_row) > 0){
                $deal_row->deal_brand_id = $prelast_deal_file_row['deal_file_brand_id'];
                $deal_row->deal_mark_id = $prelast_deal_file_row['deal_file_mark_id'];
                $deal_row->deal_fraction_id = $prelast_deal_file_row['deal_file_fraction_id'];
                $deal_row->deal_region_id = $prelast_deal_file_row['deal_file_region_id'];
                $deal_row->deal_station_id = $prelast_deal_file_row['deal_file_station_id'];
                $deal_row->deal_kp_sum = $prelast_deal_file_row['deal_file_deal_kp_sum'];
                $deal_row->deal_volume = $prelast_deal_file_row['deal_file_deal_volume'];
                $deal_row->save();
            }
        }
        $result = DealFile::where("deal_file_deal_id","=",$request->deal_file_deal_id)->where("deal_file_id","=",$request->deal_file_id)->delete();
        return response()->json(['result'=>true, 'deal_row' => $deal_row]);
    }

    public function replaceDealFileTemplate($deal_template_text,$deal_file_deal_id, $deal_file_bill_num = 0, $deal_bill_volume = 0, $deal_file_date = ""){
        $deal_row = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
                        ->LeftJoin("brands","deals.deal_brand_id","=","brands.brand_id")
                        ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
                        ->LeftJoin("fractions","deals.deal_fraction_id","=","fractions.fraction_id")
                        ->LeftJoin("regions","deals.deal_region_id","=","regions.region_id")
                        ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
                        ->LeftJoin("companies","clients.client_company_id","=","companies.company_id")
                        ->LeftJoin("users as users1","deals.deal_user_id1","=","users1.user_id")
                        ->LeftJoin("users as users2","deals.deal_user_id2","=","users2.user_id")
                        ->LeftJoin("users as users3","deals.deal_user_id3","=","users3.user_id")
                        ->LeftJoin("users as users4","deals.deal_user_id4","=","users4.user_id")
                        ->LeftJoin("users as users5","deals.deal_user_id5","=","users5.user_id")
                        ->LeftJoin("users as users6","deals.deal_user_id6","=","users6.user_id")
                        ->LeftJoin("users as users7","deals.deal_user_id7","=","users7.user_id")
                        ->LeftJoin("users as users8","deals.deal_user_id8","=","users8.user_id")
                        ->LeftJoin("users as users9","deals.deal_user_id9","=","users9.user_id")
                        ->LeftJoin("users as users10","deals.deal_user_id10","=","users10.user_id")
                        ->LeftJoin("banks as company_banks","companies.company_bank_id","=","company_banks.bank_id")
                        ->select("deals.*","clients.*","brands.*","marks.*","fractions.*","regions.*","stations.*",
                            "companies.*", "company_banks.bank_name as company_bank_name",
                            DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime2,"%d.%m.%Y %T") as deal_datetime2'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime3,"%d.%m.%Y %T") as deal_datetime3'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime4,"%d.%m.%Y %T") as deal_datetime4'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime5,"%d.%m.%Y %T") as deal_datetime5'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime6,"%d.%m.%Y %T") as deal_datetime6'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime7,"%d.%m.%Y %T") as deal_datetime7'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime8,"%d.%m.%Y %T") as deal_datetime8'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime9,"%d.%m.%Y %T") as deal_datetime9'),
                            DB::raw('DATE_FORMAT(deals.deal_datetime10,"%d.%m.%Y %T") as deal_datetime10'),
                            DB::raw('DATE_FORMAT(deals.deal_shipping_date,"%d/%m/%Y") as deal_shipping_date'),
                            DB::raw('DATE_FORMAT(deals.deal_delivery_date,"%d/%m/%Y") as deal_delivery_date'),
                            DB::raw('DATE_FORMAT(brands.brand_dogovor_date,"%d/%m/%Y") as brand_dogovor_date'),
                            "users1.user_surname as user_surname1","users1.user_name as user_name1",
                            "users2.user_surname as user_surname2","users2.user_name as user_name2",
                            "users3.user_surname as user_surname3","users3.user_name as user_name3",
                            "users4.user_surname as user_surname4","users4.user_name as user_name4",
                            "users5.user_surname as user_surname5","users5.user_name as user_name5",
                            "users6.user_surname as user_surname6","users6.user_name as user_name6",
                            "users7.user_surname as user_surname7","users7.user_name as user_name7",
                            "users8.user_surname as user_surname8","users8.user_name as user_name8",
                            "users9.user_surname as user_surname9","users9.user_name as user_name9",
                            "users10.user_surname as user_surname10","users10.user_name as user_name10"
                        )
                        ->where("deal_id","=",$deal_file_deal_id)->first();
        $replace_var_arr = ['deal_datetime1', 'deal_datetime2', 'deal_datetime3',
                            'deal_datetime4','deal_datetime5','deal_datetime6','deal_datetime7',
                            'deal_datetime8','deal_datetime9','deal_datetime10',
                            'deal_datetime1_str', 'deal_datetime2_str', 'deal_datetime3_str',
                            'deal_datetime4_str','deal_datetime5_str','deal_datetime6_str','deal_datetime7_str',
                            'deal_datetime8_str','deal_datetime9_str','deal_datetime10_str',
                            "user_surname1", "user_name1",
                            "user_surname2", "user_name2",
                            "user_surname3", "user_name3",
                            "user_surname4", "user_name4",
                            "user_surname5", "user_name5",
                            "user_surname6", "user_name6",
                            "user_surname7", "user_name7",
                            "user_surname8", "user_name8",
                            "user_surname9", "user_name9",
                            "user_surname10", "user_name10",
                            'status_name',"brand_name","mark_name",
                            "fraction_name","region_name","station_name","payment_name",
                            "deal_volume","deal_discount_type","deal_discount","delivery_name","deal_receiver_code",
                            "deal_brand_sum","deal_kp_sum", "deal_kp_sum_str", "deal_shipping_date", "deal_shipping_date_str", "deal_shipping_time","deal_delivery_date", "deal_delivery_date_str","deal_delivery_time",
                            'client_surname', 'client_name', "client_phone","client_email",
                            "company_name","company_ceo_position","company_ceo_name", "company_address","company_bank_iik", "company_bank_bin","company_delivery_address","company_okpo", "company_bank_name",
                            "deal_file_bill_num", "deal_bill_sum", "deal_bill_sum_str", "deal_bill_volume", "deal_bill_tonn_sum",
                            "system_info_company_name", "system_info_bank_name","system_info_bank_iik","system_info_bank_bin","system_info_bank_kbe",
                            "system_info_bank_code","system_info_address","system_info_img","system_info_fio",
                            "deal_fact_volume","deal_rest_volume","deal_rest_volume_in_sum",
                            "brand_email","brand_company_name","brand_company_ceo_name","brand_dogovor_num","brand_dogovor_date","brand_props","deal_file_date", "station_code","deal_wagon_count"];

        $system_info_row = SystemInfo::LeftJoin("banks","system_info.system_info_bank_id","=","banks.bank_id")
                        ->select("system_info.*",'banks.bank_name as system_info_bank_name')
                        ->where("system_info_id","=",1)->first();

        $station_row = Station::where("station_id","=",$deal_row->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

        $deal_bill_tonn_sum = 0;
        $percents_row = Station::LeftJoin("percents","stations.station_brand_id","=","percents.percent_brand_id")
            ->select("percents.*")
            ->where("stations.station_id","=",$deal_row->deal_station_id)
            ->first();
        if(@count($percents_row) > 0){
            if($percents_row->percent_rate > 0){
                $deal_bill_tonn_sum = (($station_row['station_rate_nds']+$region_row['region_price_nds'])+ ($station_row['station_rate_nds']+$region_row['region_price_nds'])*$percents_row['percent_rate']/100);
            }
            else{
                $deal_bill_tonn_sum = ($station_row['station_rate_nds']+$region_row['region_price_nds']+$percents_row['percent_sum_rate']);
            }
        }

        foreach($replace_var_arr as $key => $replace_var_arr_item){
            $value = $deal_row[$replace_var_arr_item];
            if($replace_var_arr_item == 'deal_kp_sum' || $replace_var_arr_item == 'deal_volume' || $replace_var_arr_item == 'deal_brand_sum'){
                $value = preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $deal_row[$replace_var_arr_item]);
            }
            else if($replace_var_arr_item == 'deal_bill_sum_str'){
                $value = $this->num2str($deal_bill_volume*$deal_bill_tonn_sum);
            }
            else if($replace_var_arr_item == "deal_kp_sum_str"){
                $value = $this->num2str($deal_row['deal_kp_sum']);
            }
            else if($replace_var_arr_item == "deal_wagon_count"){
                $value = ceil($deal_row['deal_volume']/70);
            }
            else if($replace_var_arr_item == "deal_file_date"){
                $value = $deal_file_date;
            }
            else if($replace_var_arr_item == 'deal_datetime1_str' || $replace_var_arr_item == 'deal_datetime2_str'
                || $replace_var_arr_item == 'deal_datetime3_str' || $replace_var_arr_item == 'deal_datetime4_str'
                || $replace_var_arr_item == 'deal_datetime5_str' || $replace_var_arr_item == 'deal_datetime6_str'
                || $replace_var_arr_item == 'deal_datetime7_str' || $replace_var_arr_item == 'deal_datetime8_str'
                || $replace_var_arr_item == 'deal_datetime9_str' || $replace_var_arr_item == 'deal_datetime10_str'
                || $replace_var_arr_item == 'deal_shipping_date_str' || $replace_var_arr_item == 'deal_delivery_date_str'){
                if(strlen($deal_row[str_replace("_str","",$replace_var_arr_item)]) > 0) {
                    $value = $this->dateToStr($deal_row[str_replace("_str", "", $replace_var_arr_item)]);
                }
                else{
                    $value = "";
                }
            }
            else if($replace_var_arr_item == 'deal_bill_tonn_sum'){
                $value = floor($deal_bill_tonn_sum);
            }
            else if($replace_var_arr_item == 'deal_bill_volume'){
                $value = $deal_bill_volume;
            }
            else if($replace_var_arr_item == 'deal_file_bill_num'){
                $value = $deal_file_bill_num;
            }
            else if($replace_var_arr_item == "system_info_company_name" || $replace_var_arr_item ==  "system_info_bank_name"
                || $replace_var_arr_item == "system_info_bank_iik" || $replace_var_arr_item == "system_info_bank_bin"
                || $replace_var_arr_item == "system_info_bank_kbe" || $replace_var_arr_item == "system_info_bank_code"
                || $replace_var_arr_item == "system_info_address" || $replace_var_arr_item == "system_info_img"
                || $replace_var_arr_item == "system_info_fio"){
                if($replace_var_arr_item == 'system_info_img'){
                    $value = "/system_info_img/" . $system_info_row['system_info_img'];
                }
                else{
                    $value = $system_info_row[$replace_var_arr_item];
                }
            }
            else if($replace_var_arr_item == 'deal_bill_sum'){
                $sum = floor($deal_bill_volume*$deal_bill_tonn_sum);
                $value = preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $sum);
            }

            $deal_template_text = str_replace('${' . $replace_var_arr_item . '}',$value, $deal_template_text);
        }
        return $deal_template_text;
    }

    public function sendDealRefuseForm(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        $deal_row = Deal::where("deal_id","=",$request->deal_id)->first();
        if(@count($deal_row) > 0){
            if($deal_row['deal_status_id'] >= 3){
                $status_row = Status::where("status_id","=",$deal_row['deal_status_id'])->first();
                $deal_row->deal_status_id = 12;
                if($deal_row->save()){
                    $user_row = Users::where("user_id","=",$request->deal_refuse_user_id)->first();
                    $deal_history_str = "<b>Этап: </b> " . $status_row->status_name . "<br>";
                    $deal_history_str .= "<b>Ответственный:</b> " . $user_row->user_surname . " " . $user_row->user_name . "<br>";
                    $deal_history_str .= "<b>Причина отказа:</b> " . $request->comment;

                    $new_deal_history = new DealHistory();
                    $new_deal_history->deal_history_deal_id = $request->deal_id;
                    $new_deal_history->deal_history_user_id = $request->deal_refuse_user_id;
                    $offset= strtotime("+6 hours 0 minutes");
                    $new_deal_history->deal_history_datetime = date("Y-m-d H:i:s", $offset);
                    $new_deal_history->deal_history_text = $deal_history_str;
                    if($new_deal_history->save()){
                        return response()->json(['result'=>true]);
                    }
                    else{
                        return response()->json(['result'=>false]);
                    }
                }
                else{
                    return response()->json(['result'=>false]);
                }
            }
            else{
                return response()->json(['result'=>'incorrect_status']);
            }
        }
        else{
            return response()->json(['result'=>false]);
        }
    }

    public function getStationByRegion(Request $request){
        $station_list = Station::where("station_region_id","=",$request->region_id)->get();
        return view('admin.load-station-by-region', ['station_list' => $station_list]);
    }

    public function getFractionByBrand(Request $request){
        $fraction_list = Fraction::where("fraction_brand_id","=",$request->brand_id)->get();
        return view('admin.load-fraction-by-brand', ['fraction_list' => $fraction_list]);
    }

    public function getMarkByBrand(Request $request){
        $mark_list = Mark::where("mark_brand_id","=",$request->brand_id)->get();
        return view('admin.load-mark-by-brand', ['mark_list' => $mark_list]);
    }

    public function getRegionByBrand(Request $request){
        $region_list = Region::where("region_brand_id","=",$request->brand_id)->get();
        return view('admin.load-region-by-brand', ['region_list' => $region_list]);
    }

    public function importExportStationList(){
        if(!Auth::check()){
            return redirect('/login');
        }

        $region_list = Region::orderBy("region_name","asc")->get();
        $brand_list = Brand::orderBy("brand_name","asc")->get();
        return view('admin.import-export-station-list', ['region_list' => $region_list, 'brand_list' => $brand_list]);
    }

    public function importStationList(Request $request){
        if(!Auth::check()){
            return redirect('/login');
        }

        try {
            if($request->is_new_import == 1){
                \Excel::import(new StationImport($request->station_region_id,$request->station_brand_id,$request->is_new_import), $request->file('import_file_new'));
            }
            else{
                \Excel::import(new StationImport($request->station_region_id,$request->station_brand_id,$request->is_new_import), $request->file('import_file'));
            }
            return response()->json(['result'=>true]);
        } catch ( \Exception $e) {
            return response()->json(['result'=>$e->errorInfo]);
        }
    }

    public function exportStationList(){
        if(!Auth::check()){
            return redirect('/login');
        }

        \Excel::store(new StationExport(), 'тарифы.xlsx', 'export_files', null, [
            'visibility' => 'private',
        ]);
        return response()->json(['filename'=>'/export_files/тарифы.xlsx']);
    }


    public function num2str($num) {
        $nul = 'ноль';
        $ten = array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20 = array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens = array(2 => 'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred = array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit = array( // Units
            array('тиын' ,'тиын' ,'тиын', 1),
            array('тенге'  ,'тенге'  ,'тенге' ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч' ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($uah,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($uah)>0) {
            foreach(str_split($uah,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;

        $out[] = $this->morph(intval($uah), $unit[1][0],$unit[1][1],$unit[1][2]); // rub

        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop

        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));

        return $num;
    } // end num2str

    public function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

    public function dateToStr($set_date){
        $date=explode(".", date("d.m.Y", strtotime($set_date)));
        switch ($date[1]){
            case 1: $m='января'; break;
            case 2: $m='февраля'; break;
            case 3: $m='марта'; break;
            case 4: $m='апреля'; break;
            case 5: $m='мая'; break;
            case 6: $m='июня'; break;
            case 7: $m='июля'; break;
            case 8: $m='августа'; break;
            case 9: $m='сентября'; break;
            case 10: $m='октября'; break;
            case 11: $m='ноября'; break;
            case 12: $m='декабря'; break;
        }
        return $date[0].' '.$m.' '.$date[2] . " г.";
    }

    public function cronUpdateUserTaskStatus(){
        $user_task_list = UserTask::where("user_task_task_id","=",1)->whereDate('user_task_end_date', '<=', date("Y-m-d"))->get();
        if(@count($user_task_list) > 0){
            foreach($user_task_list as $key => $user_task_item){
                $offset= strtotime("+6 hours 0 minutes");
                if (strtotime(date("Y-m-d H:i:s",$offset)) > strtotime(date("Y-m-d H:i:s",strtotime($user_task_item['user_task_end_date'] . " " .$user_task_item['user_task_end_time'] . ":00")))) {
                    $user_task_row = UserTask::where("user_task_id","=",$user_task_item['user_task_id'])->first();
                    $user_task_row->user_task_task_id = 2;
                    $user_task_row->save();
                }
            }
        }
    }

    public function cronUpdateDealBillNum(){
        $system_info_row = SystemInfo::where("system_info_id","=",1)->first();
        if(strtotime($system_info_row['system_info_bill_year']) < strtotime(date("Y"))){
            $system_info_row->system_info_bill_num = 0;
            $system_info_row->system_info_bill_year = date("Y");
            $system_info_row->save();
        }
    }

    public function createDogovor($deal_id){
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file_template/dogovor_filetemplate.docx');

        $deal_row = Deal::LeftJoin("clients","deals.deal_client_id","=","clients.client_id")
            ->LeftJoin("brands","deals.deal_brand_id","=","brands.brand_id")
            ->LeftJoin("marks","deals.deal_mark_id","=","marks.mark_id")
            ->LeftJoin("fractions","deals.deal_fraction_id","=","fractions.fraction_id")
            ->LeftJoin("regions","deals.deal_region_id","=","regions.region_id")
            ->LeftJoin("stations","deals.deal_station_id","=","stations.station_id")
            ->LeftJoin("companies","clients.client_company_id","=","companies.company_id")
            ->LeftJoin("users as users1","deals.deal_user_id1","=","users1.user_id")
            ->LeftJoin("users as users2","deals.deal_user_id2","=","users2.user_id")
            ->LeftJoin("users as users3","deals.deal_user_id3","=","users3.user_id")
            ->LeftJoin("users as users4","deals.deal_user_id4","=","users4.user_id")
            ->LeftJoin("users as users5","deals.deal_user_id5","=","users5.user_id")
            ->LeftJoin("users as users6","deals.deal_user_id6","=","users6.user_id")
            ->LeftJoin("users as users7","deals.deal_user_id7","=","users7.user_id")
            ->LeftJoin("users as users8","deals.deal_user_id8","=","users8.user_id")
            ->LeftJoin("users as users9","deals.deal_user_id9","=","users9.user_id")
            ->LeftJoin("users as users10","deals.deal_user_id10","=","users10.user_id")
            ->LeftJoin("banks as company_banks","companies.company_bank_id","=","company_banks.bank_id")
            ->select("deals.*","clients.*","brands.*","marks.*","fractions.*","regions.*","stations.*",
                "companies.*", "company_banks.bank_name as company_bank_name",
                DB::raw('DATE_FORMAT(deals.deal_datetime1,"%d.%m.%Y %T") as deal_datetime1'),
                DB::raw('DATE_FORMAT(deals.deal_datetime2,"%d.%m.%Y %T") as deal_datetime2'),
                DB::raw('DATE_FORMAT(deals.deal_datetime3,"%d.%m.%Y %T") as deal_datetime3'),
                DB::raw('DATE_FORMAT(deals.deal_datetime4,"%d.%m.%Y %T") as deal_datetime4'),
                DB::raw('DATE_FORMAT(deals.deal_datetime5,"%d.%m.%Y %T") as deal_datetime5'),
                DB::raw('DATE_FORMAT(deals.deal_datetime6,"%d.%m.%Y %T") as deal_datetime6'),
                DB::raw('DATE_FORMAT(deals.deal_datetime7,"%d.%m.%Y %T") as deal_datetime7'),
                DB::raw('DATE_FORMAT(deals.deal_datetime8,"%d.%m.%Y %T") as deal_datetime8'),
                DB::raw('DATE_FORMAT(deals.deal_datetime9,"%d.%m.%Y %T") as deal_datetime9'),
                DB::raw('DATE_FORMAT(deals.deal_datetime10,"%d.%m.%Y %T") as deal_datetime10'),
                DB::raw('DATE_FORMAT(deals.deal_shipping_date,"%d/%m/%Y") as deal_shipping_date'),
                DB::raw('DATE_FORMAT(deals.deal_delivery_date,"%d/%m/%Y") as deal_delivery_date'),
                DB::raw('DATE_FORMAT(brands.brand_dogovor_date,"%d/%m/%Y") as brand_dogovor_date'),
                "users1.user_surname as user_surname1","users1.user_name as user_name1",
                "users2.user_surname as user_surname2","users2.user_name as user_name2",
                "users3.user_surname as user_surname3","users3.user_name as user_name3",
                "users4.user_surname as user_surname4","users4.user_name as user_name4",
                "users5.user_surname as user_surname5","users5.user_name as user_name5",
                "users6.user_surname as user_surname6","users6.user_name as user_name6",
                "users7.user_surname as user_surname7","users7.user_name as user_name7",
                "users8.user_surname as user_surname8","users8.user_name as user_name8",
                "users9.user_surname as user_surname9","users9.user_name as user_name9",
                "users10.user_surname as user_surname10","users10.user_name as user_name10"
            )
            ->where("deal_id","=",$deal_id)->first();
        $replace_var_arr = ['deal_datetime1', 'deal_datetime2', 'deal_datetime3',
            'deal_datetime4','deal_datetime5','deal_datetime6','deal_datetime7',
            'deal_datetime8','deal_datetime9','deal_datetime10',
            'deal_datetime1_str', 'deal_datetime2_str', 'deal_datetime3_str',
            'deal_datetime4_str','deal_datetime5_str','deal_datetime6_str','deal_datetime7_str',
            'deal_datetime8_str','deal_datetime9_str','deal_datetime10_str',
            "user_surname1", "user_name1",
            "user_surname2", "user_name2",
            "user_surname3", "user_name3",
            "user_surname4", "user_name4",
            "user_surname5", "user_name5",
            "user_surname6", "user_name6",
            "user_surname7", "user_name7",
            "user_surname8", "user_name8",
            "user_surname9", "user_name9",
            "user_surname10", "user_name10",
            'status_name',"brand_name","mark_name",
            "fraction_name","region_name","station_name","payment_name",
            "deal_volume","deal_discount_type","deal_discount","delivery_name","deal_receiver_code",
            "deal_brand_sum","deal_kp_sum", "deal_kp_sum_str", "deal_shipping_date", "deal_shipping_date_str", "deal_shipping_time","deal_delivery_date", "deal_delivery_date_str","deal_delivery_time",
            'client_surname', 'client_name', "client_phone","client_email",
            "company_name","company_ceo_position","company_ceo_name", "company_address","company_bank_iik", "company_bank_bin","company_delivery_address","company_okpo", "company_bank_name",
            "system_info_company_name", "system_info_bank_name","system_info_bank_iik","system_info_bank_bin","system_info_bank_kbe",
            "system_info_bank_code","system_info_address","system_info_img","system_info_fio",
            "deal_fact_volume","deal_rest_volume","deal_rest_volume_in_sum",
            "brand_email","brand_company_name","brand_company_ceo_name","brand_dogovor_num","brand_dogovor_date","brand_props","deal_file_date", "station_code","deal_wagon_count"];

        $system_info_row = SystemInfo::LeftJoin("banks","system_info.system_info_bank_id","=","banks.bank_id")
            ->select("system_info.*",'banks.bank_name as system_info_bank_name')
            ->where("system_info_id","=",1)->first();

        $station_row = Station::where("station_id","=",$deal_row->deal_station_id)->first();
        $region_row = Region::where("region_id","=",$deal_row->deal_region_id)->first();

        foreach($replace_var_arr as $key => $replace_var_arr_item){
            $value = $deal_row[$replace_var_arr_item];
            if($replace_var_arr_item == 'deal_kp_sum' || $replace_var_arr_item == 'deal_volume' || $replace_var_arr_item == 'deal_brand_sum'){
                $value = preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $deal_row[$replace_var_arr_item]);
            }
            else if($replace_var_arr_item == "deal_kp_sum_str"){
                $value = $this->num2str($deal_row['deal_kp_sum']);
            }
            else if($replace_var_arr_item == "deal_wagon_count"){
                $value = ceil($deal_row['deal_volume']/70);
            }
            else if($replace_var_arr_item == 'deal_datetime1_str' || $replace_var_arr_item == 'deal_datetime2_str'
                || $replace_var_arr_item == 'deal_datetime3_str' || $replace_var_arr_item == 'deal_datetime4_str'
                || $replace_var_arr_item == 'deal_datetime5_str' || $replace_var_arr_item == 'deal_datetime6_str'
                || $replace_var_arr_item == 'deal_datetime7_str' || $replace_var_arr_item == 'deal_datetime8_str'
                || $replace_var_arr_item == 'deal_datetime9_str' || $replace_var_arr_item == 'deal_datetime10_str'
                || $replace_var_arr_item == 'deal_shipping_date_str' || $replace_var_arr_item == 'deal_delivery_date_str'){
                if(strlen($deal_row[str_replace("_str","",$replace_var_arr_item)]) > 0) {
                    $value = $this->dateToStr($deal_row[str_replace("_str", "", $replace_var_arr_item)]);
                }
                else{
                    $value = "";
                }
            }
            else if($replace_var_arr_item == "system_info_company_name" || $replace_var_arr_item ==  "system_info_bank_name"
                || $replace_var_arr_item == "system_info_bank_iik" || $replace_var_arr_item == "system_info_bank_bin"
                || $replace_var_arr_item == "system_info_bank_kbe" || $replace_var_arr_item == "system_info_bank_code"
                || $replace_var_arr_item == "system_info_address" || $replace_var_arr_item == "system_info_img"
                || $replace_var_arr_item == "system_info_fio"){
                if($replace_var_arr_item == 'system_info_img'){
                    $value = "/system_info_img/" . $system_info_row['system_info_img'];
                }
                else{
                    $value = $system_info_row[$replace_var_arr_item];
                }
            }

            $templateProcessor->setValue('${' . $replace_var_arr_item . '}', $value);
        }
        $templateProcessor->saveAs('dogovor/dogovor' . $deal_id . '.docx');
    }

    public function downloadDogovor(Request $request){
        $this->createDogovor($request->deal_id);
        return response()->json(['result'=>true]);
    }

    public function sendDogovor(Request $request){
        $this->createDogovor($request->deal_id);

        $email_to = "adik.khalikhov@mail.ru";

        $deal_template_file_row = DealTemplateFile::where("deal_template_type_id","=",11)->first();
        $message_str = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_text'],$request->deal_id);
        $mail_title = $this->replaceDealFileTemplate($deal_template_file_row['deal_template_mail_title'],$request->deal_id);

        $deal_id = $request->deal_id;
        Mail::send(['html' => 'admin.email-kp'], ['text' => $message_str], function ($message) use ($email_to, $deal_id,$mail_title) {
            $message->to($email_to)->subject($mail_title);
            $message->cc("askhat@kit.systems")->subject($mail_title);
            $message->cc("a.yemtsev@kit.systems")->subject($mail_title);
            $message->attach("dogovor/dogovor" . $deal_id . ".docx", ['as' => "dogovor" . $deal_id . ".docx", 'mime' => 'application/docx']);
        });
        if (@count(Mail::failures()) > 0) {
            return response()->json(['result' => false]);
        }
        else {
            return response()->json(['result' => true]);
        }
    }

    public function testDoc(){
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('file_template/kp_template.docx');
        $templateProcessor->setValue('${fio}', 'ФИО');
        $templateProcessor->saveAs('trash/Sample_07_TemplateCloneRow.docx');
    }
}
