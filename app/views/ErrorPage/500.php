  <section class="breadcrumbs-custom bg-image context-dark" style="background-image: url(/images/breadcrumbs-bg-2.jpg);">
    <div class="container">
      <h2 class="breadcrumbs-custom-title"><?= App::$lang->ServerError->server_problems_500 ?></h2>
    </div>
  </section>
  <!-- Blurb minimal-->
  <section class="section section-md bg-default">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
          <div class="big-title-wrap">
            <div class="big-title">500</div>
            <h5 class="big-title-text"><?= App::$lang->ServerError->server_problems_500_msg ?>.</h5>
          </div>
          <form class="rd-search rd-search-form" action="search-results.html" method="GET">
            <div class="form-wrap">
              <label class="form-label" for="search-form-input"><?= App::$lang->search ?></label>
              <input class="form-input" id="search-form-input" type="text" name="s" autocomplete="off">
            </div>
            <button class="rd-search-form-submit linearicons-magnifier" type="submit"></button>
          </form>
        </div>
      </div>
    </div>
  </section>