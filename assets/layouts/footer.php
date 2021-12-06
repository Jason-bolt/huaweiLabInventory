
    <footer class="bg-dark text-center p-5 text-white mt-5">
      <div class="container">
        <p class="lead">Copyright HUAWEI LAB &copy; 2021</p>
        <?php
          if ($user_level !== 'none'){
        ?>
          <a href="assets/raw_php/logout.php" onclick="return confirm('Confirm logout...');" class="position-fixed bottom-0 end-0 p-5 z-3 text-danger" title="Logout">
            <i class="bi bi-x-circle-fill h1"></i>
          </a>
        <?php
          }
        ?>
      </div>
    </footer>
  </body>
</html>
