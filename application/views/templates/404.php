<style type="text/css">
  .container {
    padding-right: 0px;
    padding-left: 0pxpx;
    margin-right: auto;
    margin-left: auto;
  }

  .center{
    margin-right: auto;
    margin-left: auto;
  }

  .text-center {
    text-align: center;
  }

  .page_error {
    width: 100%;
    height: 100%;
    background-color: #fff;
  }

  .page_error .error_status h1 {
    margin: 50px 0 -45px;
    color: #D80404;
    font-size: 200px;
  }

  .page_error .error_message {
    background-color: #D80404;
    padding: 24px;
    text-transform: uppercase;
  }

  .page_error .error_message h2 {
    font-size: 50px;
    color: white;
    font-weight: 300;
  }
</style>

<div class="container text-center">
  <div class="page_error">
    <div class="error_status">
      <h1>404</h1>
    </div>
    <div class="error_message">
      <h2>PAGE NOT FOUND.</h2>
    </div>
    <br/>
    <div class="container center" >
      <a href=<?php echo ROOT;?> class="btn btn-lg btn-danger" style="text-decoration:none;"><i class="fa fa-fw fa-home"></i> Take Me Home</a>
    </div>
  </div>
</div>