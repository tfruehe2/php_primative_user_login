<?php
require_once '../site/init.php';

if(Input::exists()) {
  if(Token::check(Input::get('csrf_token'))) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('required' => true),
      'password' => array('required' => true)
    ));

    if($validation->passed()) {
      $user = new User();

      $remember = (Input::get('remember') === 'on') ? true : false;
      $login = $user->login(Input::get('username'), Input::get('password'), $remember);

      if($login) {
        Redirect::to('../public/index.php');
      } else {
        echo '<p>Sorry, logging in failed.</p>';
      }
    } else {
      foreach($validation->errors() as $error) {
        echo $error, '<br />';
      }

    }
  } else
  {
    echo "csrf token failed";
  }
}

?>

<form action="" method="post">
		<div class="field">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="" >
    </div>
    <div class="field">
      <label for="remember">
        <input type="checkbox" name="remember" id="remember"> Remember Me
      </label>
    <div>
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
    <input type="submit" name="submit" value="register">
</form>
