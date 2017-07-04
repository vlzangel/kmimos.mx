<?php
//the_post();
global $post;
$slug=$post->post_name;
$page_current=site_url().'/'.$slug;

$search='';
if(array_key_exists('search',$_POST)){
    $search = $_POST['search'];
}

?>

<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <?php
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';
        wp_head();
        ?>
    </head>

<style>
    a.absolute{position: absolute; width: 100%; height: 100%;  top: 0; left: 0;}
    .contain{position: relative; width: 95%; max-width: 1000px; margin: 0 auto; line-height: 1;}
    .logo{background:url(https://www.kmimos.com.mx/wp-content/uploads/2017/07/bolsita-y-logotipo-02.png) center/contain no-repeat;}
    .blog_title{color: #ff8700; font-size: 35px; font-weight: bold;}
    .icon.arrow{position: relative; width: 50px; padding: 5px 0; margin: 5px 5px; color: #FFF; font-size: 40px; text-align: center; border-radius: 50%; cursor: pointer; background: #900fa2;  }
    .responsive{display: none;}


    @media screen and (max-width:768px), screen and (max-device-width:768px){}
    @media screen and (max-width:480px), screen and (max-device-width:480px){
        .icon.arrow{width:25px; font-size:15px;}
        .blog_title{display:block; text-align:center;}


        /* RESPONSIVE SUGERIDO */
        .blog_title{text-align:left; font-size: 20px;}
        .responsive{display: block;}
    }


    /*HEADER*/
    header .logo{width: 100%; max-width: 500px;  height: 300px; margin: 0 auto;}
    header .info{padding: 10px;  color: #FFF; font-size: 20px;  background: #23d3c4; overflow: hidden;}
    header .info .icon{width: 40px; margin: 0 10px; padding:10px; color: #23d3c4; text-align: center; border-radius: 50%; background: #FFF;}
    header .info .icon.help{float:right; cursor: pointer;}
    header .info .session{padding: 10px; float:right; border-left: 2px solid #FFF;}

    header .redes{position:absolute; width:70px;  right: 0;  top:calc(50% - 150px);}
    header .redes .icon{width: 40px; margin:5px 0; padding:10px; color: #FFF; font-size: 20px; text-align: center; border-radius: 50%; cursor: pointer; background: #23d3c4;}
    header .redes .icon.bolsa{ height: 40px; border-radius: 0; display: block; background:url(https://www.kmimos.com.mx/wp-content/uploads/2017/07/bolsita-y-logotipo-03.png) center/contain no-repeat;}

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
    @media screen and (max-width:480px), screen and (max-device-width:480px){

        /* RESPONSIVE SUGERIDO */
        header .info { display: none;}
        header .info.responsive{position: fixed; width: 100%; top: 0; display: block; overflow: visible; z-index: 1;}
        header .info.responsive .group.contain{width: 100%; font-size:7px; align-items: center; justify-content: flex-end; display: flex; }
        header .info.responsive .session{font-size:12px;}
        header .info.responsive .menu{border: none; display: block !important;}
        header .info.responsive .menu .items.show{border: none; background: #23d3c4;}
        header .info.responsive .menu .items.show .item{color: #FFF;}
        header .info.responsive .search form{padding: 10px 0 0 0; margin: 10px 0 0 0; border-top: 1px solid #FFF;}
        header .info.responsive .search button{color: #FFF; display: inline-flex;}
        header .info .session{width: 60px; padding: 5px; border-left: 2px solid #FFF; }
        header .info .icon{width: 35px; margin: 5px; padding: 10px; font-size: 15px;}
        header .info .icon.help{display: inline-block; float: none;}
        header .info .icon.bar{padding: 0px; color: #FFF; font-size: 30px; cursor: pointer; background: #23d3c4;}
        header .info .icon.search{cursor: pointer; display: inline-block;}
        header .info span{margin: 0 5px; text-align: left; display: flex; align-items: center;}

        header .header{margin-top: 50px;}
        header .logo{width: calc(100% - 100px);}
        header .redes{position: absolute; width: 50px; top: calc(50% - 90px);}
        header .redes .icon{width:32px; font-size:12px;}
        header .redes .icon.bolsa{display: block;}
        header .search{display: none;}
        header .menu{display: none;}
    }
</style>
    <body>
        <header>
            <div class="info">
                <div class="contain">
                    <span>Habla con nosotros</span>
                    <span>
                    <i class="icon phone fa fa-phone"></i>
                    +52 (55) 1791.4931 +52 (55) 6631.9264
                    </span>
                    <div class="session">Inicia Sesion</div>
                    <i class="icon help fa fa-question"></i>
                </div>
            </div>

            <div class="info responsive">
                <div class="group contain">
                    <span>
                    <i class="icon phone fa fa-phone"></i>
                    +52 (55) 1791.4931<br>+52 (55) 6631.9264
                    </span>
                    <i class="icon search fa fa-search"></i>
                    <i class="icon help fa fa-question"></i>
                    <i class="icon bar fa fa-bars"></i>
                    <div class="session">Inicia Sesion</div>
                </div>


                <div class="menu">
                    <div class="items">
                        <div class="item">KMIMOS</div>
                        <div class="item">BENEFICOS</div>
                        <div class="item">FAQ</div>
                        <div class="item">SERVICIOS</div>
                        <div class="item caregiver">QUIERO SER CUIDADOR</div>
                    </div>
                </div>

                <div class="search section">
                    <form  method="post" action="<?php echo $page_current.'#last'; ?>">
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder=""/>
                        <button type="submit"><span class="fa fa-search"></span> BUSCAR</button>
                    </form>
                </div>
            </div>

            <div class="header contain">
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
            //MENU
            jQuery('header .menu .responsive .bar, header .info.responsive .bar').click(function(e){
                responsive_menu(this);
            });

            function responsive_menu(element){
                var items = jQuery(element).closest('header').find('.menu').find('.items');
                if(items.hasClass('show')){
                    items.slideUp().removeClass('show');
                }else{
                    items.slideDown().addClass('show');
                }
            }

            //SEARCH
            jQuery('header .info.responsive .icon.search').click(function(e){
                responsive_search(this);
            });

            function responsive_search(element){
                var search = jQuery(element).closest('.info.responsive').find('.search.section');
                if(search.hasClass('show')){
                    search.slideUp().removeClass('show');
                }else{
                    search.slideDown().addClass('show');
                }
            }
        </script>
