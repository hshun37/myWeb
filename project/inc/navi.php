<style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  a:link{
    color: black;
    text-decoration-line: none;
  }
  a:visited{
    color: black;
  }
  a:hover{
    color: #aaa;
  }
  #nav-item:hover{
    background-color:blue;
  }
  </style>

<nav class="navbar navbar-expand-lg navbar-white bg-white">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <?php
      if(!isset($_SESSION['admin_id'])){
      ?>
        <li class="nav-item">
        <a class="nav-link" href="#">...</a>
        </li>
      <?php
      } else {
      ?>
      <li class="nav-item">
      <a class="nav-link" href="#">...</a>
      </li>
      <?php
      }
      ?>

      <li class="nav-item">
        <a class="nav-link" href="#">...</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">...</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Board
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="board/board_list.php">Diary note</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../weather/weather_list.php">Weather</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>