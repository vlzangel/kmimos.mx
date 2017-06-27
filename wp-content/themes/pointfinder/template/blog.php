<?php

/*
	Template Name: TEMPLATE BLOG
*/
wp_head();
the_post();
//get_template_part('functions/sections/template/template-sections');

global $post;
$slug=$post->post_name;
$page_current=site_url().'/'.$slug;

$search='';
if(array_key_exists('search',$_POST)){
    $search = $_POST['search'];
}
?>
<style>
    a.absolute{position: absolute; width: 100%; height: 100%;  top: 0; left: 0;}
    .contain{position: relative; width: 95%; max-width: 1000px; margin: 0 auto; line-height: 1;}
    .logo{background:url(https://www.kmimos.com.mx/wp-content/uploads/2017/06/logo-01.png) center/contain no-repeat;}
    .blog_title{color: #ff8700; font-size: 35px; font-weight: bold;}
    .icon.arrow{position: relative; width: 50px; padding: 5px 0; margin: 5px 5px; color: #FFF; font-size: 40px; text-align: center; border-radius: 50%; cursor: pointer; background: #900fa2;  }

    @media screen and (max-width:768px), screen and (max-device-width:768px){}
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        .icon.arrow{width:25px; font-size:15px;}
        .blog_title{display:block; text-align:center;}
    }


    /*HEADER*/
    header .logo{width: 100%; max-width: 500px;  height: 300px; margin: 0 auto;}
    header .info{padding: 10px;  color: #FFF; font-size: 20px;  background: #23d3c4; overflow: hidden;}
    header .info .icon{width: 40px; margin: 0 10px; padding:10px; color: #23d3c4; text-align: center; border-radius: 50%; background: #FFF;}
    header .info .icon.help{float:right; cursor: pointer;}
    header .info .session{padding: 10px; float:right; border-left: 2px solid #FFF;}

    header .redes{position:absolute; width:70px;  right: 0;  top:calc(50% - 150px);}
    header .redes .icon{width: 40px; margin:5px 0; padding:10px; color: #FFF; font-size: 20px; text-align: center; border-radius: 50%; cursor: pointer; background: #23d3c4;}
    header .redes .icon.bolsa{ height: 40px; border-radius: 0; display: block; background:url(https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-05.png) center/contain no-repeat;}

    header .search{position: relative; color: #aaa; font-size: 15px; text-align: right;}
    header .search input{position: relative; padding:5px 10px; border:1px solid #aaa; border-radius: 20px;}
    header .search input:focus{border-color: #ff8700 !important;}
    header .search button{position: relative; outline: none; border: none; background: none;}

    header .menu{position: relative; border: 1px solid #aaa;}
    header .menu .items{display: flex; align-items: center;}
    header .menu .items .item{width: 100%;  padding: 10px; color: #aaa; font-size: 20px; text-align: center; border-right: 1px solid #aaa; cursor: pointer;}
    header .menu .items .item.caregiver{width: 250%; color: #FFF; border: none; background: #ff8700;}
    header .menu .responsive{text-align: right; display: none;}
    header .menu .responsive .bar{padding: 10px; font-size: 30px; cursor: pointer;}

    header .menu .items.show{position: absolute; width: 100%; top: 100%; border: 1px solid #aaa; background: #FFF; display: block; z-index: 1;}
    header .menu .items.show .item{width: 100%; text-align: right; border: none;}


    @media screen and (max-width:768px), screen and (max-device-width:768px){
        header .info {text-align: center;}
        header .info span{ display: block;}
        header .info .session {float: none; border: none; }
        header .info .icon.help{display: none;}
        header .logo {height: 200px;}

        header .redes{position: relative; width: auto; margin: 10px 0; text-align: center; top: auto;}
        header .redes .icon.bolsa{width: 40px; margin: 0 5px; padding: 15px; display: initial;}

        header .menu{border-width: 1px 0 1px 0;}
        header .menu .items{display: none;}
        header .menu .responsive{display: block;}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){}


    /*WIEWED*/
    #blog_viewed{position:relative; width:100%; margin:50px 0; overflow:hidden;}
    #blog_viewed .viewed{position:relative; overflow:hidden;}
    #blog_viewed .post{position:relative; width:calc(35% - 20px); padding-top:calc(35% - 20px); margin:20px 0 0 20px; float:left; color:#FFF; box-shadow:0 0 5px #555; background:#ff7e00; overflow:hidden; transition:all .5s;}

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
    }

    /*FEATURED*/
    #featured{}
    #featured .info{ padding: 25px 0;  color: #FFF; font-size: 30px; text-align: center; background: #900fa2; }
    #featured .caregiver{position:relative;}
    #featured .caregiver .action{position:absolute; width:100%; height:100%;}
    #featured .caregiver .action .icon{position:absolute; width:25px; top:calc(50% - 12px); right:0; font-size:15px;}
    #featured .caregiver .action .icon[data-direction="prev"]{left:0; right: auto;}
    #featured .group{width:calc(100% - 80px); margin:0 auto; display: flex; flex-flow: wrap;}
    #featured .post{width: calc(50% - 80px); margin: 40px; display: flex; flex-flow: wrap;}
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
        #featured .post{width: calc(100% - 80px);}
    }
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        #featured .post{display: block;}
        #featured .post .image{width: auto; border-radius: 20px 20px 0 0;}
        #featured .post .image .img{width: 100px; padding-top: 100px;}
        #featured .post .detail{width: auto; border-left-width: 2px; border-top-width: 0; border-radius: 0 0 20px 20px; text-align: center;}
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
    }


    /*FOOTER*/
    footer{}
    footer .contact{ padding: 20px 0; background: #ededed;}
    footer .contact .group{display: flex; flex-flow: wrap; align-items: center;}
    footer .contact .section{width: 28%;}
    footer .contact .section.redes{width: 16%;}
    footer .contact .section.redes .icon{ width: 40px; margin:5px 0; padding:10px; color: #FFF; font-size: 20px; text-align: center; border-radius: 50%; cursor: pointer; background: #23d3c4; display: block;}
    footer .contact .section .item{padding: 5px 0; font-size: 15px;}
    footer .contact .section .item a{color: #0992a3;}
    footer .contact .section .item.title{ font-size: 15px; font-weight: bold;}

    footer .payment{ padding: 20px 0; background: #FFF;}
    footer .payment .group{display: flex; flex-flow: wrap; align-items: center;}
    footer .payment .section{ }
    footer .payment .title{ width: 30%; font-size: 20px; font-weight: bold;}
    footer .payment .items{ width: 70%;}
    footer .payment .items .item{ width: calc(15% - 20px); margin: 10px; padding-top: 5%;  background: #FFF center/contain no-repeat; display: inline-block;}

    footer .info{ padding: 10px;  color: #FFF; font-size: 20px; text-align: center; background: #23d3c4; }


    @media screen and (max-width:768px), screen and (max-device-width:768px){}
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        footer .contact .group{display: block;}
        footer .contact .section{width: auto; margin: 10px 0;}
        footer .contact .section.redes{width: auto; text-align: center;}
        footer .contact .section.redes .icon{display: inline-block;}

        footer .payment .group{display: block; text-align: center;}
        footer .payment .title{width: auto;}
        footer .payment .items{width: auto;}
    }

</style>

<header>
    <div class="info">
        <div class="contain">
            <span>Habla con nosotros</span>
            <span>
            <i class="icon phone fa fa-phone"></i>
            +52 (55) 1791.4931 +52 (55) 6631.9264
            </span>
            <div class="session">Inicia de Sesion</div>
            <i class="icon help fa fa-question"></i>
        </div>
    </div>
    <div class="contain">
        <div class="logo"></div>
        <div class="redes">
            <i class="icon phone fa fa-facebook"></i>
            <i class="icon phone fa fa-twitter"></i>
            <i class="icon phone fa fa-instagram"></i>
            <i class="icon bolsa"></i>
        </div>

        <div class="search">
            <form  method="post" action="<?php echo $page_current.'#last'; ?>">
                <input type="text" name="search" value="<?php echo $search; ?>" placeholder=""/>
                <button type="submit"><span class="fa fa-search"></span> BUSCAR</button>
            </form>
        </div>

        <div class="menu">
            <div class="items">
                <div class="item">KMIMOS</div>
                <div class="item">BENEFICOS</div>
                <div class="item">FAQ</div>
                <div class="item">SERVICIOS</div>
                <div class="item caregiver">QUIERO SER CUIDADOR</div>
            </div>
            <div class="responsive">
                <i class="bar fa fa-bars" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</header>

<script type="text/javascript">
    jQuery('header .menu .responsive .bar').click(function(e){
        responsive_menu(this);
    });

    function responsive_menu(element){
        var items = jQuery(element).closest('.menu').find('.items');
        if(items.hasClass('show')){
            items.removeClass('show');
        }else{
            items.addClass('show');
        }
    }
</script>


<section id="blog_viewed">
    <div class="contain">
        <div class="action">
            <span class="blog_title">LO MAS LEIDO</span>
        </div>
        <div class="section viewed">
            <?php
                include_once(__DIR__.'/blog/frontend/viewed.php');
            ?>
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
                include_once(__DIR__.'/blog/frontend/news.php');
            ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    var news_show=-1;
    var news_count=2;
    var news_post=jQuery('#last .section.news .post');
    var news_action = false;

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
                show=show-(2*news_count);
            }

            for(var news=1; news<=news_count; news++){
                var post=show+news;

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
    <div class="caregiver contain" data-section="<?php echo bloginfo('template_directory'); ?>/template/blog/frontend/featured.php">
        <div class="action">
            <i class="icon arrow fa fa-caret-left" data-direction="prev"></i>
            <i class="icon arrow fa fa-caret-right" data-direction="next"></i>
        </div>
        <div class="group">
            <?php
                //include_once(__DIR__.'/blog/frontend/featured.php');
            ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    var featured = 1;
    jQuery(document).on('click','#featured .caregiver .action .icon', function(e){ featured_page(this); });

    function featured_page(element){
        var direction = jQuery(element).data('direction');
        var caregiver = jQuery(element).closest('.caregiver');
        var path = caregiver.data('section');
        jQuery.post(path,{'page':featured, 'direction':direction},function(data){
            //console.log(data);
            data=JSON.parse(data);
            if(data['result']){
                featured = data['page'];
                caregiver.find('.group').fadeOut(function(e){
                    jQuery(this).html(data['html']).fadeIn();
                });
            }
        });
    }
    featured_page('#featured .caregiver .action .icon');
</script>





<section id="kmibox">
    <div class="group contain">
        <div class="section image"></div>
        <div class="section detail">
            <div class="logo"></div>
            <div class="title">Conoce  y elige el plan que <br>mejor te convenga</div>
            <div class="content">Regalale un detalle al consentido de tu hogar!</div>
            <div class="button">Quiero mi KmiBOX</div>
        </div>
    </div>
</section>



<section id="products">
    <div class="kmibox contain" data-section="<?php echo bloginfo('template_directory'); ?>/template/blog/frontend/products.php">
        <div class="action">
            <i class="icon arrow fa fa-caret-left" data-direction="prev"></i>
            <i class="icon arrow fa fa-caret-right" data-direction="next"></i>
        </div>
        <div class="group">
            <?php
                include_once(__DIR__.'/blog/frontend/products.php');
            ?>
        </div>
    </div>
</section>


<footer id="footer">
    <div class="contact">
        <div class="group contain">
            <div class="section redes">
                <i class="icon phone fa fa-facebook"></i>
                <i class="icon phone fa fa-twitter"></i>
                <i class="icon phone fa fa-instagram"></i>
            </div>
            <div class="section menu">
                <div class="item title">Acerca De Nosotros</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
            </div>
            <div class="section menu">
                <div class="item title">Politicas</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
            </div>
            <div class="section menu">
                <div class="item title">Servicio al cliente</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item">item</div>
                <div class="item"><a href="<?php echo site_url(); ?>">www.kmimos.com.mx</a></div>
            </div>
        </div>
    </div>
    <div class="payment">
        <div class="group contain">
            <div class="section title">Métodos de Pago</div>
            <div class="section items">
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-08.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/MasterCard_early_1990s_logo.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/banco-santander.gif');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-11.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-12.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-13.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/ixe.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-15.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-16.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/American_Express_icon-icons.com_60519.png');"></div>
                <div class="item" style="background-image: url('https://www.kmimos.com.mx/wp-content/uploads/2017/06/Para-blog-07.png');"></div>
                <!--div class="item" style="background-image: url('');"></div-->
            </div>
        </div>
    </div>
    <div class="info">
        <div class="contain">
            Copyright &copy; 2017 <span class="logo"></span> Todos Los Derechos Reservados.<br>
            Importante!
        </div>
    </div>
</footer>



<?php
get_footer();
?>
