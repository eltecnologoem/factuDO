<?php
  $uri = explode('/', $_SERVER['REQUEST_URI']);
  if(in_array('comingsoon', $uri)){
    exit(header('Location: /notfound'));
  }
  if(!isset($page) OR empty($page)){
    $page = '';
  }

  if(!isset($time) OR empty($time)){
    $time = date("Y-m-d",strtotime(date("d-m-Y")."+ 7 days")); 
  }

?>

<div class="row no-gutters row-flex">
  <div class="col-lg-6">
    <div class="one-page-wrap">
      <div class="one-page-content">
        <div class="big">WEBSITE PAGE <?= $page ?> IS COMING SOON</div>
        <h4 class="custom-title custom-title-small">The page Will be <br>Available in:</h4>
        <div class="countdown-wrap">
          <div class="DateCountdown" data-type="until" data-date="<?= $time ?> 22:00:00" data-format="wdhms" data-color="transparent" data-bg="transparent" data-width="0" data-tc-id="1dd793de-b7eb-c179-9ae0-b44d5ce9b279"><div class="time_circles"><canvas width="350" height="87"></canvas><div class="textDiv_Days" style="top: 31px; left: 0px; width: 87.5px;"><h4 style="font-size: 6px; line-height: 6px;">Days</h4><span style="font-size: 18px; line-height: 6px;">822</span></div><div class="textDiv_Hours" style="top: 31px; left: 88px; width: 87.5px;"><h4 style="font-size: 6px; line-height: 6px;">Hours</h4><span style="font-size: 18px; line-height: 6px;">13</span></div><div class="textDiv_Minutes" style="top: 31px; left: 175px; width: 87.5px;"><h4 style="font-size: 6px; line-height: 6px;">Minutes</h4><span style="font-size: 18px; line-height: 6px;">29</span></div><div class="textDiv_Seconds" style="top: 31px; left: 263px; width: 87.5px;"><h4 style="font-size: 6px; line-height: 6px;">Seconds</h4><span style="font-size: 18px; line-height: 6px;">0</span></div></div></div>
        </div>
        <div class="heading-6">Subscribe to be notified:</div>
        <form class="rd-form rd-mailform rd-form-inline" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="/public/bat/rd-mailform.php" novalidate="novalidate">
          <div class="form-wrap form-wrap-icon">
            <div class="form-icon mdi mdi-email-outline"></div>
            <input class="form-input form-control-has-validation" id="subscribe-form-email" type="email" name="email" data-constraints="@Email @Required"><span class="form-validation"></span>
            <label class="form-label rd-input-label" for="subscribe-form-email">E-mail</label>
          </div>
          <div class="form-button">
            <button class="button button-default" type="submit">Send</button>
          </div>
        </form>
        <p class="paragraph-custom">We respect your privacy and never share your info</p>
      </div>
      <div class="one-page-footer">
        <div class="heading-6">Stay in touch</div>
        <ul class="list-inline list-inline-sm">
          <li><a class="icon icon-sm icon-bordered link-default mdi mdi-facebook" href="https://facebook.com/gamerclub.vip"></a></li>
          <li><a class="icon icon-sm icon-bordered link-default mdi mdi-instagram" href="https://instagram.com/gamerclubvip"></a></li>
          <li><a class="icon icon-sm icon-bordered link-default mdi mdi-twitter" href="https://twitter.com/gamerclubvip"></a></li>
          <li><a class="icon icon-sm icon-bordered link-default mdi mdi-account-key" href="/dash"></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-6 one-page-image bg-vide" data-vide-bg="/public/video/video-1" data-vide-options="posterType: jpg"><div style="position: absolute; z-index: 0; inset: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: auto; height: 880px;"><source src="/public/video/video-1.mp4" type="/public/video/mp4"><source src="/public/video/video-1.webm" type="/public/video/webm"><source src="/public/video/video-1.ogv" type="/public/video/ogg"></video></div></div>
</div>