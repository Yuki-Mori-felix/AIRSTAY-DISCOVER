<?php
include TEMPLATEPATH . '/inc/my_variables.php';
?>

<header id="header">
  <div class="header-wrap">
    <?php if (!is_user_logged_in()): ?>
      <div class="language"><?php echo do_shortcode('[linguise]'); ?></div>
    <?php endif; ?>
    <div class="header-logo">
      <a href="<?= $home_url; ?>/">
        <img src="<?= $img_path ?>/logo.png" alt="AIRSTAY DISCOVER">
        <h1 class="notranslate">AIRSTAY <br class="sp-br">DISCOVER</h1>
      </a>
    </div>
    <div class="header-menu">
      <ul>
        <li>
          <a href="<?= $home_url; ?>/experiences/">
            <img class="header-menu-img" src="<?= $img_path; ?>/h-menu-act.png" alt="">
            <img class="header-menu-img-hover" src="<?= $img_path; ?>/h-menu-act-hover.png" alt="">
            <p>Activities</p>
          </a>
        </li>
        <li>
          <a href="#" class="header-menu-search-button">
            <img class="header-menu-img" src="<?= $img_path; ?>/h-menu-search.png" alt="">
            <img class="header-menu-img-hover" src="<?= $img_path; ?>/h-menu-search-hover.png" alt="">
            <p>Search</p>
          </a>
          <div class="header-menu-search">
            <form method="get" action="<?= $home_url; ?>/experiences/">
              <div class="search-box">
                <input type="text" id="event_search" name="s" placeholder="Search activities and destinations">
                <input type="hidden" name="post_type" value="event">
                <button type="submit">search</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <a href="#" class="sp-menu-button">
            <span>
              <span class="icon">
                <span class="bar">
                  <span></span>
                </span>
              </span>
            </span>
            <p>Menu</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
<nav class="sp-nav">
  <div class="sp-nav-container">
    <ul class="sp-nav-list">
      <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/">Home</a></h3>
      </li>
      <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/experiences/">Experiences</a></h3>
      </li>
      <!-- <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/">Operating Company</a></h3>
      </li>
      <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/">Contact</a></h3>
      </li>
      <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/">Privacy Policy</a></h3>
      </li>
      <li class="sp-nav-item">
        <h3><a href="<?= $home_url; ?>/">Terms of Service</a></h3>
      </li> -->
    </ul>
    <div class="sp-nav-search">
      <form method="get" action="<?= $home_url; ?>/experiences/">
        <div class="search-box">
          <input type="text" id="event_search" name="s" placeholder="Search activities and destinations">
          <input type="hidden" name="post_type" value="event">
          <button type="submit">search</button>
        </div>
      </form>
    </div>
  </div>
</nav>