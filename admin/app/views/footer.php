<!-- ========== Footer Start ========== -->
               <footer class="footer">
                   <div class="container-fluid">
                       <div class="row">
                           <div class="col-12 text-center">
                               <script>document.write(new Date().getFullYear())</script> &copy; Larkon. Crafted by <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon> <a
                                   href="https://1.envato.market/techzaa" class="fw-bold footer-text" target="_blank">Techzaa</a>
                           </div>
                       </div>
                   </div>
               </footer>
               <!-- ========== Footer End ========== -->

          </div>
          <!-- End Page Content -->
     </div>
     <!-- END Wrapper -->

     <!-- Theme Config -->
     <script src="<?=ASSETS?>js/config.js"></script>
     
     <!-- Vendor Javascript -->
     <script src="<?=ASSETS?>js/vendor.js"></script>

     <!-- App Javascript -->
     <script src="<?=ASSETS?>js/app.js"></script>

     <?php if(isset($data['js_files'])): ?>
          <?php foreach($data['js_files'] as $js_file): ?>
               <script src="<?=ASSETS?>js/<?=$js_file?>"></script>
          <?php endforeach; ?>
     <?php endif; ?>

</body>
</html>