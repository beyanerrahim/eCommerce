<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN')?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link linknav" href="categories.php"><?php echo lang('GATEGORIES')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link linknav" href="items.php"><?php echo lang('ITEMS')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link linknav" href="members.php"><?php echo lang('MEMBERS')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link linknav" href="comments.php"><?php echo lang('COMMENTS')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link linknav" href="#"><?php echo lang('STATISTIC')?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link linknav" href="#"><?php echo lang('LOGS')?></a>
      </li>
    </ul>
    <ul class="navbar-nav mr-right">
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">Categories</a>
      </li> -->
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          beyan
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
           <a class="dropdown-item" href="../index.php">Main Menu</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ;?>">Edit profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
  </div>
  </div>
</nav>



<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="container">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link ml-3" href="#">Categories</a>
      </li>
    
    </ul>
    <ul class="navbar-nav mr-right">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         beyan
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Edit profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Logout</a>
        </div>
      </li>

    </ul>
    </div>
  </div>
</nav> -->
