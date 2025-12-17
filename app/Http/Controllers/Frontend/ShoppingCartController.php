<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Cart;
use Session;

class ShoppingCartController extends Controller
{
    public function index()
    {
        $shopping = Cart::content();
        $modelProduct = new Product();
        $totals = $this->getCartTotals();

        $viewData = [
            'title_page' => 'Danh sách giỏ hàng',
            'size'       => $modelProduct->size,
            'shopping'   => $shopping,
            'totals'     => $totals
        ];
        return view('frontend.pages.shopping.cart', $viewData);
    }

    public function checkout()
    {
        $shopping = Cart::content();
        if ($shopping->isEmpty()) {
            Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Giỏ hàng của bạn đang trống'
            ]);
            return redirect()->route('get.shopping.list');
        }

        $modelProduct = new Product();
        $totals = $this->getCartTotals();
        $viewData = [
            'title_page' => 'Thanh toán',
            'size'       => $modelProduct->size,
            'shopping'   => $shopping,
            'totals'     => $totals
        ];

        return view('frontend.pages.shopping.checkout', $viewData);
    }

    /**
     * Thêm giỏ hàng
     */
    public function add(Request $request, $id)
    {
        $type = $request->type;
        $kichco = $request->kichco;
        $product = Product::find($id);

        //1. Kiểm tra tồn tại sản phẩm
        if (!$product) {
            return redirect()->to('/');
        }

        // 2. Kiểm tra số lượng sản phẩm
        if ($product->pro_number < 1) {
            //4. Thông báo
            Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Số lượng sản phẩm không đủ'
            ]);

            return redirect()->back();
        }

        $cart = Cart::content();
        $idCartProduct = $cart->search(function ($cartItem) use ($product) {
            if ($cartItem->id == $product->id) {
                return $cartItem->id;
            }
        });

        if ($idCartProduct) {
            $productByCart = Cart::get($idCartProduct);
            if ($product->pro_number < ($productByCart->qty + 1)) {
                Session::flash('toastr', [
                    'type'    => 'error',
                    'message' => 'Số lượng sản phẩm không đủ'
                ]);

                return redirect()->back();
            }
        }

        // 3. Thêm sản phẩm vào giỏ hàng
        Cart::add([
            'id'      => $product->id,
            'name'    => $product->pro_name,
            'qty'     => 1,
            'price'   => number_price($product->pro_price, $product->pro_sale),
            'weight'  => '1',
            'options' => [
                'sale'      => $product->pro_sale,
                'price_old' => $product->pro_price,
                'image'     => $product->pro_avatar,
                'size'     => $kichco
            ]
        ]);

        //4. Thông báo
        Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Thêm giỏ hàng thành công'
        ]);
        if ($type == 2) {
            return redirect()->route('get.shopping.list');
        }
        return redirect()->back();
    }

    public function postPay(Request $request)
    {
        $data = $request->except('_token');
        $shopping = Cart::content();
        if ($shopping->isEmpty()) {
            Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Giỏ hàng của bạn đang trống'
            ]);

            return redirect()->route('get.shopping.list');
        }

        if (!Auth::check()) {
            Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Đăng nhập để thực hiện tính năng này'
            ]);

            return redirect()->back();
        }

        $totals = $this->getCartTotals();
        $data['tst_user_id'] = Auth::id();
        $amount = $totals['total'];
        $data['tst_total_money'] = $amount;
        $data['tst_discount'] = $totals['discount'];
        $data['tst_voucher_id'] = $totals['voucher'] ? $totals['voucher']->id : null;
        $data['tst_type'] = (int) $data['tst_type'];
        $data['created_at'] = Carbon::now();

        // Lấy thông tin đơn hàng
        $data['options']['orders'] = $shopping;

        $this->storeTransaction($data, $totals['voucher']);
        Cart::destroy();
        Session::forget('voucher');

        $latestId = Transaction::orderBy('id', 'desc')->first()['id'];
        Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Mua hàng thành công'
        ]);
        // check nếu thanh toán ví thì kiểm tra số tiền
        if ($request->tst_type == Transaction::TYPE_ONLINE) {
            $vnp_TmnCode = Config::get('env.vnpay.code'); //Mã website tại VNPAY
            $vnp_HashSecret = Config::get('env.vnpay.secret'); //Chuỗi bí mật
            $vnp_Url = Config::get('env.vnpay.url');
            $vnp_Returnurl = Config::get('env.vnpay.callback');
            $vnp_TxnRef = $latestId; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $amount * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = request()->ip();
            $startTime = date("YmdHis");
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes', strtotime($startTime)))
            ];

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            return redirect()->to($vnp_Url);
        }
        return redirect()->to('/');
    }

    public function callback(Request $request)
    {
        $vnp_TmnCode = Config::get('env.vnpay.code'); //Mã website tại VNPAY
        $vnp_TransactionDate = $request->vnp_PayDate; // Thời gian ghi nhận giao dịch
        $vnp_HashSecret = Config::get('env.vnpay.secret'); //Chuỗi bí mật
        $vnp_RequestId = rand(1, 10000); // Mã truy vấn
        $vnp_Command = "querydr"; // Mã api
        $vnp_TxnRef = $request->vnp_TxnRef; // Mã tham chiếu của giao dịch
        $vnp_OrderInfo = "Query transaction"; // Mô tả thông tin
        //$vnp_TransactionNo= ; // Tuỳ chọn, Mã giao dịch thanh toán của CTT VNPAY
        $vnp_CreateDate = date('YmdHis'); // Thời gian phát sinh request
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP của máy chủ thực hiện gọi API

        $datarq = [
            "vnp_RequestId" => $vnp_RequestId,
            "vnp_Version" => "2.1.0",
            "vnp_Command" => $vnp_Command,
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            //$vnp_TransactionNo= ;
            "vnp_TransactionDate" => $vnp_TransactionDate,
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_IpAddr" => $vnp_IpAddr
        ];

        $format = '%s|%s|%s|%s|%s|%s|%s|%s|%s';

        $dataHash = sprintf(
            $format,
            $datarq['vnp_RequestId'], //1
            $datarq['vnp_Version'], //2
            $datarq['vnp_Command'], //3
            $datarq['vnp_TmnCode'], //4
            $datarq['vnp_TxnRef'], //5
            $datarq['vnp_TransactionDate'], //6
            $datarq['vnp_CreateDate'], //7
            $datarq['vnp_IpAddr'], //8
            $datarq['vnp_OrderInfo'] // 9
        );

        $pay = Transaction::where('id', $request->vnp_TxnRef)->first();
        $status = false;
        if ($pay) {
            if ($request->vnp_ResponseCode == "00") {
                $pay->tst_status = 2;
                $status = true;
            } else {
                $pay->tst_status = -1;
            }
            $pay->update();
        }

        return view('frontend.pages.shopping.success', [
            'transaction' => $pay,
            'status'       => $status
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            //1.Lấy tham số
            $qty       = $request->qty ?? 1;
            $idProduct = $request->idProduct;
            $product   = Product::find($idProduct);

            //2. Kiểm tra tồn tại sản phẩm
            if (!$product) {
                return response(['messages' => 'Không tồn tại sản sản phẩm cần update']);
            }

            //3. Kiểm tra số lượng sản phẩm còn ko
            if ($product->pro_number < $qty) {
                return response([
                    'messages' => 'Số lượng cập nhật không đủ',
                    'error'    => true
                ]);
            }

            //4. Update
            Cart::update($id, $qty);

            return response([
                'messages'   => 'Cập nhật thành công',
                'totalMoney' => Cart::subtotal(0),
                'totalItem'  => number_format(number_price($product->pro_price, $product->pro_sale) * $qty, 0, ',', '.')
            ]);
        }
    }

    /**
     * Xoá sản phẩm đơn hàng
     */
    public function delete(Request $request, $rowId)
    {
        if ($request->ajax()) {
            Cart::remove($rowId);
            return response([
                'totalMoney' => Cart::subtotal(0),
                'type'       => 'success',
                'message'    => 'Xoá sản phẩm khỏi đơn hàng thành công'
            ]);
        }
    }

    public function applyVoucher(Request $request)
    {
        $code = $request->get('vc_code');
        $voucher = Voucher::where('vc_code', $code)->first();

        if (!$voucher || !$this->isVoucherValid($voucher)) {
            Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'
            ]);

            return redirect()->back();
        }

        Session::put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->vc_code,
        ]);

        Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Áp dụng voucher thành công'
        ]);

        return redirect()->route('get.shopping.list');
    }

    public function removeVoucher()
    {
        Session::forget('voucher');
        Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Đã bỏ áp dụng voucher'
        ]);

        return redirect()->route('get.shopping.list');
    }

    protected function getCartTotals()
    {
        $subtotal = (int) str_replace(',', '', Cart::subtotal(0));
        $discount = 0;
        $voucher = null;

        if (Session::has('voucher')) {
            $voucherData = Session::get('voucher');
            $voucher = Voucher::find($voucherData['id']);

            if ($voucher && $this->isVoucherValid($voucher)) {
                $discount = $this->calculateDiscount($voucher, $subtotal);
            } else {
                Session::forget('voucher');
                $voucher = null;
            }
        }

        $total = max($subtotal - $discount, 0);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total'    => $total,
            'voucher'  => $voucher,
        ];
    }

    protected function calculateDiscount(Voucher $voucher, $subtotal)
    {
        $discount = 0;
        if ($voucher->vc_type == Voucher::TYPE_PERCENT) {
            $discount = (int) floor($subtotal * ($voucher->vc_value / 100));
            if ($voucher->vc_max_discount) {
                $discount = min($discount, $voucher->vc_max_discount);
            }
        } else {
            $discount = $voucher->vc_value;
        }

        return min($discount, $subtotal);
    }

    protected function isVoucherValid(Voucher $voucher)
    {
        if (!$voucher->isActive()) {
            return false;
        }

        return true;
    }

    // Store transaction to database
    public function storeTransaction($data, Voucher $voucher = null)
    {
        $transaction = Transaction::create([
            'tst_user_id'     => Auth::id(),
            'tst_voucher_id'  => $data['tst_voucher_id'] ?? null,
            'tst_total_money' => $data['tst_total_money'],
            'tst_discount'    => $data['tst_discount'] ?? 0,
            'tst_name'        => $data['tst_name'],
            'tst_email'       => $data['tst_email'],
            'tst_phone'       => $data['tst_phone'],
            'tst_address'     => $data['tst_address'],
            'tst_note'        => $data['tst_note'],
            'tst_code'        => $data['tst_code'] ?? '',
            'tst_status'      => 1,
            'tst_type'        => $data['tst_type'],
        ]);

        if ($transaction) {
            $shopping = Cart::content();
            foreach ($shopping as $item) {
                Order::insert([
                    'od_transaction_id' => $transaction->id,
                    'od_product_id'     => $item->id,
                    'od_sale'           => $item->options->sale,
                    'od_qty'            => $item->qty,
                    'od_price'          => $item->price,
                    'od_size'           => $item->options->size,
                ]);

                //Tăng số lượt mua của sản phẩm
                $product = Product::find($item->id);
                $product->pro_pay = $product->pro_pay + 1;
                $product->pro_amount = $product->pro_amount - $item->qty;
            }

            if ($voucher) {
                $voucher->increment('vc_used');
            }
        }

        Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Đặt hàng thành công'
        ]);

        return $transaction->id;
    }
}
