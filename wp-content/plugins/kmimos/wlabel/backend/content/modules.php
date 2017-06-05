<?php
    global $wpdb;
    $wlabel=$_wlabel_user->wlabel;
    $WLresult=$_wlabel_user->wlabel_result;
?>

<div class="modules">
<pre>
    Número de clientes comprando en un mes.
    Por cliente cuantas noches están comprando por mes.
    Venta de cada persona por mes

    De los clientes
    Número de usuarios registrados (comprando o no)
    Número de usuarios comprando en el mes
    Número de usuarios totales que han comprado (Mes a Mes)

    Por nombre y apellido
    Que está pasando en el mes en curso
    Noche de ventas en el mes
    Servicios adicionales
    Tipo de reserva
</pre>

    <div class="filters">

        <div class="filter">
            <div class="type date" data-type="tddate">
                <div class="month line">
                    <label>Mes</label>
                    <select name="month">
                        <option value="">Seleccionar ...</option>
                        <?php
                        for($month=1; $month<12 ; $month++){
                            echo '<option value="'.$month.'">'.date('F',strtotime(''.$month.'/1/'.date('Y',time()))).'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="year line">
                    <label>Ano</label>
                    <select name="year">
                        <option value="">Seleccionar ...</option>
                        <?php
                        $year_date=date('Y',time());
                        for($year=0; $year<5; $year++){
                            $year_option=$year_date-$year;
                            echo '<option value="'.$year_option.'">'.$year_option.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>


        <div class="filter">
            <div class="type tdshow" data-type="tdcheck">
                <div class="day line">
                    <label>Dias</label>
                    <input type="checkbox" name="day" value="yes"/>
                </div>

                <div class="month line">
                    <label>Mes</label>
                    <input type="checkbox" name="month" value="yes" checked/>
                </div>

                <div class="year line">
                    <label>Ano</label>
                    <input type="checkbox" name="year" value="yes" checked/>
                </div>
            </div>
        </div>
    </div>

<?php
//include_once(dirname(__FILE__).'/modules/booking.php');
//include_once(dirname(__FILE__).'/modules/detail.php');
include_once(dirname(__FILE__).'/modules/client.php');
?>

</div>

