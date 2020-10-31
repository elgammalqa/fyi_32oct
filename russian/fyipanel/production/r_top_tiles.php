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
                          <div class="icon"><i class="fa fa-list"></i>
                          </div>
                          <div class="count counter">
                          <?php if (newsModel::getTotalNews($fyipEmail)!=0) {
                                echo newsModel::getTotalNews($fyipEmail);
                           }else{
                                echo "0";
                          }?>  
                          </div>  
                          <h4>Total News</h4> 
                        </div>
                      </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-newspaper-o"></i>
                          </div>
                          <div class="count counter">
                              <?php if (newsModel::getTotalNewsNotSent($fyipEmail)!=0) {
                                 echo newsModel::getTotalNewsNotSent($fyipEmail);
                                }else{
                                  echo "0";
                                }?>  
                          </div> 
                          <h4>Total News Not Sent</h4> 
                        </div>
                      </div>
 

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-paper-plane"></i>
                          </div>
                          <div class="count counter">
                                <?php if (newsModel::getTotalNewsSent($fyipEmail)!=0) {
                                   echo newsModel::getTotalNewsSent($fyipEmail);
                                  }else{
                                    echo "0";
                                  }?>    
                          </div>  
                          <h4>Total News Sent</h4> 
                        </div>
                      </div> 

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-check"></i>
                          </div>
                          <div class="count counter">
                                 <?php if (newsModel::getTotalNewsPublished($fyipEmail)!=0) {
                                   echo newsModel::getTotalNewsPublished($fyipEmail);
                                  }else{
                                    echo "0";
                                  }?>    
                          </div> 
                          <h4>Total News Published</h4> 
                        </div>
                      </div> 
               </div>

          