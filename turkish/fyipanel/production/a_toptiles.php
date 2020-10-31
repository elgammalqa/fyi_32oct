          <style type="text/css">
   
   h4{
    margin-left: 10px; 
    margin-top: 10px !important;
   } 

  div .count{
     font-size: 26px !important;
         font-weight: 10 !important;
  } 

   .tile-stats .icon i { 
    font-size: 40px;  
  }
  .tile-stats .icon {
    top:5px !important;
    right:20px !important;
    width:15px !important;
  }

   .fsize{
     font-size: 16px !important;
   }
    .icon .fa {
    font-size: 25px !important;
}
   
 </style>
         <div class="row tile_count">        
           <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-user"></i>
                          </div>
                          <div class="count counter">
                            <?php  if (userModel::total_users()!=0) {
                                      echo userModel::total_users();
                                   }else{ echo "0"; }
                            ?> 
                          </div>  
                          <h4>Employees</h4> 
                        </div>
                      </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-users"></i>
                          </div>
                          <div class="count counter">
                               <?php  if (userModel::total_utilisateurs()!=0) {
                                   echo userModel::total_utilisateurs();
                                }else{ echo "0"; }
                                ?>  
                          </div> 
                          <h4>Users</h4> 
                        </div>
                      </div>
 

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-newspaper-o"></i>
                          </div>
                          <div class="count counter">
                               <?php  if (userModel::totl_news_published()!=0) {
                                        echo userModel::totl_news_published();
                                       }else{ echo "0"; }
                                ?>  
                          </div> 
                          <h4>News published</h4> 
                        </div>
                      </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-rss"></i>
                          </div>
                          <div class="count counter">
                               <?php  if (userModel::totl_rss()!=0) {
                                          echo userModel::totl_rss();
                                      }else{ echo "0"; }
                               ?>  
                          </div> 
                          <h4>Rss News</h4> 
                        </div>
                      </div> 
               </div>

         