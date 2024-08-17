<?php
 //session start
use database\DataBase;

session_start();


//config

define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN',    currentDomain().'/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST','localhost');
define('DB_NAME','project');
define('DB_USERNAME','root');
define('DB_PASSWORd','');

//mail
define('MAIL_HOST','smtp.gmail.com');
define('SMTP_AUTH',true);
define('MAIL_USERNAME','nargesba2024@gmail.com');
define('MAIL_PASSWORD','lbmk yqri nltc ojei');
define('MAIL_PORT',587);
define('SENDER_MAIL','nargesba2024@gmail.com');
define('SENDER_NAME','narges');

require_once 'database/DataBase.php';
require_once 'database/CreateDB.php';

require_once  'activities/Admin/Admin.php';
require_once  'activities/Admin/Dashboard.php';
require_once  'activities/Admin/Category.php';
require_once  'activities/Admin/Post.php';
require_once  'activities/Admin/Banner.php';
require_once  'activities/Admin/User.php';
require_once  'activities/Admin/Comment.php';
require_once  'activities/Admin/Menu.php';
require_once  'activities/Admin/Websetting.php';

require_once 'activities/App/Home.php';

require_once 'activities/Auth/Auth.php';


spl_autoload_register(function($className){
    $path= BASE_PATH. DIRECTORY_SEPARATOR .'lib'.DIRECTORY_SEPARATOR ;
    include $path.$className.'.php';

});
function jalaliDate($date)
{
    return \Parsidev\Jalali\jDate::forge($date)->format('datetime');
}


//helpers
function protocol()
{
     return stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
}
function currentDomain()
{
       return protocol(). $_SERVER['HTTP_HOST'];
}


function asset($src)
{
    $domain =trim(CURRENT_DOMAIN ,'/');
    $src=$domain.'/'.trim($src,'/');
    return $src;

}
// href tag a
function url($url)
{
    $domain =trim(CURRENT_DOMAIN ,'/');
    $url=$domain.'/'.trim($url,'/');
    return $url;
}
// address cureent url
function currentUrl()
{
    return currentDomain().$_SERVER['REQUEST_URI'];
}

// method ($get ,$post
function methodField()
{
    return $_SERVER['REQUEST_METHOD'];

}
function displayError($displayError)
{
       if($displayError)
       {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
       }
       else
       {
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
                error_reporting(0);
       }
}
// for show error massage
global $flashMessage;
if(isset($_SESSION['flash_message'])){
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}
// both getter and setter

function flash($name, $value = null)
{
    if($value === null){
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
        return $message;
    }
    else{
        $_SESSION['flash_message'][$name] = $value;
    }

}
function uri ($reserveUrl,$class,$method,$requestMethod = 'GET')
{
    //current url array
    $currentUrl = explode('?',currentUrl())[0];
    $currentUrl= str_replace(CURRENT_DOMAIN,'',$currentUrl);
    $currentUrl= trim($currentUrl,'/');
    $currentUrlArray=explode('/',$currentUrl);
    $currentUrlArray=array_filter($currentUrlArray);  // delete empty index

    $reserveUrl=trim($reserveUrl,'/');
    $reserveUrlArray=explode('/',$reserveUrl);
    $reserveUrlArray=array_filter($reserveUrlArray);

    if (sizeof($currentUrlArray)!= sizeof($reserveUrlArray) || methodField() != $requestMethod)
    {
        return false;
    }
    $parametrs=array();
    for($i=0;$i<sizeof($currentUrlArray);$i++)
    {
        if($reserveUrlArray[$i][0]== "{" && $reserveUrlArray[$i][strlen($reserveUrlArray[$i])-1]== "}")
        {
            array_push($parametrs,$currentUrlArray[$i]);
        }
        else if ($currentUrlArray[$i] !== $reserveUrlArray[$i])
        {
                return false;
        }
    }

    if(methodField()=='POST')
    {
        $request= isset($_FILES) ? array_merge($_FILES,$_POST) : $_POST;
        $parametrs = array_merge([$request],$parametrs);
    }
     $object = new $class;
     call_user_func_array(array($object,$method),$parametrs); // khodesh mifahme har method che parametry mikhad

}




function dd($Var)
{
    echo '<pre>';
    var_dump($Var);
    exit;
}

uri('admin','Admin\Dashboard','index');

//category
uri('admin/category', 'Admin\Category', 'index');
uri('admin/category/create', 'Admin\Category', 'create');
uri('admin/category/store', 'Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'Admin\Category', 'delete');

//post
uri('admin/post', 'Admin\Post', 'index');
uri('admin/post/create', 'Admin\Post', 'create');
uri('admin/post/store', 'Admin\Post', 'store', 'POST');
uri('admin/post/edit/{id}', 'Admin\Post', 'edit');
uri('admin/post/update/{id}', 'Admin\Post', 'update', 'POST');
uri('admin/post/delete/{id}', 'Admin\Post', 'delete');
uri('admin/post/selected/{id}', 'Admin\Post', 'selected');
uri('admin/post/breaking-news/{id}', 'Admin\Post', 'breakingNews');


//banner
uri('admin/banner', 'Admin\Banner', 'index');
uri('admin/banner/create', 'Admin\Banner', 'create');
uri('admin/banner/store', 'Admin\Banner', 'store', 'POST');
uri('admin/banner/edit/{id}', 'Admin\Banner', 'edit');
uri('admin/banner/update/{id}', 'Admin\Banner', 'update', 'POST');
uri('admin/banner/delete/{id}', 'Admin\Banner', 'delete');

//user
uri('admin/user', 'Admin\User', 'index');
uri('admin/user/edit/{id}', 'Admin\User', 'edit');
uri('admin/user/update/{id}', 'Admin\User', 'update', 'POST');
uri('admin/user/delete/{id}', 'Admin\User', 'delete');
uri('admin/user/admin/{id}', 'Admin\User', 'admin');

//comments
uri('admin/comment', 'Admin\Comment', 'index');
uri('admin/comment/show/{id}', 'Admin\Comment', 'show');
uri('admin/comment/change-status/{id}', 'Admin\Comment', 'changeStatus');

//menu
uri('admin/menu', 'Admin\Menu', 'index');
uri('admin/menu/create', 'Admin\Menu', 'create');
uri('admin/menu/store', 'Admin\Menu', 'store', 'POST');
uri('admin/menu/edit/{id}', 'Admin\Menu', 'edit');
uri('admin/menu/update/{id}', 'Admin\Menu', 'update', 'POST');
uri('admin/menu/delete/{id}', 'Admin\Menu', 'delete');



//web setting

uri('admin/websetting', 'Admin\Websetting', 'index');
uri('admin/websetting/edit', 'Admin\Websetting', 'edit');
uri('admin/websetting/update', 'Admin\Websetting', 'update', 'POST');

//Auth
uri('register','Auth\Auth', 'register');
uri('register/store', 'Auth\Auth', 'registerStore', 'POST');
uri('activation/{verify_token}', 'Auth\Auth', 'activation');


uri('login','Auth\Auth', 'login');
uri('check-login', 'Auth\Auth', 'checklogin', 'POST');
uri('logout', 'Auth\Auth', 'logout');
uri('forgot', 'Auth\Auth', 'forgot' );

uri('forgot/request', 'Auth\Auth', 'forgotRequest', 'POST');
uri('reset-password-form/{forgot_token}', 'Auth\Auth','resetPasswordForm' );
uri('reset-password/{forgot_token}', 'Auth\Auth','resetPassword','POST');


uri('/','App\Home','index');
uri('/home','App\Home','index');
uri('/show/{id}','App\Home','show');
uri('/show-category/{id}','App\Home','category');
uri('/comment-store','App\Home','commentStore','POST');




