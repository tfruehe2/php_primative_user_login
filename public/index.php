<?php
require_once '../site/init.php';

$app = new App();

echo "<br>" . Config::get('mysql/host'), "<br />";
echo $_SERVER['REMOTE_ADDR'] ;
echo '<p>' . Session::flash('home') . '</p>';

$user = new User();
if($user->isLoggedIn()) {
?>
  <p>Hello <a href="#"><?php echo escape($user->data()->username); ?></a>!</p>

  <ul>
    <li><a href="update.php">Update Profile</a></li>
    <li><a href="changepassword.php">Change Password</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>

<?php
} else {
  echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}
