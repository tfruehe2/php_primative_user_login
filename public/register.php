<?php
require_once '../site/init.php';

if(Input::exists())
{
  if(Token::check(Input::get('csrf_token')))
  {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array(
        'required' => true,
        'min' => 3,
        'max' => 24,
        'unique' => 'users'
      ),
      'email' => array(
        'required' => true,
        'min' => 5,
        'max' => 50,
        'unique' => 'email'
      ),
      'password' => array(
        'required' => true,
        'min' => 6
      ),
      'confirm_password' => array(
        'required' => true,
        'matches' => 'password'
      ),
    ));

    if($validation->passed())
    {
      $user = new User();
      $salt = Hash::salt(32);
      try
      {

        $user->create(array(
          'username' => Input::get('username'),
          'email' => Input::get('email'),
          'password' => Hash::make(Input::get('password'), $salt),
          'salt' => $salt,
          'group_id' => 1
        ));

        Session::flash('home', 'You have successfully been registered!');
        Redirect::to('../public/index.php');

      } catch(Exception $e)
      {
        die($e->getMessage());
      }
    } else
    {
      foreach($validation->errors() as $error)
      {
        echo $error, "<br />";
      }
    }
  } else {
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
      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="<?php echo escape(Input::get('email'));?>" >
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="" >
    </div>
    <div class="field">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password" value="" >
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
    <input type="submit" name="submit" value="register">
</form>
