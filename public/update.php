<?php

require_once "../site/init.php";

$user = new User();

if(!$user->isLoggedIn())
{
  Redirect::to('../public/index.php');
}

if(Input::exists())
{
  if(Token::check(Input::get("csrf_token")))
  {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      "first_name" => array(
        'min' => 2,
        'max' => 24
      ),
      "last_name" => array(
        'min' => 2,
        'max' => 24
      )
    ));

    if($validation->passed()) {
      try {
        $user->update(array(
          "first_name" => Input::get('first_name'),
          "last_name" => Input::get('last_name')
        ));

        Session::flash('home', 'Your profile was successfully updated');
        Redirect::to('../public/index.php');
        
      } catch (Exception $e) {
        die($e->getMessage());
      }

    }
    else
    {
      foreach($validation->errors() as $error)
      {
        echo $error, '<br>';
      }
    }
  }
  else
  {
    echo "csrf token failed please refresh the browser and try again";
  }
}
?>

<form action="" method="post">
  <div class="field">
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" value="<?php echo escape($user->data()->first_name); ?>">
  </div>
  <div class="field">
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" value="<?php echo escape($user->data()->last_name); ?>">
  </div>
  <div class="field">
    <input type="submit" name="submit" value="Update">
  </div>
    <input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
</form>
