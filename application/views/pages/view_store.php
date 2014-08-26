<div class="large-6 columns main-content">
<link rel="stylesheet" href="<?php echo base_url();?>css/slider.css">
<script src="<?php echo base_url();?>js/vendor/modernizr.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>thickbox/css/thickbox.css" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>thickbox/javascript/thickbox.js"></script>	

        <h1>store detail</h1>
        <div class="row storetop">
          <div class="large-12 columns signup-button storedetails">
            <ul class="signup-button store-details">
              <li class="signup search">
                <form class="search" action="<?php echo base_url();?>store/searchstore" method="post">
                  <input type="text" name="storename" id="storename" placeholder="search" />
                  <input type="submit" value="submit">
                </form>
              </li>
			  
              <!--<li class="addtocintact"><a href="#" class="button"><span>add to contacts</span>add to contacts</a></li>-->
              <li class="pane"><a href="<?php echo base_url();?>taskpanel/addtask/<?=$this->uri->segment(3)?>" class="button"><span>add to task panel</span>add to task panel</a></li>
              <?php if($this->session->userdata('user_id')==$cat_detail->i_user_id){?>
			  <li class="edit_store"><a href="<?php echo base_url();?>store/editstore/<?=$this->uri->segment(3)?>" class="button"><span>Edit Store</span>Edit Store</a></li>
             <?php }?>
    <?php
			function curPageURL() {
			 $pageURL = 'http';
			 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			 $pageURL .= "://";
			 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			 } else {
			  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			 }
			 return $pageURL;
			}
?>          
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div id="fb-root"></div>
 <?php
$title=urlencode('ZEFAF|View Store');
$url=curPageURL();
$url=urlencode($url);
$summary=urlencode('Welcome');
$logo=base_url()."img/upload/".$cat_detail->s_store_logo;
$image=urlencode($logo);
?>
 <li class="social-share social-icons">
  <g:plusone></g:plusone> 
<span style="margin-left: -41px;"><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></span>
<div style="margin-left: 152px; margin-top: -30px;"><a style="padding:0px;" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" class="button1"><img width="65" src="<?php echo base_url();?>img/fb.png" /></a></a></div>

               </li>
            
              </ul>
          </div>
        </div>
        <div class="row">
        <?php //echo "<pre>";print_r($cat_detail);die;5:26?>
           <div class="large-12 columns detail-area logosize"> <img class="sd-img" src="<?php echo base_url();?>img/upload/<?=$cat_detail->s_store_logo?>">
            <p style="width: 388px; float: right; margin-top:-5px;"><strong><?=$cat_detail->s_store_name;?></strong>
            <?php   if($cat_detail->i_status==1){ ?>
					<span class="caption"> <img title="Confirmed" src="<?=base_url()?>img/icon_correct.jpg"></span>
					 
					<?php } ?>
            <br>
              <span class="city">City:</span> <?=$cat_detail->i_city;?><br>
              <span class="phoneno">Phone No:</span> <?=$cat_detail->i_store_phone_no?><br>
              <span class="email">E-mail:</span> <a href="mailto:<?=$cat_detail->s_store_email?>"><?=$cat_detail->s_store_email?></a><br>
              <span class="website">Website:</span><a href="<?=$cat_detail->s_store_website?>" target="_blank"> <?=$cat_detail->s_store_website?></a><br><span class="website">Description:</span><?=$cat_detail->s_storet_desc?><br>
              <span class="website">Instagram Account:</span>@<?=$cat_detail->s_instagram_account?><br>
              <span class="website">Twitter Account:</span>@<?=$cat_detail->s_twitter_account?>
              
              
              </p>
            
            <?php 
			//echo "<pre>";print_r($cat_detail);die;
			$partner->post_adres=$citydetail->countryName; 
			$partner->post_postcode='';
			$partner->post_city=$citydetail->cityName;
if ($partner->post_adres)
{
$map_url = $partner->post_adres.','.$partner->post_postcode.','.$partner->post_city;

$map_url = str_replace(" ", "+", $map_url);
?>
<div class="google-map">
<!--<iframe width="575" height="200" frameborder="0" style="border:0"  src="http://maps.google.nl/maps?q=<?=$map_url?>&hl=nl&ie=UTF8&t=v&z=13&amp;output=embed"></iframe>-->
<iframe width="575" height="200" frameborder="0" style="border:0"  src="https://maps.google.co.za/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $map_url; ?>&amp;aq=&amp;sll=-26.178375,28.033719&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;radius=15000&amp;t=m&amp;output=embed"></iframe
></div>
<?php
}?>

 
            <!--SLIDER-->
            
 <ul class="example-orbit thumb-slider" data-orbit>
  
     <li>
     <ul class="small-block-grid-4">
         <?php $i=1; 
			foreach($add_imgs as $img){?>
              <li class="logosize">
              <a href="<?php echo base_url();?>img/addimgupload/<?=$img['img_name']?>" title="add a caption to title attribute / or leave blank" class="thickbox">
              <img src="<?php echo base_url();?>img/addimgupload/<?=$img['img_name']?>"></a></li>
              <?php if($i==3 || $i==6){ ?>
              
              </ul>
              </li>
              
               <li>
                 <ul class="small-block-grid-4">
              <?php } $i++; } ?>
       </ul>
  </li>
  
   
</ul>
            
            <!--SLIDER CLOSE--> 
            
          </div>
        </div>
      </div>