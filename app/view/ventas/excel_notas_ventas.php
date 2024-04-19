

<div class="row">
    <div class="col-lg-12">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0" border="1">
                        <!--filtro para buscar alumno por nombre, apellido y dni-->

                        <h2 style="">HISTORIAL DE NOTAS DE VENTAS || FECHA : <strong><?= $fecha_vacio; ?></strong></h2>

                        <thead class="text-capitalize">
                        <br><br>
                        <tr style="background: deepskyblue;">
                            <th>#</th>
                            <th>COMPROBANTE</th>
                            <th>SERIE</th>
                            <th>CORRELATIVO</th>
                            <th>CLIENTE DOC</th>
                            <th>CLIENTE NOMBRE</th>
                            <th>FECHA DE CREACION</th>
                            <th>USUARIO</th>
                            <th>MONEDA</th>
                            <th>TOTAL</th>
                            <th>ANULADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        $total = 0;
                        $total_eliminado = 0;
                        foreach ($ventas as $m){
                            if($m->anulado_sunat == 1){
                                $total_eliminado = round($total_eliminado + $m->venta_total, 2);
                            }

                            if($m->anulado_sunat == 0){
                                $total = round($total + $m->venta_total, 2);
                            }

                            if($m->id_tipodocumento == 4){
                                $cliente = $m->cliente_razonsocial;
                            }else{
                                $cliente = $m->cliente_nombre;
                            }
                            $venta_tipo = "NOTA DE VENTA";
                            $stylee= "style='text-align: center;'";
                            if($m->anulado_sunat == 1){
                                $stylee="style= 'text-align: center; background-color: #FF6B70'";
                                //$total = $total;
                                $anulado = "SI";
                            }else{
                                //$total = $total + $m->venta_total;
                                $anulado = "NO";
                            }
                            $nombre_usuario = $m->persona_nombre. ' ' .$m->persona_apellido_paterno. ' ' .$m->persona_apellido_materno;
                            ?>
                            <tr <?=$stylee?>>
                                <td style="display: none"><?= $a;?></td>
                                <td style="display: none"><?= utf8_decode($venta_tipo);?></td>
                                <td style="display: none"><?= $m->venta_serie;?></td>
                                <td style="display: none"><?= $m->venta_correlativo;?></td>
                                <td style="display: none"><?= utf8_decode($m->cliente_numero);?></td>
                                <td style="display: none"><?= utf8_decode($cliente);?></td>
                                <td style="display: none"><?= date('d-m-Y h:i:s', strtotime($m->venta_fecha));?></td>
                                <td style="display: none"><?= utf8_decode($nombre_usuario);?></td>
                                <td style="display: none"><?= utf8_decode($m->abrstandar);?></td>
                                <td>S/. <?= number_format($m->venta_total,2);?></td>
                                <td style="display: none"><?= $anulado;?></td>
                            </tr>

                            <?php
                            $a++;
                        }
                        ?>
                        </tbody>
                        <tfooter>
                            <tr>
                                <td></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">TOTAL:</td>
                                <td style="text-align: center;">S/. <?= number_format($total,2);?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">T. ELIMINADO:</td>
                                <td style="text-align: center;">S/. <?= number_format($total_eliminado,2);?></td>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>