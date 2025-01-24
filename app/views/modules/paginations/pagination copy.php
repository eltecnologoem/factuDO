<div class="pagination-wrap">
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <?php if (isset($pages['total_pages']) and !empty($pages['total_pages'])) : ?>
        <?php for ($i = 1; $i <= $pages['total_pages']; $i++) : ?>
          <li class="page-item <?= ((isset($_GET['page']) and $_GET['page'] == $i) or ($i == 1 and !isset($_GET['page']))) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor ?>
      <?php endif ?>
    </ul>
  </nav>
</div>