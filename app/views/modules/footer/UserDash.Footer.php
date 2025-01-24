    <!-- Page Footer-->
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <div class="pre-footer-classic bg-gray-700 context-dark">
      <div class="container">
        <div class="row row-30 justify-content-lg-between">
          <div class="col-sm-6 col-lg-3 col-xl-4">
            <h5>Encuéntranos desde tu móvil</h5>
            <div class="qr">
              <img src="/images/qr.png" alt="">
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-4">
            <h5>Contacto</h5>
            <dl class="list-terms-custom">
              <dt>Mail.</dt>
              <dd><a class="link-default" href="mailto:inf0@gamerclub.vip">inf0@gamerclub.vip</a></dd>
            </dl>
            <ul class="list-inline list-inline-sm">
              <li><a target="blank" class="icon icon-sm icon-gray-filled icon-circle mdi mdi-facebook" href="https://www.facebook.com/GamerClubVIP/"></a></li>
              <li><a target="blank" class="icon icon-sm icon-gray-filled icon-circle mdi mdi-instagram" href="https://www.instagram.com/gamerclubvip/"></a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-xl-3">
            <h5>Boletín Informativo</h5>
            <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" action="/app/lib/bat/rd-mailform.php">
              <div class="form-wrap form-wrap-icon">
                <div class="form-icon mdi mdi-email-outline"></div>
                <input class="form-input" id="footer-email" type="email" name="email" data-constraints="@Email @Required">
                <label class="form-label" for="footer-email">E-mail</label>
              </div>
              <div class="button-wrap">
                <button class="button button-default button-invariable" type="submit">Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="section footer-classic context-dark text-center">
      <div class="container">
        <div class="row row-15 justify-content-lg-between">
          <div class="col-lg-4 col-xl-3 text-lg-left">
            <p class="rights"><span>&copy;&nbsp; </span><span class="copyright-year"></span><span>&nbsp;</span><a href="#"><span>Dear Code</span></a><span>.&nbsp;</span><span>Todos los derechos reservados</span></p>
          </div>
          <div class="col-lg-5 col-xl-6">
            <ul class="list-inline list-inline-lg text-uppercase">
              <li><a href="/videos">Videos</a></li>
              <li><a href="/reviews">Reviews</a></li>
              <li><a href="/blog">Blog</a></li>
            </ul>
          </div>
          <div class="col-lg-3 text-lg-right"><a href="/privacy-policy">Política de Privacidad</a></div>
        </div>
      </div>
    </footer>
  </div>
  <?php Controller::GetModules('footer/user_float_menu'); ?>
  <div class="snackbars" id="form-output-global"></div>
  <script src="/js/core.min.js"></script>
  <script src="/js/script.js"></script>
  <script src="https://unpkg.com/splitting@1.0.5/dist/splitting.min.js"></script>
  <script src="/js/particles.js"></script>
  <script src="/js/app.js"></script>
  <script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "101096581270315");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function() {
      FB.init({
        xfbml            : true,
        version          : 'v11.0'
      });
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
</body>

</html>