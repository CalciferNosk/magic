<style>
  #nav-list {
    color: white;
    text-decoration: none;
    font-family: Tahoma, Geneva, sans-serif;
    font-size: 13px !important;
    text-transform: uppercase;
    line-height: 50px;

  }

  #nav-list:hover {
    color: yellow;
  }

  #logo {
    margin-right: 50px;
  }
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
  }



</style>
<nav id="navbar" class="navbar navbar-expand-lg" style="background: #24388e !important;">
  <div class="container-fluid">
    <a style="padding: 0px !important" id="logo" class="navbar-brand" href="<?= base_url(); ?>careers"><img src="<?= base_url(); ?>assets/images/motortrade.png" style="max-width: 230px;height :auto" /></a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"> </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div id="navbar-nav" class="navbar-nav">
        <a class="nav-link" href="<?= base_url(); ?>careers" id="nav-list">
          <b style="margin-left:10px;"> Careers</b>
          <span class="sr-only">(current)</span>
        </a>
      </div>
    </div>
  </div>
</nav>