<?php
/*  GOOGLE LOGIN BASIC - Tutorial
 *  file            - index.php
 *  Developer       - Krishna Teja G S
 *  Website         - http://packetcode.com/apps/google-login/
 *  Date            - 28th Aug 2015
 *  license         - GNU General Public License version 2 or later
*/
// REQUIREMENTS - PHP v5.3 or later
// Note: The PHP client library requires that PHP has curl extensions configured. 
/*
 * DEFINITIONS
 *
 * load the autoload file
 * define the constants client id,secret and redirect url
 * start the session
 */
require_once __DIR__.'/Google/autoload.php';
const CLIENT_ID = '178773715427-s3lk4tvgerk64phj234o9kg3dcbisdut.apps.googleusercontent.com';
const CLIENT_SECRET = 'da1_jca-oRRok4B6jkHQYJUQ';
const REDIRECT_URI = 'http://localhost/addictionRemoval/html/registration.php';
session_start();
/* 
 * INITIALIZATION
 *
 * Create a google client object
 * set the id,secret and redirect uri
 * set the scope variables if required
 * create google plus object
 */
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');
$plus = new Google_Service_Plus($client);
/*
 * PROCESS
 *
 * A. Pre-check for logout
 * B. Authentication and Access token
 * C. Retrive Data
 */
/* 
 * A. PRE-CHECK FOR LOGOUT
 * 
 * Unset the session variable in order to logout if already logged in    
 */
if (isset($_REQUEST['logout'])) {
   session_unset();
   header("Location:http://localhost/addictionRemoval/OAuth/google_auth.php");
}
/* 
 * B. AUTHORIZATION AND ACCESS TOKEN
 *
 * If the request is a return url from the google server then
 *  1. authenticate code
 *  2. get the access token and store in session
 *  3. redirect to same url to eleminate the url varaibles sent by google
 */
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
/* 
 * C. RETRIVE DATA
 * 
 * If access token if available in session 
 * load it to the client object and access the required profile data
 */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $me = $plus->people->get('me');
  //$id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];
} else {
  // get the login url   
  $authUrl = $client->createAuthUrl();
}

?>

<head>
  <link rel="stylesheet" href="../css/loginpage.css" />
</head>

<body background="../images/addicts.jpg">


    <?php
    /*
     * If login url is there then display login button
     * else print the retieved data
    */
    if (isset($authUrl)) 
    {
        
        echo '<center><div id="boxLogin"><br><br><br><h1 id="titleHeader"> Addiction Removal </h1>  ';
        echo '<p id="aboutApp"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p></div></center>';
        echo "<center><a class='login' href='" . $authUrl . "'><img src='gplus-lib/signin_button.png' height='50px' align='middle'/></a></center>";
        print "<br><br>";
        
    } 
    else 
    {
        echo"<br><br>";
        echo "<center><a class='logout' href='?logout' align='middle'><button>Logout</button></a></center>";

    }
    ?>


    
</div>
</center>
</body>