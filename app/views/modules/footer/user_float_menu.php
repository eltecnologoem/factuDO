    <!-- ==== Toggle Menu ==== -->
      <div class="navigation">
        <div class="toggle-float"></div>
        <ul>
          <?php if(Session::Exists('member'))://if(isset($_SESSION['member'])): ?>
            <li>
              <a href="/auth/close">
                <span class="icon-toggle"> <i class="mdi mdi-login-variant"></i></span>
                <span class="title-toggle">Close</span>
              </a>
            </li>
            <li>
              <a href="/dash">
                <span class="icon-toggle"><i class="mdi mdi-account"></i></span>
                <span class="title-toggle">Profile</span>
              </a>
            </li>
            <li>
              <a href="/dash/mytrikis">
                <span class="icon-toggle"><i class="mdi mdi-bank"></i></span>
                <span class="title-toggle">Bank</span>
              </a>
            </li>
            <li>
              <a href="/dash/settings">
                <span class="icon-toggle"><i class="mdi mdi-cog"></i></span>
                <span class="title-toggle">Settings</span>
              </a>
            </li>
            <li>
              <a href="/dash/messages">
                <span class="icon-toggle"><i class="mdi mdi-android-messages"></i></span>
                <span class="title-toggle">Messages</span>
              </a>
            </li>
          <?php else: ?>
            <li>
              <a href="/auth">
                <span class="icon-toggle"> <i class="mdi mdi-login-variant"></i></span>
                <span class="title-toggle">Login</span>
              </a>
            </li>  
          <?php endif ?>  
        </ul>
      </div>

    <!-- ==== Toggle btn Cart ==== -->
      <?php $items = 0/* ShopingCart::itemsCount() */ ?>
        <a class="btn-cart" href="<?= ($items == 0) ? '/shop' : '/shop/cart' ?>">
          <span class="mdi mdi-cart"></span>
          <div class="badge"><?= $items ?></div>
        </a>

    <!-- ==== Toggle Menu ==== -->
    <script>
        const navigation = document.querySelector('.navigation');
        document.querySelector('.toggle-float').onclick = function(){
        this.classList.toggle('active');
        navigation.classList.toggle('active')
        }
  </script>

