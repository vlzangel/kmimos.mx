<?php
include_once(__DIR__.'/header.php');
?>

<style type="text/css">
    /*SINGLE*/
    #single{position:relative; text-align:left; background:#FFF; overflow:hidden;}
    #single .image{position:relative; width:100%; margin:50px 0;}
    #single .single{position:relative; margin:-150px auto 50px auto; padding:30px 50px; border-radius:20px; box-shadow:0 0 10px #555; background:#FFF;}
    #single .single .title{position:relative; margin:0; padding:40px 0; color:#fdc421; font-size:25px; font-weight:bold; text-align:left;}
    #single .single .content{position:relative; color:#555; font-size:15px; line-height: 1.3; display: flex;}
    #single .single .content .column{width:100%; margin:0 10px;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){}
    @media screen and (max-width:480px), screen and (max-device-width:480px){}


    /*FEATURED*/
    #featured{position:fixed; width: 500px; max-width: 100%; top: calc(50% - 220px); right: calc(100% - 40px); border-radius:0 20px 20px 0; background: #dadada; z-index:1; transition: all .3s;}
    #featured.show{/*right: auto;*/}
    #featured .caregiver{position:relative; max-width: calc(100% - 80px); min-width: 150px; overflow: hidden;}
    #featured .caregiver .action{display: none;}
    #featured .caregiver .action,
    #featured .show{position:absolute; width:100%; height:100%;}
    #featured.show .show .icon:before{content:"\f0d9";}
    #featured .caregiver .action .icon,
    #featured .show .icon{position:absolute; width:25px; top:calc(50% - 12px); right:0; font-size:15px;}
    #featured .caregiver .action .icon[data-direction="prev"]{left:0; right: auto;}
    #featured .group{width: 350px; max-width: 100%; margin: 0; float: right; display:block !important;}
    #featured .post{ width:100%; margin:10px 0; display: flex; flex-flow: wrap;}
    #featured .post .image{width: 100px; padding: 10px; border-radius:20px 0 0 20px; background: #ff8700; overflow:hidden;}
    #featured .post .image .img{width: 90%; padding-top: 90%; margin: 0 auto; border-radius: 50%; background: #CCC center/cover no-repeat;}
    #featured .post .image .bone{ width: 50px; height: 20px; margin: 0 auto; background: center/contain no-repeat;}
    #featured .post .image .rating{margin: 5px 0; color: #FFF; font-size: 15px; font-weight: bold; text-align: center; }
    #featured .post .image .rating:before{content: "+";}
    #featured .post .detail{width: calc(100% - 100px); padding: 5px; border:2px solid #8f8f8f; border-left-width:0; border-radius:0 20px 20px 0; background: #FFF; overflow:hidden;}
    #featured .post .detail .title{color: #888; font-size: 15px;}
    #featured .post .detail .content{margin:10px 0; color: #888; font-size: 12px;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){
        #single .single .content{display: flex; flex-flow: wrap;}
        #single .single .content .column{width:calc(50% - 20px);}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #single .single .content .column{width:100%; margin: 0;}
        #featured .post{display: block;}
        #featured .post .image{width: auto; border-radius: 20px 20px 0 0;}
        #featured .post .image .img{width: 50px; padding-top: 50px;}
        #featured .post .detail{width: auto; border-left-width: 2px; border-top-width: 0; border-radius: 0 0 20px 20px; text-align: center;}
    }

</style>

<?php
$POSTarray=array();
while(have_posts()){
    the_post();

    $img=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
    $thumbnail=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');

    $img=str_replace('http://kmimos.dev.mx/','https://kmimos.com.mx/',$img);
    $thumbnail=str_replace('http://kmimos.dev.mx/','https://kmimos.com.mx/',$thumbnail);

    $POSTarray['title']=the_title('','',false);
    $POSTarray['image']=$img;
    $POSTarray['thumbnail']=$thumbnail;
    $POSTarray['content']=get_the_content();//wp_trim_words(strip_tags(), 20, $more = ' ...');
    $POSTarray['custom']=get_post_custom($post->ID);
    //echo $post->ID.'<br/>';
}
?>

<section id="single">
    <?php if($POSTarray['image'][0]!=''){?>
        <img class="image" data-original="<?php echo $POSTarray['image'][0]; ?>" src="<?php echo $POSTarray['thumbnail'][0]; ?>" alt="<?php echo $POSTarray['title']; ?>">
    <?php }?>
    <div class="single contain">
        <div class="title scroll_animate" data-position="self" data-scale="small"><?php echo $POSTarray['title']; ?></div>
        <div class="content scroll_animate" data-position="top" data-scale="small">
            <?php echo wpautop($POSTarray['content'], true); ?>
        </div>
    </div>
</section>

<section id="featured" class="">
    <div class="show">
        <i class="icon arrow fa fa-caret-right" data-direction="next"></i>
    </div>
    <?php
        include_once(__DIR__.'/frontend/featured.php');
    ?>
</section>

<script type="text/javascript">
    jQuery(document).on('click','#featured .show .icon', function(e){
        featured_show(this);
    });

    function featured_show(element){
        var featured = jQuery(element).closest('#featured');
        if(featured.hasClass('show')){
            featured.removeClass('show');
            jQuery('#featured').css({'right':''});
        }else{
            featured.addClass('show');
            var width= jQuery('#featured.show').width();
            jQuery('#featured.show').css({'right':'calc(100% - '+width+'px)'});
        }
    }

    function divide_content(column, separator){
        var content = jQuery('#single .single .content');
        var sections = content.find(separator).length;
        var text = content.html();
        content.html('');

        for(var i=0; i<column; i++){
            content.append('<div class="column column'+i+'">'+text+'</div>');
            text='';

            if(i>0){
                var iprev =  (i-1);
                content.find('.column'+iprev+' > '+separator).slice(Math.ceil(sections/(column-iprev))).appendTo(content.find('.column'+i));
            }
        }
    }
    divide_content(2, 'p, h1, h2, h3, ul');
</script>

<?php
include_once(__DIR__.'/footer.php');
?>
