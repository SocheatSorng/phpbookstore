<!-- ========== App Menu Start ========== -->
<div class="main-nav">
     <!-- Sidebar Logo -->
     <div class="logo-box">
          <a href="index.php" class="logo-dark">
               <img src="assets/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="assets/images/logo-dark.png" class="logo-lg" alt="logo dark">
          </a>

          <a href="index.php" class="logo-light">
               <img src="assets/images/logo-sm.png" class="logo-sm" alt="logo sm">
               <img src="assets/images/logo-light.png" class="logo-lg" alt="logo light">
          </a>
     </div>

     <!-- Menu Toggle Button -->
     <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
          <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
     </button>

     <div class="scrollbar" data-simplebar>
          <ul class="navbar-nav" id="navbar-nav">
               <li class="menu-title">General</li>

               <li class="nav-item">
                    <a class="nav-link" href="index.php">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Dashboard </span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="product.php">
                              <span class="nav-icon">
                                   <iconify-icon icon="solar:book-bold-duotone"></iconify-icon>
                              </span>
                              <span class="nav-text"> Book </span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="category.php">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Category </span>
                    </a>
               </li>

                  <li class="nav-item">
                         <a class="nav-link" href="attribute.php">
                               <span class="nav-icon">
                                     <iconify-icon icon="solar:tag-bold-duotone"></iconify-icon>
                               </span>
                               <span class="nav-text"> Attribute </span>
                         </a>
                  </li>

               <li class="nav-item">
                    <a class="nav-link" href="purchase.php">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:card-send-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Purchase </span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="order.php">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Orders </span>
                    </a>
               </li>

               <!-- This section is correctly commented out because order-detail should be accessed through the orders list -->
               <!-- <li class="nav-item">
                    <a class="nav-link" href="order-detail">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Order Detail </span>
                    </a>
               </li> -->

               <li class="nav-item">
                    <a class="nav-link" href="user.php">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> User </span>
                    </a>
               </li>

                  <!-- Removed cart menu item since it's not needed in admin panel -->

                  <li class="nav-item">
                         <a class="nav-link" href="setting.php">  <!-- Changed from "setting" to "setting.php" -->
                               <span class="nav-icon">
                                     <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                               </span>
                               <span class="nav-text"> Settings </span>
                         </a>
                  </li>

          </ul>
     </div>
</div>
<!-- ========== App Menu End ========== -->