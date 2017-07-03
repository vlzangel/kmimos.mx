<?php
/*
	Template Name: TEMPLATE BLOG
*/
include_once(__DIR__.'/blog/header.php');
?>
<style>
    /*WIEWED*/
    #blog_viewed{position:relative; width:100%; margin:50px 0; overflow:hidden;}
    #blog_viewed .viewed{position:relative; overflow:hidden;}
    #blog_viewed .post{position:relative; width:calc(35% - 20px); padding-top:calc(35% - 20px); margin:20px 0 0 20px; float:left; color:#FFF; box-shadow:0 0 5px #555; background:#ff7e00; overflow:hidden; transition:all .5s;}
    #blog_viewed .control{display:none;}

    #blog_viewed .post .content{position:absolute; width:90%; height:60%; top:0; left:0; padding:20% 5%; opacity:0; background:#ff7e00; transition:all .3s;}
    #blog_viewed .post:hover .detail{opacity:1; /*background:#737373;*/}

    #blog_viewed .post .image{position:absolute; width:100%; height:100%; top:0; left:0; background:center/cover no-repeat;}
    #blog_viewed .post .title{position:absolute;  width: 100%;  height: auto;  padding:20px 0; bottom: 20px; color: #000;  font-size:20px; text-align:center; line-height: 1; background: rgba(255,255,255,0.6);}
    #blog_viewed .post .title:before {content: "+";  position: absolute;  width: 50px;  height: 50px;      padding: 5px 8px;  right: 0;  bottom: 0; color: #FFF;  font-size: 25px; font-weight: bold; text-align: right;  align-items: flex-end;  justify-content: flex-end; background: linear-gradient(135deg, transparent 50%, #900fa2 50%);  display: flex;  }
    #blog_viewed .post .autor{position:relative; margin:10px 0; font-size:18px; text-align:left; display:none;}
    #blog_viewed .post .content{position:relative; font-size:20px; text-align:justify; display:none;}
    #blog_viewed .post .category{position:relative; margin:10px 0; font-size:15px; font-weight:bold; display:none;}
    #blog_viewed .post .button.more{position:absolute; padding:5px 30px; color:#FFF; bottom:20px; right:20px; border:2px solid #FFF; background:transparent; display:none;}

    #blog_viewed .post:first-child{width:30%; padding-top:calc(70% - 20px); margin:20px 0 0 0;}
    #blog_viewed .post:first-child .image{}
    #blog_viewed .post:first-child .detail{opacity:1;}
    #blog_viewed .post:first-child .title{}
    #blog_viewed .post:first-child .content{display:none;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){
        #blog_viewed .post{width:calc(50% - 20px); padding-top:calc(35% - 20px);}
        #blog_viewed .post:nth-child(n+4){display:none;}
        #blog_viewed .post:first-child{width:50%; padding-top:calc(70% - 20px);}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #blog_viewed .post{width:calc(50% - 10px); padding-top:calc(50% - 10px);}
        #blog_viewed .post:nth-child(2){ margin-left: 0; }
        #blog_viewed .post:first-child{width:100%; padding-top:70%; margin: 0;}

        /* RESPONSIVE SUGERIDO */
        #blog_viewed{margin:10px 0;}
        #blog_viewed .post{width:100%; padding-top:70%; margin: 0; display: none;}
        #blog_viewed .post.show{display: block;}
        #blog_viewed .control{position: absolute; width: 100%; bottom: 0; text-align:center; display:block;}
        #blog_viewed .control .icon{width: 10px; height: 10px; margin:5px; border-radius: 50%; box-shadow: 0 0 5px #555; background: #FFF; cursor: pointer; display: inline-block;}
        #blog_viewed .control .icon.show{background: #23d3c4; display: inline-block !important;}
    }



    /*LAST*/
    #last{padding: 20px 0;}
    #last .group{display:flex; /*align-items: center;*/}
    #last .section{width: 50%;}
    #last .section.aside{}
    #last .section.news{width: 100%; padding:0 0 0 20px; border-left: 15px solid #6dd700;}
    #last .section.news .action{position: relative; overflow: hidden;}
    #last .section.news .action .icon.arrow{float: right;}
    #last .section.news .post{position:relative; margin: 0 0 20px 0; padding: 20px;  background: #FFF;  box-shadow: 15px 15px 20px -10px #CCC; display: none;  flex-flow: wrap;}
    #last .section.news .post.show{display: flex !important;}
    #last .section.news .post .image{float:right;  width:40%;  margin: 10px 5%;  background:center/cover no-repeat;}
    #last .section.news .post .detail{width: 50%;}
    #last .section.news .post .category{display: none;}
    #last .section.news .post .title {padding: 15px 0;  font-size: 17px;  font-weight: bold;}
    #last .section.news .post .content{padding: 0 0 50px 0;}
    #last .section.news .post .content:before {content: "+";  position: absolute;  width: 50px;  height: 50px;      padding: 5px 8px;  right: 0;  bottom: 0; color: #FFF;  font-size: 25px; font-weight: bold; text-align: right;  align-items: flex-end;  justify-content: flex-end; background: linear-gradient(135deg, transparent 50%, #900fa2 50%);  display: flex;  }
    #last .section.news .post .button.more{display:none;}

    #last .section.aside{}
    #last .section.aside .register{margin: 0 40px 0 0; padding: 40px; color: #FFF; font-size: 17px; border-radius: 20px; background: #900fa2;}
    #last .section.aside .register span{padding: 10px;  display: block;}
    #last .section.aside .register form{display:flex;}
    #last .section.aside .register input,
    #last .section.aside .register button{width: 100%; margin: 5px; padding: 5px 10px; color: #CCC; font-size: 15px; border-radius: 20px;  border: none; background: #FFF; }
    #last .section.aside .register button {padding: 10px;  width: 40px;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){
        #last .group{display: block;}
        #last .section{width: 100%;}
        #last .section.aside .register{margin:40px 0;}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #last .section.new .post .image { width: 100%;  height: 200px;  margin: 10px 0;}
        #last .section.new .post .detail { width: 100%; }

        /* RESPONSIVE SUGERIDO */
        #last{padding: 0;}
        #last .section.aside .register{margin: 10px 0;}
        #last .section.news{padding: 0;}
        #last .section.news .post.show{display: block !important;}
        #last .section.news .post.show + .post.show{display: none !important;}
        #last .section.news .post .image{width:auto; height:150px; margin:0; float:none;}
        #last .section.news .post .detail{width: auto;}
    }


    /*KMIBOX*/
    #kmibox{padding: 10px 0;  color: #FFF; font-size: 30px; text-align: center; background: #dadada;}
    #kmibox .group{display: flex; flex-flow: wrap;}
    #kmibox .section{width: 50%;}
    #kmibox .image{position:relative; background: center/contain no-repeat; background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/personaje-400x353.png');}
    #kmibox .detail{position:relative; padding: 40px 0; color:#999;  text-align: right;  line-height: 1.5;}
    #kmibox .detail .logo{height: 100px; background: center right/contain no-repeat; background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Logo-2.png');}
    #kmibox .detail .title{ margin: 10px 0; font-size: 20px; font-weight: bold;}
    #kmibox .detail .content{ margin: 10px 0; font-size: 15px;}
    #kmibox .detail .button{padding:10px 20px;  color: #FFF; font-size: 20px; border-radius:50px; cursor: pointer; background: #23d3c4 !important; display: inline-block;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){}
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #kmibox .section.detail{width: 100%;}
        #kmibox .section.image{position: absolute; width: 100%; height: 100%; opacity: 0.2;  }

        /* RESPONSIVE SUGERIDO */
        #kmibox .group {height: calc(100% - 150px);}
        #kmibox .section.image {display: none;}
        #kmibox .section.image.responsive{position: relative; height: 300px; opacity: 1; top: -100px; background-position: top right; display: block;}
        #kmibox .section.detail{max-width: 300px; padding: 0; text-align: left;}
        #kmibox .detail .logo{background-position: center left;}
        #kmibox .detail .button {font-size: 15px;}

    }

    /*FEATURED*/
    #featured{}
    #featured .info{ padding: 25px 0;  color: #FFF; font-size: 30px; text-align: center; background: #900fa2; }
    #featured .caregiver{position:relative;}
    #featured .caregiver .action{position:absolute; width:100%; height:100%;}
    #featured .caregiver .action .icon{position:absolute; width:25px; top:calc(50% - 12px); right:0; font-size:15px;}
    #featured .caregiver .action .icon[data-direction="prev"]{left:0; right: auto;}
    #featured .group{width:calc(100% - 80px); margin:0 auto; display: flex; flex-flow: wrap;}
    #featured .post{width: calc(50% - 20px); margin: 40px 10px; display: flex; flex-flow: wrap;}
    #featured .post .image{width: 150px; padding: 20px; border-radius:20px 0 0 20px; background: #ff8700; overflow:hidden;}
    #featured .post .image .img{width: 90%; padding-top: 90%; margin: 10px auto; border-radius: 50%; background: #CCC center/cover no-repeat;}
    #featured .post .image .bone{ width: 50px; height: 40px; margin: 0 auto; background: center/contain no-repeat;}
    #featured .post .image .rating{color: #FFF; font-size: 20px; font-weight: bold; text-align: center; }
    #featured .post .image .rating:before{content: "+";}
    #featured .post .detail{width: calc(100% - 150px); padding: 20px; border:2px solid #8f8f8f; border-left-width:0; border-radius:0 20px 20px 0; overflow:hidden;}
    #featured .post .detail .title{color: #888; font-size: 30px;}
    #featured .post .detail .content{margin:30px 0; color: #888; font-size: 20px;}

    @media screen and (max-width:768px), screen and (max-device-width:768px){
        #featured .group{display: block;}
        #featured .post{width: calc(100% - 20px);}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        /*
        #featured .post{display: block;}
        #featured .post .image{width: auto; border-radius: 20px 20px 0 0;}
        #featured .post .image .img{width: 100px; padding-top: 100px;}
        #featured .post .detail{width: auto; border-left-width: 2px; border-top-width: 0; border-radius: 0 0 20px 20px; text-align: center;}
        #featured .post .detail .title{font-size: 20px;}
        #featured .post .detail .content{margin:10px 0; font-size: 15px;}
        */
        /* RESPONSIVE SUGERIDO */
        #featured .info{font-size: 20px;}
        #featured .post:nth-child(2){display: none;}
        #featured .post .image{width: 100px; padding: 5px;}
        #featured .post .detail{width: calc(100% - 100px);}
        #featured .post .detail .title{font-size: 20px;}
        #featured .post .detail .content{margin:10px 0; font-size: 15px;}

    }


    /*PRODUCTS*/
    #products{padding: 25px 0; }
    #products .kmibox{position:relative;}
    #products .kmibox .action{position:absolute; width:100%; height:100%;}
    #products .kmibox .action .icon{position:absolute; width:25px; top:calc(50% - 12px); right:0; font-size:15px;}
    #products .kmibox .action .icon[data-direction="prev"]{left:0; right: auto;}
    #products .kmibox .group{width:calc(100% - 80px); margin:0 auto; display: flex; flex-flow: wrap;}
    #products .product{width: calc(25% - 80px); margin: 40px;}
    #products .product .image{width: 100%; padding-top: 100%; background: #CCC center/cover no-repeat;}
    #products .product .detail{padding: 10px; text-align: center; overflow:hidden;}
    #products .product .detail .title{color: #888; margin-bottom: 30px; font-size: 15px;}
    #products .product .detail .content{margin:10px 0; color: #888; font-size: 15px; }
    #products .product .detail .content.price{color: #23d3c4; font-size: 25px; }
    #products .product .detail .button{padding:10px; color:#999; border:1px solid #999; border-radius:5px; }



    @media screen and (max-width:768px), screen and (max-device-width:768px){
        #products .product {width: calc(50% - 80px);}
        #products .product .detail .title{margin-bottom: 0px;}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #products .product { width: calc(50% - 20px);  margin: 10px;}

        /* RESPONSIVE SUGERIDO */
        #products .product{width: calc(100% - 20px); display: none;}
        #products .product:first-child{display: block;}
    }



</style>


<section id="blog_viewed">
    <div class="contain">
        <div class="action">
            <span class="blog_title">LO MAS LEIDO</span>
        </div>
        <div class="section viewed">
            <?php
                include_once(__DIR__.'/blog/process/viewed.php');
            ?>
            <div class="control"></div>
        </div>
    </div>
</section>

<?php
$page=get_query_var('paged');
$pageNEXT=site_url().'/'.$slug.'/page/'.($page+1).'#last';
$pagePREV=site_url().'/'.$slug.'/page/'.($page-1).'#last';
if($page<=0){
    $pageNEXT=site_url().'/'.$slug.'/page/'.($page+2).'#last';
    $pagePREV=site_url().'/'.$slug.'#last';
}

?>

<section id="last">
    <div class="group contain">
        <div class="section aside">
            <div class="register">
                <span>Te interesaron nuestros Articulos?</span>
                <span><strong>SUSCRIBETE?</strong> y recibe el Newsletter con lo mejor de nuestros post!</span>
                <?php echo subscribe_input(); ?>
            </div>
        </div>
        <div class="section news">
            <div class="action">
                <span class="blog_title">LO MAS NUEVO</span>
                <i class="icon arrow fa fa-caret-right" data-direction="next"><a class="absolute"  href="<?php echo $pageNEXT;?>"></a></i>
                <i class="icon arrow fa fa-caret-left" data-direction="prev"><a class="absolute"  href="<?php echo $pagePREV;?>"></a></i>
            </div>
            <?php
                include_once(__DIR__.'/blog/process/news.php');
            ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    var news_show=-1;
    var news_count=2;
    var news_navigate=1;
    var news_action = false;
    var news_post=jQuery('#last .section.news .post');

    jQuery('#last .section.news .action .icon.arrow a').click(function(event){
        if(jQuery(this).closest('.icon.arrow').length){
            news_nav(jQuery(this).closest('.icon.arrow'));
        }

        if(news_action == false){
            event.preventDefault();
            event.stopPropagation();
        }
    });


    function news_nav(element){
        if(news_action == false){
            news_post.removeClass('show');
            var direction = jQuery(element).data('direction');
            var show = news_show;

            if(direction=='prev'){
                show=show-(news_navigate*news_count);
            }

            for(var news=1; news<=news_count; news++){
                var post=show+news+(news_navigate-news_count);//

                if(post<0){
                    post=0;

                }else if(post==(news-news_count) && news<=news_count){
                    post++;

                }

                //console.log(post);
                if(news_show_display(post)){
                    news_show=post;

                }else{
                    if(news_post.closest('.news').find('.post.show').length<=news_count){
                        news_action = true;
                        jQuery(element).find('a').trigger('click');
                        break;
                    }
                }
            }
        }
    }

    function news_show_display(post){
        var news=news_post.eq(post);
        if(news.length>0 && post>=0){
            news.addClass('show');
            return true;
        }
        return false;
    }

    news_nav('');
</script>

<section id="featured">
    <div class="info">
        <div class="contain">
            CONOCE A UN CUIDADOR PARA QUE CONSIENTA A TU PERRHIJO
        </div>
    </div>
        <?php
            include_once(__DIR__.'/blog/frontend/featured.php');
        ?>
</section>

<section id="kmibox">
    <div class="group contain">
        <div class="section image"></div>
        <div class="section detail">
            <div class="logo"></div>
            <div class="title">Conoce  y elige el plan que <br>mejor te convenga</div>
            <div class="content">Regalale un detalle al consentido de tu hogar!</div>
            <div class="button">Quiero mi KmiBOX</div>
        </div>
        <div class="section image responsive"></div>
    </div>
</section>


<section id="products">
    <?php
    include_once(__DIR__.'/blog/frontend/products.php');
    ?>
</section>




<?php
    include_once(__DIR__.'/blog/footer.php');
?>
