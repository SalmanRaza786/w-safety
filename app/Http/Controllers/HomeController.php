<?php

namespace App\Http\Controllers;
use App\Http\Helpers\Helper;
use App\Models\User;
use App\Repositries\category\CategoryInterface;
use App\Repositries\product\ProductInterface;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use function Brotli\compress_add;
use function PHPUnit\Framework\returnArgument;

class HomeController extends Controller
{
    private $cat;
    private $product;

    public function __construct(CategoryInterface $cat,ProductInterface $product)
    {
        $this->cat = $cat;
        $this->product = $product;
    }


    public function index()
    {
        try {
            return 'welcome';
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            } else {
                $data['categories']=Helper::fetchOnlyData($this->cat->getAllCategoriesWithProducts());
                return view('web.index')->with(compact('data'));
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function customLogout()
    {
        try {
            if (Auth::guard('admin')->check()) {
                Auth::logout();
                Session::flush();
                return redirect()->route('admin.login.view');
            }
            if (Auth::guard('web')->check()) {
                Auth::logout();
                Session::flush();
                return redirect()->route('user.index');
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function shop()
    {
        try {
            $data['categories']=Helper::fetchOnlyData($this->cat->getAllCategoriesWithProducts());
            $data['products']=Helper::fetchOnlyData($this->product->getAllProductWithPaginate());
            return view('web.shop')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function contactUs()
    {
        try {
            return view('web.contact-us');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function aboutUs()
    {
        try {
            return view('web.about-us');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function cart(Request $request)
    {
        try {
            $data = Cart::getContent();
            $cartArray=collect([]);
            foreach($data as $cart){
                $miniCart=array(
                    'id' =>encrypt($cart->id),
                    'name' => $cart->name,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'image' =>URL::asset('storage/uploads/').'/'.$cart->attributes->image,
                );
                $cartArray->push($miniCart);
            }
            return view('web.cart')->with(compact('cartArray'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function checkout()
    {
        try {
            $data = Cart::getContent();
            $cartArray=collect([]);
            foreach($data as $cart){
                $miniCart=array(
                    'id' =>encrypt($cart->id),
                    'name' => $cart->name,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'image' =>URL::asset('storage/uploads/').'/'.$cart->attributes->image,
                );
                $cartArray->push($miniCart);
            }

            return view('web.checkout')->with(compact('cartArray'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //productDetail
    public function productDetail(Request $request)
    {
        try {
            $productId= decrypt($request->query('productId'));
           $data['productInfo']=Helper::fetchOnlyData($this->product->findProductById($productId));
            return view('web.product-detail')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function otp(Request $request)
    {
        try {
$data['student']=User::first();
            return view('auth.otp')->with(compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
