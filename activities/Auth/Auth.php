<?php
namespace Auth;

use database\DataBase;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
class Auth
{
    protected function redirect($url)
    {
          header('Location: ' .trim(CURRENT_DOMAIN,'/').'/'.trim($url,'/'));
          exit;
    }
    protected function redirectBack()

    {
        header('Location:' .$_SERVER['HTTP_REFERER'] );
        exit;
    }

    private function hash($password)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashPassword;

    }
   private function sendMail($emailAddress, $subject, $body)
    {

//Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth =SMTP_AUTH;                                   //Enable SMTP authentication
            $mail->Username = MAIL_USERNAME;                     //SMTP username
            $mail->Password = MAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(SENDER_MAIL, SENDER_NAME);
            $mail->addAddress($emailAddress);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;


            $result=$mail->send();
            echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function register()
    {
       require_once (BASE_PATH.'/template/auth/register.php');
    }

    private function random()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function activationMessage ($userename,$verifyToken)
    {
            $message ='
             <h1>فعال سازی حساب کاربری </h1>
            <p>'.$userename .'
             عزیز برای فعال سازی حساب کاربری خود روی لینک زیر کلیک کنید
             </p>
             <di><a href="'.url('activation/'.$verifyToken).'  ">فعال سازی حساب </a></di>"
            ';
         return $message;
    }
    public function forgotMessage ($userename,$forgotToken)
    {
        $message ='
             <h1>فراموشی رمز عبور </h1>
            <p>'.$userename .'
             عزیز برای تغییر  رمز عبور حساب کاربری خود روی لینک زیر کلیک کنید
             </p>
             <di><a href="'.url('reset-password-form/'.$forgotToken).'  ">بازیابی رمز عبور </a></di>"
            ';
        return $message;
    }
    public function registerStore($request)
    {
        if(empty($request['email']) || empty($request['password']) || empty($request['username']))
        {
           flash('register_error','تمامی فیلد ها اجباری هستند');
            $this->redirectBack();
        }
        else if(strlen($request['password']) < 8)
        {
            flash('register_error','رمز عبور حداقل باید 8 کاراکتر داشته باشد');
            $this->redirectBack();
        }
        else if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
        {
            flash('register_error','ایمیل وارد شده معتبر نیست');
            $this->redirectBack();
        }
        else
        {
            $db = new Database();
            $user= $db->select('SELECT * FROM `users` WHERE `email`= ?;',[$request['email']])->fetch();

            if ($user != null)
            {
                flash('register_error','ایمیل وارد شده تکراری است');
                $this->redirectBack();
            }
            else
            {
                $randomToken = $this ->random();
                $activationMessage = $this ->activationMessage($request['username'],$randomToken);

                $result =$this ->sendMail($request['email'],'فعال سازی حساب کاربری',$activationMessage);

               if($result)
               {
                   $request['verify_token']=$randomToken;
                   $request['password']=$this->hash($request['password']);
                   $db->insert('users',array_keys($request),$request);
                   $this->redirect('login');
               }
               else
               {
                   flash('register_error','ارسال ایمیل با خطا مواجه شد');
                   $this->redirectBack();
               }
            }
        }
    }

    public function activation($verifyToken)
    {
        $db = new DataBase();
        $user = $db ->select('SELECT * FROM users WHERE verify_token= ? AND is_active=0;',[$verifyToken])->fetch();
        if($user == null)
        {
            $this->redirectBack();
        }
       else
       {
           $result = $db ->update('users',$user['id'],['is_active'],[1]);
           $this->redirect('login');

       }
    }
    public function login()
    {
        require_once (BASE_PATH.'/template/auth/login.php');
    }

    public function checklogin($request)
    {
        if (empty($request['email']) || empty($request['password']))
        {
            flash('login_error', ' تمامی فیلد ها الزامی میباشند ');
               $this->redirectBack();
         }
        else
        {
            $db = new DataBase();
            $user=$db ->select('SELECT * FROM users WHERE email =? ;',[$request['email']])->fetch();
            if ($user != null)
            {
                if(password_verify($request['password'],$user['password']) && $user['is_active'] == 1)
                {
                   $_SESSION['user'] = $user ['id'];
                   $this->redirect('admin');
                }
              else
              {
                  flash('login_error', ' ایمیل یا رمز عبور اشتباه است  ');
                  $this->redirectBack();
              }
            }
            else
            {
                flash('login_error', ' کاربری با این مشخصات یافت نشد  ');
               $this->redirectBack();
            }
        }

    }

     public function checkAdmin()
     {
          if (isset($_SESSION['user']))
          {
              $db =new DataBase();
              $user = $db->select('SELECT * FROM users WHERE id=? ',[$_SESSION['user']])->fetch();
              if($user != null)
              {
                  if($user['permission'] != 'admin')
                  {
                      $this->redirect('home');
                  }
              }
              else
              {
                  $this->redirect('home');
              }

          }
          else
          {
              $this->redirect('home');
          }
     }
     public function logout()
     {
         if(isset ($_SESSION['user']))
         {
             unset($_SESSION['user']);
             session_destroy();
         }
         $this->redirect('home');
     }
     public function forgot()
     {
         require_once (BASE_PATH.'/template/auth/forgot.php');
     }

     public function forgotRequest($request)
     {
         if(empty($request['email']))
         {
             flash('forgot_error','ایمیل الزامی میباشد');
             $this->redirectBack();
         }
         else if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
         {
             flash('forgot_error','ایمیل وارد شده معتبر نیست');
             $this->redirectBack();
         }
         else
         {
             $db =new DataBase();
             $user = $db->select('SELECT * FROM users WHERE email=? ',[$request['email']])->fetch();
             if($user == null)
             {
                 flash('forgot_error','کاربری با آدرس ایمیل وارد شده یافت نشد');
                 $this->redirectBack();
             }
             else
             {
                 date_default_timezone_set('Asia/Tehran');
                 $randomToken = $this ->random();
                 $forgotMessage = $this ->forgotMessage($user['username'],$randomToken);
                 $result =$this ->sendMail($request['email'],'باز یابی رمز عبور',$forgotMessage);

                 if($result)
                 {
                   $db->update('users',$user['id'],['forgot_token','forgot_token_expire'],[$randomToken ,date('Y-m-d H:i:s' ,strtotime('+15 minutes'))]);
                   $this->redirect('login');
                 }
                 else
                 {
                     flash('forgot_error','ارسال ایمیل با خطا مواجه شد');
                     $this->redirectBack();
                 }
             }

         }

     }
     public function resetPasswordForm($forgot_token)
     {
         require_once (BASE_PATH.'/template/auth/reset-password.php');
     }
     public function resetPassword($request,$forgot_token)
     {
       if(!isset($request['password']) || strlen($request['password']) < 8)
       {
           flash('reset_error','ارسال ایمیل با خطا مواجه شد');
           $this->redirectBack();
       }
       else
       {
           $db =new DataBase();
           $user = $db->select('SELECT * FROM users WHERE forgot_token=? ',[$forgot_token])->fetch();
           if($user == null)
           {
               flash('forgot_error','کاربری یافت نشد');
               $this->redirectBack();
           }
           else
           {
               date_default_timezone_set('Asia/Tehran');
               if($user['forgot_token_expire'] < date('Y-m-d H:i:s'))
               {
                   flash('forgot_error','تاریخ انقضا توکن تمام شده است');
                   $this->redirectBack();
               }
               if($user)
               {
                   $db->update('users',$user['id'],['password'],[$this->hash($request['password'])]);
                   $this->redirect('login');
               }
           }
       }
     }

}

