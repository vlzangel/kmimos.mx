<?php
/*
	Template Name: TEMPLATE KMIBOX
*/
?>


<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';
    wp_head();
    ?>
    <style>
        /*KMIBOX*/
        html,
        body{position: relative; width: 100%; height: 100%; background: #FFF; overflow: hidden;}
        body:before{content:""; position: absolute; width: 100%; height: 100%; bottom: 0; left: 0; background:url(https://www.kmimos.com.mx/wp-content/uploads/2017/07/Elementos-01.png) center bottom/contain no-repeat; }

        a.absolute{position: absolute; width: 100%; height: 100%;  top: 0; left: 0;}
        .contain{position: relative; width: 95%; /*max-width: 1000px;*/ margin: 0 auto;}

        section.kmibox{position: relative; height:100%;}
        section.kmibox .contain {height: 100%;}
        section.kmibox .content{color:#83cbbf; font-size:25px; text-align: center; font-weight: normal; line-height: 1.1;  }
        section.kmibox .content strong{font-size:90px;}
        section.kmibox .images{position:absolute; width: 100%; height: 100%; top: 0; left: 0; text-align:center;}
        section.kmibox .images .image{position:absolute; height:100%; bottom:0;}

        section.kmibox .images .group{position:absolute;}
        section.kmibox .images .group1{width: 100%; height: 250px; right: 0; top: 20%; display: none;}
        section.kmibox #img2{right:0px;}
        section.kmibox #img3{left:0px;}

        section.kmibox .images .group2{width: 100%; height: 170px; right: 0; bottom: -14px; margin-bottom:7%;  }
        section.kmibox #img4{left:0px;  bottom:2px;}
        section.kmibox #img5{right:0px;}

        /**/
        body:before{top: 50px;}
        section.kmibox .images {top: 50px;}

        @media screen and (max-width:1024px), screen and (max-device-width:1024px){
            body:before{top: 0px;}
            section.kmibox .images {top: 0px;}
            section.kmibox .images .group2{height: 130px; bottom: -10px; }
        }

        @media screen and (max-width:768px), screen and (max-device-width:768px){
            section.kmibox .content{font-size:15px;}
            section.kmibox .content strong{font-size: 55px;}
            section.kmibox .images .group1{height: 170px;}
            section.kmibox .images .group2{height: 90px; bottom: -6px; }
        }

        @media screen and (max-width:480px), screen and (max-device-width:480px){
            html{background:#666 !important;}
            body{height:70%;}
            /*body:before{background-size: auto 40%;}*/
            section.kmibox .content{padding: 50px 0; font-size:12px;}
            section.kmibox .content strong{font-size: 38px;}
            section.kmibox .images .group2{height: 50px; bottom: -4px; }
        }

    </style>
</head>


<body>
    <section id="kmibox" class="kmibox">
        <div class="contain">
            <div class="content">
                <strong>Pr&oacute;ximamente</strong><br>
                <span>Espera la mejor cajita llena de sorpresas para tu mascota</span>
            </div>
            <div class="images">
                <div class="group group1">
                    <img id="img2" class="image" src="https://www.kmimos.com.mx/wp-content/uploads/2017/07/Elementos-02.png"/>
                    <img id="img3" class="image" src="https://www.kmimos.com.mx/wp-content/uploads/2017/07/Elementos-03.png"/>
                </div>

                <div class="group group2">
                    <img id="img4" class="image" src="https://www.kmimos.com.mx/wp-content/uploads/2017/07/Elementos-03-02.png"/>
                    <img id="img5" class="image" src="https://www.kmimos.com.mx/wp-content/uploads/2017/07/Elementos-03-03.png"/>
                </div>
            </div>
        </div>
    </section>
</body>
</html>