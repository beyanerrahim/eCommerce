<?php
ob_start();
session_start();

$pageTitle = 'Login';

include 'init.php';

if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

//check if user coming form http post request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $hashedpass = sha1($pass);

    //check if the user exist in database

    $stmt = $con->prepare("SELECT UserID,Username,Password FROM users where Username = ? and Password = ? ");
    $stmt->execute(array($user, $hashedpass));

    $get=$stmt->fetch();

    $count = $stmt->rowCount();

    //if  count > 0 this mean the database contain record about this username

    if ($count  > 0) {
      // echo "Welcome admin" . $username;
      $_SESSION['user'] = $user;            //register session name

      $_SESSION['uid'] = $get['UserID'];    //register session User id


      header('Location: index.php');    //direct to dashboard page
      exit();
    }
  } else {
      $formErrors=array();

      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $email = $_POST['email'];

      if(isset($username)){
            
        $filteruser = filter_var($username,FILTER_SANITIZE_STRING);
        if(strlen(($filteruser)) < 4){
          $formErrors[]='User Name Must Be Larger Than 4 characters';
        }
      }

      if(isset($password) && isset($password2)){
            
        if( empty($password)){
          $formErrors[]='Sorry Password  Can Not be Empty';
        }
        $pass1 = sha1($password);
        $pass2 = sha1($password2);
        if( $pass1 !==  $pass2){
          $formErrors[]='Sorry Password  Is Not match';
        }
      }

      if(isset($email)){
            
        $filteremail = filter_var($email,FILTER_SANITIZE_EMAIL);
        if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
          $formErrors[]='This Email Is Not valid';
        }
      }


      if(empty($formErrors)){

        $check = checkItem('Username','users',$username);
        if($check == 1){
          $formErrors[] = 'Sorry This User is exists';
            

        }else{

       //insert user information in database       
       $stmt=$con->prepare("INSERT INTO users(Username , Password ,Email ,RStatus,Date) VALUES(:user , :pass,:mail,0,now())" );
       $stmt->execute(array(
           'user' => $username,
           'pass' => sha1($password),
           'mail' => $email,
           
       ));
       $succesMsg = 'Cangrates You Are Now Registerd user';
    }
     }
  }
}

?>
<div class="container login-page">
  <h2 class="text-center">
    <span class="selected" data-class="login">Login</span> |
    <span data-class="signup">Signup</span>
  </h2>
  <!-- Start Login Form -->
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login" method="POST">
    <!-- //input-container -->
    <div class="">
      <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Enter your Username" />
    </div>
    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Enter rhe passwors" />
    <input class="btn btn-primary btn-block" type="submit" name="login" value="Login" />

  </form>
  <!-- End Login Form -->
  <!-- Start Signup Form -->
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="signup" method="POST">
    <input pattern=".{4,}" title="user name must be between 4 chars" class="form-control" type="text" name="username" autocomplete="off" placeholder="Enter a Username"  />
    <input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Enter a complex password" />
    <input minlength="4" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Enter a password again" />

    <input class="form-control" type="email" name="email" autocomplete="off" placeholder="Enter a valid email" />

    <input class="btn btn-success btn-block" type="submit" name="signup" value="signup" />
  </form>
  <!-- End Signup Form -->
  <div class="the-errors text-center">
        <?php
          if(! empty($formErrors)){
            foreach($formErrors as $error){
              echo $error . '<br>';
            }
          }
        if(isset($succesMsg)){
          echo '<div class="msg success">'.$succesMsg.'</div>';
        }
        
        ?>
  </div>
</div>








<?php
include $tpl . 'footer.php';
ob_end_flush();
?>