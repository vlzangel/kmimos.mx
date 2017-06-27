<?php
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
