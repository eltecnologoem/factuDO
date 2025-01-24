    <!-- Page Footer-->
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>

    <footer class="section footer-classic context-dark text-center">
      <div class="container">
        <div class="row row-15 justify-content-lg-between">
          <div class="col-lg-4 col-xl-3 text-lg-left">
            <p class="rights">

              Powered by <a href="https://molinatec.com" target="_blank" ><strong>MolinaTec</strong></a>
              <span>&copy;&nbsp; </span><span class="copyright-year"></span><span>&nbsp;</span><span>.&nbsp;</span><span><?= App::$lang->footer->all_rights_reserved ?></span>
            </p>
          </div>
          <div class="col-lg-5 col-xl-6">
            <ul class="list-inline list-inline-lg text-uppercase">
              <li><a href="/login">Login</a></li>
              <li><a href="/blog">Blog</a></li>
            </ul>
          </div>
          <div class="col-lg-3 text-lg-right"><a href="/privacy-policy"><?= App::$lang->footer->privacy_policy ?></a> 
          <h6 class="beta-test">FactusDO v0.1<?= ' | '. App::$lang->your_ip. cIP::get() ?></h6></div>
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
  <script src="/js/bootstrap.js"></script>
</body>

</html>